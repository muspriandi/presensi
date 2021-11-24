<?php

include_once '../../config/database.php';
include_once '../../objects/asisten.php';

$database   = new Database();
$db         = $database->getConnection();

$asisten   = new Asisten($db);

// RETRIEVE DATA CALON ASISTEN AKTIF
if($asisten->retrieveCalasAktif()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array(
            "data" => $asisten->result
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