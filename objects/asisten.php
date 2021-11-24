<?php

// MEMBUAT OBJEK 'asisten' UNTUK TABEL ASISTEN
class Asisten {
 
    private $conn;
    private $table_name = "asisten";
 
    // OBJEK
    public $nim;
    public $nama;
    public $fakultas;
    public $jurusan;
    public $jenis_kelamin;
    public $surel;
    public $no_telp;
    public $jabatan;
    public $kata_sandi;
    public $imei;
 
    // KONSTRUKTOR
    public function __construct($db) {
        $this->conn = $db;
    }
 
    // FUNGSI UNTUK MEMBUAT RECORD BARU
    function create() {
    
        // QUERY INSERT
        $query = "INSERT INTO ".$this->table_name." SET nim = :nim, nama = :nama, fakultas = :fakultas, jurusan = :jurusan, jenis_kelamin = :jenis_kelamin, surel = :surel, no_telp = :no_telp, jabatan = :jabatan, kata_sandi = :kata_sandi, imei= :imei, status= :status";
    
        // PREPARE STATEMENT
        $statement = $this->conn->prepare($query);
    
        // SANITIZE
        $this->nim              = htmlspecialchars(strip_tags($this->nim));
        $this->nama             = htmlspecialchars(strip_tags($this->nama));
        $this->fakultas         = htmlspecialchars(strip_tags($this->fakultas));
        $this->jurusan          = htmlspecialchars(strip_tags($this->jurusan));
        $this->jenis_kelamin    = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->surel            = htmlspecialchars(strip_tags($this->surel));
        $this->no_telp          = htmlspecialchars(strip_tags($this->no_telp));
        $this->jabatan          = htmlspecialchars(strip_tags($this->jabatan));
        $this->kata_sandi       = htmlspecialchars(strip_tags($this->kata_sandi));
        $this->imei             = htmlspecialchars(strip_tags($this->imei));
        $this->status           = htmlspecialchars(strip_tags($this->status));
    
        // MENGUNCI PARAMETER
        $statement->bindParam(':nim', $this->nim);
        $statement->bindParam(':nama', $this->nama);
        $statement->bindParam(':fakultas', $this->fakultas);
        $statement->bindParam(':jurusan', $this->jurusan);
        $statement->bindParam(':jenis_kelamin', $this->jenis_kelamin);
        $statement->bindParam(':surel', $this->surel);
        $statement->bindParam(':no_telp', $this->no_telp);
        $statement->bindParam(':jabatan', $this->jabatan);
        $statement->bindParam(':imei', $this->imei);
        $statement->bindParam(':status', $this->status);
    
        // ENCRIPT kata_sandi SEBELUM MEMASUKKAN KE DALAM DB
        $kata_sandi_hash = password_hash($this->kata_sandi, PASSWORD_BCRYPT);
        $statement->bindParam(':kata_sandi', $kata_sandi_hash);
        
        // EXECUTE STATEMENT
        if($statement->execute()){
            return true;
        }
    
        return false;
    }
 
