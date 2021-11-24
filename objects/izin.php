<?php

// MEMBUAT OBJEK 'izin' UNTUK TABEL IZIN
class Izin {
 
    private $conn;
    private $table_name = "izin";
 
    // OBJEK
    public $nim;
    public $waktuIzinAwal;
    public $waktuIzinAkhir;
    public $keterangan;
    // public $waktu_izin;
    public $tanggal_izin;
 
    // KONSTRUKTOR
    public function __construct($db) {
        $this->conn = $db;
		date_default_timezone_set('Asia/Jakarta');
    }

    //  FUNGSI SELECT ALL DATA
    function retrieve() {

        // QUERY SELECT DATA IZIN
        $query      = "SELECT izin.* , asisten.nama FROM " . $this->table_name . " INNER JOIN asisten ON izin.nim = asisten.nim WHERE izin.tanggal_izin= :tanggal_izin ORDER BY izin.nim";
        $query2     = "SELECT count(izin.nim) as asistenIzin FROM izin INNER JOIN asisten ON asisten.nim = izin.nim WHERE tanggal_izin= :tanggal_izin AND (asisten.jabatan = 'Supervisor' OR asisten.jabatan = 'Asisten') ";
        $query3     = "SELECT count(izin.nim) as calonAsistenIzin FROM izin INNER JOIN asisten ON asisten.nim = izin.nim WHERE tanggal_izin= :tanggal_izin AND asisten.jabatan = 'Calon Asisten' ";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
        $statement2 = $this->conn->prepare( $query2 );
        $statement3 = $this->conn->prepare( $query3 );

        // SANITIZE
        if(!empty($this->tanggal_izin)) {
            $this->tanggal_izin = htmlspecialchars(strip_tags($this->tanggal_izin));
        }
        else {
            $this->tanggal_izin = date("Y-m-d");
        }

        // MENGUNCI PARAMETER
        $statement->bindParam(':tanggal_izin', $this->tanggal_izin);
        $statement2->bindParam(':tanggal_izin', $this->tanggal_izin);
        $statement3->bindParam(':tanggal_izin', $this->tanggal_izin);

        // EXECUTE STATEMENT
        $statement->execute();
        $statement2->execute();
        $statement3->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->result2  = $statement2->fetchColumn();
        $this->result3  = $statement3->fetchColumn();

        return true;
    }

    function asistenIzin() {
        $flag   = 0;

        // QUERY INSERT WAKTU DATANG
        $query  = "INSERT INTO ".$this->table_name." SET tanggal_izin = :tanggal_izin, nim = :nim, keterangan = :keterangan";
                    
        // PREPARE STATEMENT
        $statement = $this->conn->prepare($query);

        if(!empty($this->waktuIzinAkhir)) {
            $waktuAwal  = strtotime($this->waktuIzinAwal);
            $waktuAkhir = strtotime($this->waktuIzinAkhir);
            
            $intervalDay    = $waktuAkhir - $waktuAwal;
            $getInterval    = round($intervalDay / (60*60*24));

            for($i = 0; $i <= $getInterval; $i++) {

                // SANITIZE
                $this->nim              = htmlspecialchars(strip_tags($this->nim));
                $this->keterangan       = htmlspecialchars(strip_tags($this->keterangan));
                $this->tanggal_izin     = htmlspecialchars(strip_tags($this->waktuIzinAwal));

                // MENGUNCI PARAMETER
                $statement->bindParam(':nim', $this->nim);
                $statement->bindParam(':tanggal_izin', $this->tanggal_izin);
                $statement->bindParam(':keterangan', $this->keterangan);

                $incrementDate          = strtotime('+1 day', strtotime($this->waktuIzinAwal));
                $this->waktuIzinAwal    = date('Y-m-d', $incrementDate);

                // EXECUTE STATEMENT
                if($statement->execute()) {
                    $flag = 1;
                }
            }
        }
        else {
            // SANITIZE
            $this->nim              = htmlspecialchars(strip_tags($this->nim));
            $this->keterangan       = htmlspecialchars(strip_tags($this->keterangan));
            $this->tanggal_izin     = htmlspecialchars(strip_tags($this->waktuIzinAwal));
            
            // MENGUNCI PARAMETER
            $statement->bindParam(':nim', $this->nim);
            $statement->bindParam(':tanggal_izin', $this->tanggal_izin);
            $statement->bindParam(':keterangan', $this->keterangan);
        
            // EXECUTE STATEMENT
            if($statement->execute()) {
                $flag = 1;
            }
        }

        if($flag == 1) {
            return true;
        }
        
        return false;
    }

