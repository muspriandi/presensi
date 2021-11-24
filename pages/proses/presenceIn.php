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

$resultCheckIn = $presensi->checkIn();

if(!empty($presensi->nim) && !empty($presensi->waktuPresensi) && $resultCheckIn) {

    if(is_array($resultCheckIn)) {
        if($resultCheckIn['success'] > 0) {
            // SET RESPONSE
            http_response_code(200);

            // DISPLAY MESSAGE: BERHASIL
            echo json_encode(array("message" => "ㅤㅤㅤSebanyak ". $resultCheckIn['success'] ." data berhasil melakukan Presensi danㅤㅤㅤ". ($resultCheckIn['dataCount']-$resultCheckIn['success']) ." data gagal."));
        }
        else {
            // SET RESPONSE
            http_response_code(400);

            // DISPLAY MESSAGE: GAGAL
            echo json_encode(array("message" => "Sebanyak ". $resultCheckIn['dataCount'] ." data gagal melakukan Presensi."));
        }
    }
    else {
        // SET RESPONSE
        http_response_code(200);
        
        // DISPLAY MESSAGE: BERHASIL
        echo json_encode(array("message" => "Berhasil melakukan Presensi."));
    }
}
else {
    // SET RESPONSE
    http_response_code(400);
 
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Anda telah melakukan Presensi Datang."));
}
?>