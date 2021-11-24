<?php

include_once '../../config/database.php';
include_once '../../objects/izin.php';

$database   = new Database();
$db         = $database->getConnection();

$izin       = new Izin($db);

// RETRIEVE DATA ASISTEN AKTIF
if($izin->retrieveAktif()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array(
            "data" => $izin->result
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