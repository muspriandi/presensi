<?php

// MEMBUAT OBJEK 'presensi' UNTUK TABEL PRESENSI
class Presensi {
 
    private $conn;
    private $table_name = "presensi";
 
    // OBJEK
    public $tanggal_presensi;
    public $nim;
    public $waktu_datang;
    public $waktu_pulang;
 
    // KONSTRUKTOR
    public function __construct($db) {
        $this->conn = $db;
		date_default_timezone_set('Asia/Jakarta');
    }

    //  FUNGSI PRESENSI
    function presensi() {
    
        // CEK APAKAH PRESENSI UNTUK DATANG ATAU PULANG
        $query      = "SELECT waktu_datang,waktu_pulang FROM " . $this->table_name . " WHERE nim = ? AND tanggal_presensi = ? LIMIT 0,1";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim              = htmlspecialchars(strip_tags($this->nim));
        $this->tanggal_presensi = date("Y-m-d");
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(1, $this->nim);
        $statement->bindParam(2, $this->tanggal_presensi);
    
        // EXECUTE STATEMENT
        $statement->execute();
    
        // MENGHITUNG JUMLAH BARIS
        $num    = $statement->rowCount();
    
        // JIKA ADA
        if($num>0) {

            // PRESENSI PULANG

            // DUNGSI CEK LAMA KERJA DI LAB
            function minusTime($timeA, $timeB)
            {
                $timeAcomponents    = explode(":", $timeA);
                $timeBcomponents    = explode(":", $timeB);
                $timeAinMinute      = $timeAcomponents[0] * 60 + $timeAcomponents[1];
                $timeBinMinute      = $timeBcomponents[0] * 60 + $timeBcomponents[1];
                $timeABinMinute     = $timeAinMinute - $timeBinMinute;

                return $timeABinMinute;
            }

            // MENDAPATKAN RECORD WAKTU DATANG DAN WAKTU PULANG
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            $hari   = date("D");
            $pulang = date("H:i:s");

            // RULE PRSENSI UNTUK HARI SENIN SAMPAI JUMAT
            if ($hari != 'Sat' && $hari != 'Sun') {

                if ($pulang >= 16 && minusTime($pulang, $row['waktu_datang']) >= 480) {

                    if ($row['waktu_pulang'] == null) {

                        // QUERY UPDATE WAKTU PULANG
                        $query = "UPDATE ".$this->table_name." SET waktu_pulang = :waktu_pulang WHERE tanggal_presensi = :tanggal_presensi AND nim = :nim";
                    
                        // PREPARE STATEMENT
                        $statement = $this->conn->prepare($query);

                        // SANITIZE
                        $this->waktu_pulang     = date("H:i:s");
                    
                        // MENGUNCI PARAMETER
                        $statement->bindParam(':waktu_pulang', $this->waktu_pulang);
                        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
                        $statement->bindParam(':nim', $this->nim);
                    
                        // EXECUTE STATEMENT
                        if($statement->execute()){
                            $pesan  = die( json_encode(
                                array(
                                    "message" => "Presesi Pulang Berhasil. Hati-hati di Jalan!",
                                    "success" => 1
                                )
                            ));

                            return $pesan;
                        }
                    }
                    else {
                        $pesan  = die( json_encode(
                            array(
                                "message" => "Anda Telah Melakukan Presensi Pulang. Presesi Gagal!",
                                "success" => 0
                            )
                        ));

                        return $pesan;
                    }
                }
                else {
                    $pesan  = die( json_encode(
                        array(
                            "message" => "Belum Waktunya Pulang atau Anda Kurang Dari 8 Jam di Lab. Presesi Gagal!",
                            "success" => 0
                        )
                    ));

                    return $pesan;
                }
            }
            else {
                if (minusTime($pulang, $row['waktu_datang']) >= 240) {

                    if ($row['waktu_pulang'] == null) {
                        // QUERY UPDATE WAKTU PULANG
                        $query = "UPDATE ".$this->table_name." SET waktu_pulang = :waktu_pulang WHERE tanggal_presensi = :tanggal_presensi AND nim = :nim";
                    
                        // PREPARE STATEMENT
                        $statement = $this->conn->prepare($query);

                        // SANITIZE
                        $this->waktu_pulang     = date("H:i:s");
                    
                        // MENGUNCI PARAMETER
                        $statement->bindParam(':waktu_pulang', $this->waktu_pulang);
                        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
                        $statement->bindParam(':nim', $this->nim);
                    
                        // EXECUTE STATEMENT
                        if($statement->execute()){
                            $pesan  = die( json_encode(
                                array(
                                    "message" => "Presesi Berhasil. Hati-hati di Jalan!",
                                    "success" => 1
                                )
                            ));

                            return $pesan;
                        }
                    }
                    else {
                        $pesan  = die( json_encode(
                            array(
                                "message" => "Anda Telah Melakukan Presensi Pulang. Presesi Gagal!",
                                "success" => 0
                            )
                        ));

                        return $pesan;
                    }
                }
                else {
                    $pesan  = die( json_encode(
                        array(
                            "message" => "Belum Waktunya Pulang atau Anda Kurang Dari 4 Jam di Lab. Presesi Gagal!",
                            "success" => 0
                        )
                    ));

                    return $pesan;
                }
            }
        }
        else {

            // PRESENSI DATANG
            $hari   = date("D");
            $datang = date("H:i:s");

            // RULE PRSENSI UNTUK HARI SENIN SAMPAI JUMAT
            if ($hari != 'Sat' && $hari != 'Sun') {

                if ($datang <= 5) {
                    $pesan  = die( json_encode(
                        array(
                            "message" => "Waktu Presensi Belum Dimulai. Presesi Gagal!",
                            "success" => 0
                        )
                    ));

                    return $pesan;
                } 
                else {
                    if ($datang >= 10) {
                        $pesan  = die( json_encode(
                                        array(
                                            "message" => "Anda Sudah Terlambat. Presesi Gagal!",
                                            "success" => 0
                                        )
                                    ));

                        return $pesan;
                    }
                    else {
                        // QUERY INSERT WAKTU DATANG
                        $query = "INSERT INTO ".$this->table_name." SET tanggal_presensi = :tanggal_presensi, nim = :nim, waktu_datang = :waktu_datang, waktu_pulang = :waktu_pulang";
                    
                        // PREPARE STATEMENT
                        $statement = $this->conn->prepare($query);
        
                        // SANITIZE
                        $this->waktu_datang     = date("H:i:s");
                        $this->waktu_pulang     = null;
                    
                        // MENGUNCI PARAMETER
                        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
                        $statement->bindParam(':nim', $this->nim);
                        $statement->bindParam(':waktu_datang', $this->waktu_datang);
                        $statement->bindParam(':waktu_pulang', $this->waktu_pulang);
                    
                        // EXECUTE STATEMENT
                        if($statement->execute()){
                            $pesan  = die( json_encode(
                                array(
                                    "message" => "Presesi Berhasil. Selamat bekerja!",
                                    "success" => 1
                                )
                            ));

                            return $pesan;
                        }
                    }
                }
            }
            // RULE PRESENSI DI HARI SABTU
            else {

                if ($hari == 'Sun') {
                    $pesan  = die( json_encode(
                        array(
                            "message" => "Hari Ini Libur. Presesi Gagal!",
                            "success" => 0
                        )
                    ));

                    return $pesan;
                } 
                else {
                    // QUERY INSERT WAKTU DATANG
                    $query = "INSERT INTO ".$this->table_name." SET tanggal_presensi = :tanggal_presensi, nim = :nim, waktu_datang = :waktu_datang, waktu_pulang = :waktu_pulang";
                
                    // PREPARE STATEMENT
                    $statement = $this->conn->prepare($query);
        
                    // SANITIZE
                    $this->waktu_datang     = date("H:i:s");
                    $this->waktu_pulang     = null;
                
                    // MENGUNCI PARAMETER
                    $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
                    $statement->bindParam(':nim', $this->nim);
                    $statement->bindParam(':waktu_datang', $this->waktu_datang);
                    $statement->bindParam(':waktu_pulang', $this->waktu_pulang);
                
                    // EXECUTE STATEMENT
                    if($statement->execute()){
                        $pesan  = die( json_encode(
                            array(
                                "message" => "Presesi Berhasil. Selamat bekerja!",
                                "success" => 1
                            )
                        ));

                        return $pesan;
                    }
                }
            }
        }
    }

