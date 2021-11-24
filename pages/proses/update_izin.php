<?php

include_once '../../config/database.php';
include_once '../../objects/izin.php';
 
$database   = new Database();
$db         = $database->getConnection();

$izin   = new izin($db);
 
// GET POSTED DATA
$data   = json_decode(file_get_contents("php://input"));

// SET PROPERTY VALUE
$izin->nim          = $data->nim;
$izin->keterangan   = $data->keterangan;
        
//UPDATE izin
if(!empty($izin->nim) && !empty($izin->keterangan) && $izin->update()) {
    
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