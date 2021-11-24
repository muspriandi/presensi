<?php

include_once '../../config/database.php';
include_once '../../objects/join.php';

$database   = new Database();
$db         = $database->getConnection();
                    
$join       = new Join($db);

// GET POSTED DATA
$data   = json_decode(file_get_contents("php://input"));
 
// SET PROPERTY VALUE
$join->waktuCetakExcelAwal      = $data->waktuCetakExcelAwal;
$join->waktuCetakExcelAkhir     = $data->waktuCetakExcelAkhir;
$join->targetCetak              = $data->targetCetak;

if($data->waktuCetakExcelAwal <= $data->waktuCetakExcelAkhir)
    if($join->tampilLaporanPeriode()) {
        // SET RESPONSE
        http_response_code(200);
        
        session_start();
        $_SESSION['dataCetak'] = array(
                                    "waktu"         => $join->waktu,
                                    "data_presensi" => $join->result_presensi,
                                    "data_lembur"   => $join->result_lembur,
                                    "data_izin"     => $join->result_izin,
                                    "data_telat"    => $join->result_telat,
                                    "data_asisten"  => $join->result_asisten
                                );
    }
    else {
        // SET RESPONSE
        http_response_code(400);
    
        // DISPLAY MESSAGE: GAGAL
        echo json_encode(array("message" => "Terjadi kesalahan."));
    }
else {
    // SET RESPONSE
    http_response_code(400);
    
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Waktu tidak valid."));
}
?>