<?php

include_once '../../config/database.php';
include_once '../../objects/presensi.php';

$database   = new Database();
$db         = $database->getConnection();

$presensi   = new Presensi($db);

// GET POSTED DATA
$data   = json_decode(file_get_contents("php://input"));
 
// SET PROPERTY VALUE
$presensi->nim              = $data->nim;
$presensi->waktuPresensi    = $data->waktuPresensi;

if(!empty($presensi->nim) && !empty($presensi->waktuPresensi) && $presensi->checkIn()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array("message" => "Berhasil melakukan Presensi."));
}
else {
    // SET RESPONSE
    http_response_code(400);
 
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Anda telah melakukan Presensi Datang."));
}
?>