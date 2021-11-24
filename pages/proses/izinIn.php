<?php

include_once '../../config/database.php';
include_once '../../objects/izin.php';

$database   = new Database();
$db         = $database->getConnection();

$izin   = new Izin($db);

// GET POSTED DATA
$data   = json_decode(file_get_contents("php://input"));
 
// SET PROPERTY VALUE
$izin->nim              = $data->nim;
$izin->waktuIzinAwal    = $data->waktuIzinAwal;
$izin->waktuIzinAkhir   = $data->waktuIzinAkhir;
$izin->keterangan       = $data->keterangan;

if(empty($data->waktuIzinAkhir) || $data->waktuIzinAwal <= $data->waktuIzinAkhir)
    if($izin->asistenIzin()) {
        // SET RESPONSE
        http_response_code(200);
    
        // DISPLAY MESSAGE: BERHASIL
        echo json_encode(array("message" => "Berhasil melakukan Izin."));
    }
    else {
        // SET RESPONSE
        http_response_code(400);
    
        // DISPLAY MESSAGE: GAGAL
        echo json_encode(array("message" => "Anda telah melakukan Izin."));
    }
else {
    // SET RESPONSE
    http_response_code(400);
    
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Waktu izin tidak valid."));
}
?>