    //  FUNGSI SELECT ALL DATA
    function retrieve() {
        
        // QUERY SELECT NIM
        $query      = "SELECT * FROM " . $this->table_name . " ORDER BY status ASC, nim DESC";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    //  FUNGSI SELECT ALL DATA ASISTEN AKTIF
    function retrieveAktif() {
        
        // QUERY SELECT NIM
        $query      = "SELECT * FROM " . $this->table_name . " WHERE status = 'aktif' AND (jabatan = 'Supervisor' OR jabatan = 'Asisten') ORDER BY nim DESC";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    //  FUNGSI SELECT ALL DATA CALON ASISTEN AKTIF
    function retrieveCalasAktif() {
        
        // QUERY SELECT NIM
        $query      = "SELECT * FROM " . $this->table_name . " WHERE status = 'aktif' AND jabatan = 'Calon Asisten' ORDER BY nim DESC";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    // FUNGSI CEK VALID ATAU TIDAKNYA IMEI YANG AKAN MASUK KE SISTEM
    function imeiValid() {

        // QUERY SELECT IMEI
        $query      = "SELECT imei FROM " . $this->table_name . " WHERE nim = ? LIMIT 0,1";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim  = htmlspecialchars(strip_tags($this->nim));
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(1, $this->nim);
    
        // EXECUTE STATEMENT
        $statement->execute();
    
        // MENGHITUNG JUMLAH BARIS
        $num    = $statement->rowCount();
    
        // JIKA NIM ADA
        if($num>0) {
            
            // SANITIZE
            $this->imei  = htmlspecialchars(strip_tags($this->imei));
            // MENDAPATKAN RECORD IMEI
            $row = $statement->fetch(PDO::FETCH_ASSOC);
    
            // CEK VALID ATAU TIDAKNYA IMEI
            if($this->imei == $row['imei']) {
                return true;
            }
        }
    
        return false;
    }

    //  FUNGSI CEK ADA ATAU TIDAKNYA NIM
    function nimExists() {
    
        // QUERY SELECT NIM
        $query      = "SELECT nama, jabatan, kata_sandi  FROM " . $this->table_name . " WHERE nim = ? LIMIT 0,1";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim  = htmlspecialchars(strip_tags($this->nim));
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(1, $this->nim);
    
        // EXECUTE STATEMENT
        $statement->execute();
    
        // MENGHITUNG JUMLAH BARIS
        $num    = $statement->rowCount();
    
        // JIKA NIM ADA
        if($num>0) {
    
            // MENDAPATKAN RECORD DETAIL
            $row = $statement->fetch(PDO::FETCH_ASSOC);
    
            // MENEMPATKAN VALUE KE DALAM OBJEK
            $this->nama         = $row['nama'];
            $this->jabatan      = $row['jabatan'];
            $this->kata_sandi   = $row['kata_sandi'];
    
            return true;
        }
    
        return false;
    }

    //  FUNGSI UNTUK MENDAPATKAN DATA USER BERDASARKAN NIM
    function getUserData() {
    
        // QUERY SELECT NIM
        $query      = "SELECT * FROM " . $this->table_name . " WHERE nim = ? LIMIT 0,1";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim  = htmlspecialchars(strip_tags($this->nim));
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(1, $this->nim);
    
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
            $this->status           = $row['status'];
            $this->fakultas         = $row['fakultas'];
            $this->jurusan          = $row['jurusan'];
            $this->jenis_kelamin    = $row['jenis_kelamin'];
            $this->surel            = $row['surel'];
            $this->no_telp          = $row['no_telp'];
            $this->jabatan          = $row['jabatan'];
            $this->imei             = $row['imei'];
    
            return true;
        }
    
        return false;
    }
    
    // FUNGSI UNTUK UPDATE RECORD
    function update(){
    
        // CEK JIKA kata_sandi PERLU DIUBAH ATAU TIDAK
        $kata_sandi_set   = !empty($this->kata_sandi) ? ", kata_sandi = :kata_sandi" : "";
    
        // QUERY UPDATE
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, jenis_kelamin = :jenis_kelamin, surel = :surel, no_telp = :no_telp, jabatan = :jabatan {$kata_sandi_set} ,imei= :imei WHERE nim = :nim";
    
        // PERPARE STATEMENT
        $statement = $this->conn->prepare($query);
    
        // SANITIZE
        $this->nama             = htmlspecialchars(strip_tags($this->nama));
        $this->jenis_kelamin    = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->surel            = htmlspecialchars(strip_tags($this->surel));
        $this->no_telp          = htmlspecialchars(strip_tags($this->no_telp));
        $this->jabatan          = htmlspecialchars(strip_tags($this->jabatan));
        $this->imei             = htmlspecialchars(strip_tags($this->imei));
    
        // MENGUNCI PARAMETER
        $statement->bindParam(':nama', $this->nama);
        $statement->bindParam(':jenis_kelamin', $this->jenis_kelamin);
        $statement->bindParam(':surel', $this->surel);
        $statement->bindParam(':no_telp', $this->no_telp);
        $statement->bindParam(':jabatan', $this->jabatan);
        $statement->bindParam(':imei', $this->imei);
    
        // ENCRIPT kata_sandi SEBELUM MEMASUKKAN KE DALAM DB
        if(!empty($this->kata_sandi)){
            $this->kata_sandi = htmlspecialchars(strip_tags($this->kata_sandi));
            $kata_sandi_hash  = password_hash($this->kata_sandi, PASSWORD_BCRYPT);
            $statement->bindParam(':kata_sandi', $kata_sandi_hash);
        }
    
        // MENGUNCI PARAMETER NIM UNTUK MENGUBAH DATA
        $statement->bindParam(':nim', $this->nim);

        // EXECUTE STATEMENT
        if($statement->execute()){
            return true;
        }
    
        return false;
    }

    // FUNGSI UNTUK HAPUS RECORD
    function delete(){
    
        // QUERY DELETE
        $query = "DELETE FROM " . $this->table_name . " WHERE nim = :nim";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim  = htmlspecialchars(strip_tags($this->nim));
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(':nim', $this->nim);
    
        // EXECUTE STATEMENT
        if($statement->execute()){
            return true;
        }
    
        return false;
    }

    // FUNGSI UBAH STATUS ASISTEN
    function changeStatus(){

        // QUERY SELECT NIM
        $query      = "SELECT status FROM " . $this->table_name . " WHERE nim = ? LIMIT 0,1";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim  = htmlspecialchars(strip_tags($this->nim));
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(1, $this->nim);
    
        // EXECUTE STATEMENT
        $statement->execute();
    
        // MENGHITUNG JUMLAH BARIS
        $num    = $statement->rowCount();
    
        // JIKA NIM ADA
        if($num>0) {
    
            // MENDAPATKAN RECORD DETAIL
            $row = $statement->fetch(PDO::FETCH_ASSOC);
    
            // MENEMPATKAN VALUE KE DALAM OBJEK
            $this->status           = $row['status'];

            // QUERY UPDATE
            $query2 = "UPDATE " . $this->table_name . " SET status = :status WHERE nim = :nim";
        
            // PERPARE STATEMENT2
            $statement2 = $this->conn->prepare($query2);
        
            // SANITIZE
            if($this->status == "Aktif") {
                $this->status = htmlspecialchars(strip_tags("Tidak Aktif"));
            }
            else {
                $this->status = htmlspecialchars(strip_tags("Aktif"));
            }
        
            // MENGUNCI PARAMETER
            $statement2->bindParam(':status', $this->status);
            $statement2->bindParam(':nim', $this->nim);

            // EXECUTE STATEMENT2
            if($statement2->execute()){
                return true;
            }

            return false;
        }
    
        return false;
    }

    // HITUNG JUMLAH ASISTEN AKTIF
    function countAsistenAktif() {
        $query     = "SELECT count(nim) FROM  " . $this->table_name . "  WHERE status='aktif' AND (jabatan = 'Supervisor' OR jabatan = 'Asisten') ";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchColumn();

        return true;
    }

    // HITUNG JUMLAH CALAS AKTIF
    function countCalonAsistenAktif() {
        $query     = "SELECT count(nim) FROM  " . $this->table_name . "  WHERE status='aktif' AND jabatan = 'Calon Asisten' ";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchColumn();

        return true;
    }

    // TAMPIL ASISTEN PER JURUSAN
    function getJurusanAsisten() {
        $query     = "SELECT jurusan FROM  " . $this->table_name . "  WHERE status='aktif'";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    // TAMPIL ASISTEN PER JENIS KELAMIN
    function getJenKelAsisten() {
        $query     = "SELECT jenis_kelamin FROM  " . $this->table_name . "  WHERE status='aktif'";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    // TAMPIL ASISTEN PER TAHUN
    function getTahunAsisten() {
        $query     = "SELECT nim FROM  " . $this->table_name . "  WHERE status='aktif'";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    // TAMPIL ASISTEN PER JABATAN
    function getJabatanAsisten() {
        $query     = "SELECT jabatan FROM  " . $this->table_name . "  WHERE status='aktif'";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }
}