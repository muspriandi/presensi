<?php

// MEMBUAT OBJEK 'join' UNTUK TABEL JOIN
class Join {
 
    private $conn;
 
    // OBJEK
    public $waktu;
    public $waktuAwal;
    public $waktuAkhir;
    
    // KONSTRUKTOR
    public function __construct($db) {
        $this->conn = $db;
		date_default_timezone_set('Asia/Jakarta');
    }

    function tampilLaporanPeriode() {
        
        $this->waktuAwal    = htmlspecialchars(strip_tags($this->waktuCetakExcelAwal));
        $this->waktuAkhir   = htmlspecialchars(strip_tags($this->waktuCetakExcelAkhir));

        $select_presensi    = "SELECT nim, waktu_datang, count(nim) as totalHadir FROM presensi WHERE tanggal_presensi BETWEEN :waktuAwal AND :waktuAkhir AND DAYNAME(tanggal_presensi) != 'Saturday' AND DAYNAME(tanggal_presensi) != 'Sunday' AND waktu_pulang != 'null' GROUP BY nim ORDER BY totalHadir DESC";
        $statement          = $this->conn->prepare( $select_presensi );
        $statement  -> bindParam(':waktuAwal', $this->waktuAwal);
        $statement  -> bindParam(':waktuAkhir', $this->waktuAkhir);
        $statement  -> execute();

        $select_lembur      = "SELECT nim, count(nim) as totalLembur FROM presensi WHERE tanggal_presensi BETWEEN :waktuAwal AND :waktuAkhir AND DAYNAME(tanggal_presensi) = 'Saturday' AND waktu_pulang != 'null' GROUP BY nim";
        $statement2         = $this->conn->prepare( $select_lembur );
        $statement2  -> bindParam(':waktuAwal', $this->waktuAwal);
        $statement2  -> bindParam(':waktuAkhir', $this->waktuAkhir);
        $statement2  -> execute();

        $select_izin    = "SELECT nim, count(nim) as totalIzin FROM izin WHERE tanggal_izin BETWEEN :waktuAwal AND :waktuAkhir GROUP BY nim ORDER BY totalIzin DESC";
        $statement3     = $this->conn->prepare( $select_izin );
        $statement3  -> bindParam(':waktuAwal', $this->waktuAwal);
        $statement3  -> bindParam(':waktuAkhir', $this->waktuAkhir);
        $statement3  -> execute();

        $select_telat   = "SELECT nim, waktu_datang FROM presensi WHERE tanggal_presensi BETWEEN :waktuAwal AND :waktuAkhir AND DAYNAME(tanggal_presensi) != 'Saturday' AND DAYNAME(tanggal_presensi) != 'Sunday' AND waktu_datang > '08:00:00' AND waktu_pulang != 'null'";
        $statement4     = $this->conn->prepare( $select_telat );
        $statement4  -> bindParam(':waktuAwal', $this->waktuAwal);
        $statement4  -> bindParam(':waktuAkhir', $this->waktuAkhir);
        $statement4  -> execute();

        if($this->targetCetak == "asisten") {
            $select_asisten = "SELECT nim, nama FROM asisten WHERE status='aktif' AND jabatan = 'Asisten'";
        }
        else {
            if($this->targetCetak == "calas") {
                $select_asisten = "SELECT nim, nama FROM asisten WHERE status='aktif' AND jabatan = 'Calon Asisten'";
            }
            else {
                $select_asisten = "SELECT nim, nama FROM asisten WHERE status='aktif'";
            }
        }
        $statement5     = $this->conn->prepare( $select_asisten );
        $statement5     -> execute();

        $periodeAwal    = strtotime($this->waktuAwal);
        $periodeAkhir   = strtotime($this->waktuAkhir);
        
        $intervalDay    = $periodeAkhir - $periodeAwal;

        $this->waktu    = array (
            "waktu"         => round($intervalDay / (60*60*24)) +1,
            "waktuAwal"     => $this->ubahFormatkeID($this->waktuAwal),
            "waktuAkhir"    => $this->ubahFormatkeID($this->waktuAkhir)
        );
        $this->result_presensi  = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->result_lembur    = $statement2->fetchAll(PDO::FETCH_ASSOC);
        $this->result_izin      = $statement3->fetchAll(PDO::FETCH_ASSOC);
        $this->result_telat     = $statement4->fetchAll(PDO::FETCH_ASSOC);
        $this->result_asisten   = $statement5->fetchAll(PDO::FETCH_ASSOC);

        return true;
    }

    function ubahFormatkeID($id) {

        $waktuIndonesia = "";
        $tahun          = substr($id, 0, 4) ;
        $bulan          = "";
        $tanggal        = substr($id, 8, 2);
    
        switch(substr($id, 5, 2)) {
            case '01' : $bulan = "Januari"; break;
            case '02' : $bulan = "Februari"; break;
            case '03' : $bulan = "Maret"; break;
            case '04' : $bulan = "April"; break;
            case '05' : $bulan = "Mei"; break;
            case '06' : $bulan = "Juni"; break;
            case '07' : $bulan = "Juli"; break;
            case '08' : $bulan = "Agustus"; break;
            case '09' : $bulan = "September"; break;
            case '10' : $bulan = "Oktober"; break;
            case '11' : $bulan = "November"; break;
            case '12' : $bulan = "Desember"; break;
        }
    
        $waktuIndonesia = $tanggal. " " .$bulan. " " .$tahun;
    
        return $waktuIndonesia;
    }
}