    // RETRIEVE SINGLE DETAIL LENGKAP DATA IZIN 
    function retrieveUser() {
        // QUERY SELECT DATA IZIN
        $query      = " SELECT
                            `asisten`.`nim`,
                            `asisten`.`nama`,
                            `izin`.`keterangan`
                        FROM
                            `izin`
                        INNER JOIN 
                            `asisten` ON `izin`.`nim` = `asisten`.`nim` 
                        WHERE izin.tanggal_izin= :tanggal_izin AND asisten.nim= :nim LIMIT 0,1";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
        
        // SANITIZE
        $this->tanggal_izin     = date("Y-m-d");
        $this->nim              = htmlspecialchars(strip_tags($this->nim));

        // MENGUNCI PARAMETER
        $statement->bindParam(':tanggal_izin', $this->tanggal_izin);
        $statement->bindParam(':nim', $this->nim);

        // EXECUTE STATEMENT
        $statement->execute();

        // MENGHITUNG JUMLAH BARIS
        $num    = $statement->rowCount();
    
        // JIKA NIM ADA
        if($num>0) {
    
            // MENDAPATKAN RECORD DETAIL
            $row = $statement->fetch(PDO::FETCH_ASSOC);
    
            // MENEMPATKAN VALUE KE DALAM OBJEK
            $this->nim              = $row['nim'];
            $this->nama             = $row['nama'];
            $this->keterangan       = $row['keterangan'];
    
            return true;
        }
    
        return false;
    }

    // FUNGSI UBAH KETERANGAN IZIN ASISTEN
    function update() {
        
        // QUERY UPDATE
        $query = "UPDATE " . $this->table_name . " SET keterangan = :keterangan WHERE tanggal_izin= :tanggal_izin AND nim = :nim";
    
        // PERPARE STATEMENT
        $statement = $this->conn->prepare($query);
    
        // SANITIZE
        $this->keterangan       = htmlspecialchars(strip_tags($this->keterangan));
        $this->tanggal_izin     = date("Y-m-d");
    
        // MENGUNCI PARAMETER
        $statement->bindParam(':keterangan', $this->keterangan);
    
        // MENGUNCI PARAMETER NIM UNTUK MENGUBAH DATA
        $statement->bindParam(':nim', $this->nim);
        $statement->bindParam(':tanggal_izin', $this->tanggal_izin);

        // EXECUTE STATEMENT
        if($statement->execute()){
            return true;
        }
    
        return false;
    }

    // FUNGSI UNTUK HAPUS RECORD
    function delete(){
    
        // QUERY DELETE
        $query = "DELETE FROM " . $this->table_name . " WHERE tanggal_izin= :tanggal_izin AND nim = :nim";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim          = htmlspecialchars(strip_tags($this->nim));
        $this->tanggal_izin = date("Y-m-d");
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(':nim', $this->nim);
        $statement->bindParam(':tanggal_izin', $this->tanggal_izin);
    
        // EXECUTE STATEMENT
        if($statement->execute()){
            return true;
        }
    
        return false;
    }

    // HITUNG JUMLAH IZIN HARI INI
    function countIzin() {
        $query     = "  SELECT count(izin.nim) 
                        FROM " . $this->table_name . " 
                        INNER JOIN asisten ON asisten.nim = izin.nim WHERE 
                        tanggal_izin=CURDATE() AND 
                        ( asisten.jabatan = 'Supervisor' OR 
                        asisten.jabatan = 'Asisten' )";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchColumn();

        return true;
    }

    // HITUNG JUMLAH IZIN HARI INI
    function countCalonAsistenIzin() {
        $query     = "  SELECT count(izin.nim) 
                        FROM " . $this->table_name . " 
                        INNER JOIN asisten ON asisten.nim = izin.nim WHERE 
                        tanggal_izin=CURDATE() AND 
                        asisten.jabatan = 'Calon Asisten'";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchColumn();

        return true;
    }

    //  FUNGSI SELECT ALL DATA ASISTEN AKTIF
    function retrieveAktif() {
        
        // QUERY SELECT NIM
        $query      = "SELECT * FROM asisten WHERE status = 'aktif' ORDER BY nim DESC";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }
}