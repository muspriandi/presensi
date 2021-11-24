<?php

include_once '../../config/database.php';
include_once '../../objects/presensi.php';

$database   = new Database();
$db         = $database->getConnection();

$presensi   = new Presensi($db);

// GET POSTED DATA
$data       = file_get_contents("php://input");

// SET PROPERTY VALUE
$presensi->nim  = $data;

// RETRIEVE DATA
if(!empty($presensi->nim) && $presensi->retrievePerUser()) {

    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array(
            "data" => $presensi->result
        )
    );
}
else {
    // SET RESPONSE
    http_response_code(400);
    
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Gagal menampilkan data."));
}
?>