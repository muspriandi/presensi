<?php

include_once '../../config/database.php';
include_once '../../objects/izin.php';

$database   = new Database();
$db         = $database->getConnection();

$izin       = new Izin($db);

// GET POSTED DATA
$data       = file_get_contents("php://input");

// SET PROPERTY VALUE
$izin->nim  = $data;

// CHECK & DELETE izin
if(!empty($izin->nim) && $izin->delete()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array("message" => "Berhasil menghapus data."));
}
else {
    // SET RESPONSE
    http_response_code(400);
 
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Gagal menghapus data."));
}

?>