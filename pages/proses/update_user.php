<?php

include_once '../../config/database.php';
include_once '../../objects/asisten.php';
 
$database   = new Database();
$db         = $database->getConnection();

$asisten   = new Asisten($db);
 
// GET POSTED DATA
$data   = json_decode(file_get_contents("php://input"));

// SET PROPERTY VALUE
$asisten->nama             = $data->nama;
$asisten->jenis_kelamin    = $data->jenis_kelamin;
$asisten->surel            = $data->surel;
$asisten->no_telp          = $data->no_telp;
$asisten->jabatan          = $data->jabatan;
$asisten->kata_sandi       = $data->kata_sandi;
$asisten->imei             = $data->imei;
$asisten->nim              = $data->nim;
        
//UPDATE asisten
if(!empty($asisten->nim) && !empty($asisten->nama) && !empty($asisten->jenis_kelamin) && !empty($asisten->surel) && !empty($asisten->no_telp) && !empty($asisten->jabatan) && !empty($asisten->imei) && $asisten->update()) {
    
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