    //  FUNGSI SELECT ALL DATA ASISTEN
    function retrieve() {

        // QUERY SELECT DATA PRESENSI
        $query      = "SELECT presensi.* , asisten.nama FROM " . $this->table_name . " INNER JOIN asisten ON presensi.nim = asisten.nim WHERE presensi.tanggal_presensi= :tanggal_presensi AND (asisten.jabatan = 'Supervisor' OR asisten.jabatan = 'Asisten') ORDER BY presensi.waktu_datang";
        $query2     = "SELECT count(asisten.nim) as jmlAsistenAktif FROM asisten WHERE status='aktif' AND (jabatan = 'Supervisor' OR jabatan = 'Asisten') ";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
        $statement2 = $this->conn->prepare( $query2 );

        // SANITIZE
        if(!empty($this->tanggal_presensi)) {
            $this->tanggal_presensi = htmlspecialchars(strip_tags($this->tanggal_presensi));
        }
        else {
            $this->tanggal_presensi = date("Y-m-d");
        }

        // MENGUNCI PARAMETER
        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);

        // EXECUTE STATEMENT
        $statement->execute();
        $statement2->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->result2  = $statement2->fetchColumn();

        return true;
    }

    //  FUNGSI SELECT ALL DATA CALAS
    function retrieveCalas() {

        // QUERY SELECT DATA PRESENSI
        $query      = "SELECT presensi.* , asisten.nama FROM " . $this->table_name . " INNER JOIN asisten ON presensi.nim = asisten.nim WHERE presensi.tanggal_presensi= :tanggal_presensi AND asisten.jabatan = 'Calon Asisten' ORDER BY presensi.waktu_datang";
        $query2     = "SELECT count(asisten.nim) as jmlAsistenAktif FROM asisten WHERE status='aktif' AND jabatan = 'Calon Asisten' ";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
        $statement2 = $this->conn->prepare( $query2 );

        // SANITIZE
        if(!empty($this->tanggal_presensi)) {
            $this->tanggal_presensi = htmlspecialchars(strip_tags($this->tanggal_presensi));
        }
        else {
            $this->tanggal_presensi = date("Y-m-d");
        }

        // MENGUNCI PARAMETER
        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);

        // EXECUTE STATEMENT
        $statement->execute();
        $statement2->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->result2  = $statement2->fetchColumn();

        return true;
    }

    // RETRIEVE SINGLE DATA PRESENSI
    function retrievePerUser() {
        // QUERY SELECT DATA PRESENSI
        $query      = "SELECT waktu_datang, waktu_pulang FROM presensi WHERE tanggal_presensi= :tanggal_presensi AND nim= :nim LIMIT 0,1";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
        
        // SANITIZE
        $this->tanggal_presensi = date("Y-m-d");
        $this->nim              = htmlspecialchars(strip_tags($this->nim));

        // MENGUNCI PARAMETER
        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
        $statement->bindParam(':nim', $this->nim);

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    // RETRIEVE SINGLE DETAIL LENGKAP DATA PRESENSI 
    function retrieveUser() {
        // QUERY SELECT DATA PRESENSI
        $query      = " SELECT
                            presensi.waktu_datang,
                            presensi.waktu_pulang,
                            asisten.nama,
                            asisten.nim
                        FROM
                            presensi
                        INNER JOIN
                            asisten ON presensi.nim = asisten.nim
                        WHERE presensi.tanggal_presensi= :tanggal_presensi AND asisten.nim= :nim LIMIT 0,1";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
        
        // SANITIZE
        $this->tanggal_presensi = date("Y-m-d");
        $this->nim              = htmlspecialchars(strip_tags($this->nim));

        // MENGUNCI PARAMETER
        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
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
            $this->waktu_datang     = $row['waktu_datang'];
            $this->waktu_pulang     = $row['waktu_pulang'];
    
            return true;
        }
    
        return false;
    }

    // FUNGSI UBAH WAKTU DATANG PRESENSI ASISTEN
    function update() {
        
        // QUERY UPDATE
        $query = "UPDATE " . $this->table_name . " SET waktu_datang = :waktu_datang, waktu_pulang = :waktu_pulang WHERE tanggal_presensi= :tanggal_presensi AND nim = :nim";
    
        // PERPARE STATEMENT
        $statement = $this->conn->prepare($query);
    
        // SANITIZE
        $this->waktu_datang     = htmlspecialchars(strip_tags($this->waktu_datang));
        $this->waktu_pulang     = ($this->waktu_pulang != "-") ? $this->waktu_pulang : NULL;
        $this->tanggal_presensi = date("Y-m-d");
    
        // MENGUNCI PARAMETER
        $statement->bindParam(':waktu_datang', $this->waktu_datang);
        $statement->bindParam(':waktu_pulang', $this->waktu_pulang);
    
        // MENGUNCI PARAMETER NIM UNTUK MENGUBAH DATA
        $statement->bindParam(':nim', $this->nim);
        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);

        // EXECUTE STATEMENT
        if($statement->execute()){
            return true;
        }
    
        return false;
    }

    // FUNGSI UNTUK HAPUS RECORD
    function delete(){
    
        // QUERY DELETE
        $query = "DELETE FROM " . $this->table_name . " WHERE tanggal_presensi= :tanggal_presensi AND nim = :nim";
    
        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );
    
        // SANITIZE
        $this->nim  = htmlspecialchars(strip_tags($this->nim));
        $this->tanggal_presensi = date("Y-m-d");
    
        // MENGUNCI PARAMETER NIM
        $statement->bindParam(':nim', $this->nim);
        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
    
        // EXECUTE STATEMENT
        if($statement->execute()){
            return true;
        }
    
        return false;
    }

    function checkIn() {

        // QUERY INSERT WAKTU DATANG
        $query = "INSERT INTO ".$this->table_name." SET tanggal_presensi = :tanggal_presensi, nim = :nim, waktu_datang = :waktu_datang, waktu_pulang = :waktu_pulang";
                    
        // PREPARE STATEMENT
        $statement = $this->conn->prepare($query);

        // SANITIZE
        $this->nim              = htmlspecialchars(strip_tags($this->nim));
        $this->tanggal_presensi = date("Y-m-d");
        $this->waktu_datang     = htmlspecialchars(strip_tags($this->waktuPresensi));
        $this->waktu_pulang     = null;
    
        // MENGUNCI PARAMETER
        $statement->bindParam(':nim', $this->nim);
        $statement->bindParam(':tanggal_presensi', $this->tanggal_presensi);
        $statement->bindParam(':waktu_datang', $this->waktu_datang);
        $statement->bindParam(':waktu_pulang', $this->waktu_pulang);
    
        // EXECUTE STATEMENT
        if($statement->execute()) {
            return true;
        }
        
        return false;
    }

    // HITUNG JUMLAH PRESENSI HARI INI
    function countPresensi() {
        $query     = "  SELECT count(presensi.nim) 
                        FROM " . $this->table_name . " 
                        INNER JOIN asisten ON asisten.nim = presensi.nim WHERE 
                        tanggal_presensi=CURDATE() AND 
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

    // HITUNG JUMLAH PRESENSI HARI INI
    function countCalonAsistenPresensi() {
        $query     = "  SELECT count(presensi.nim) 
                        FROM " . $this->table_name . " 
                        INNER JOIN asisten ON asisten.nim = presensi.nim WHERE 
                        tanggal_presensi=CURDATE() AND 
                        asisten.jabatan = 'Calon Asisten'";

        // PREPARE STATEMENT
        $statement  = $this->conn->prepare( $query );

        // EXECUTE STATEMENT
        $statement->execute();

        // MENYIAPKAN ARRAY
        $this->result   = $statement->fetchColumn();

        return true;
    }
}