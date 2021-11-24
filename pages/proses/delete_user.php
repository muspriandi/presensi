<?php

include_once '../../config/database.php';
include_once '../../objects/asisten.php';

$database   = new Database();
$db         = $database->getConnection();

$asisten       = new Asisten($db);

// GET POSTED DATA
$data       = file_get_contents("php://input");

// SET PROPERTY VALUE
$asisten->nim  = $data;

// CHECK & DELETE asisten
if(!empty($asisten->nim) && $asisten->delete()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array("message" => "Berhasil menghapus data."));
}
else {
    // SET RESPONSE
    http_response_code(400);
 
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Data masih digunakan oleh transaksi lain."));
}

?>