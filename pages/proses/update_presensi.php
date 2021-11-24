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
$presensi->waktu_datang     = $data->waktu_datang;
$presensi->waktu_pulang     = $data->waktu_pulang;
        
//UPDATE presensi
if(!empty($presensi->nim) && !empty($presensi->waktu_datang) && !empty($presensi->waktu_pulang && $presensi->update())) {
    
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array("message" => "Berhasil mengubah data."));
}
else {
    // SET RESPONSE
    http_response_code(400);
 
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Gagal mengubah data."));
}
?>