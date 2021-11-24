<?php

include_once '../../config/database.php';
include_once '../../objects/presensi.php';

$database   = new Database();
$db         = $database->getConnection();

$presensi   = new Presensi($db);

// GET POSTED DATA
$data       = file_get_contents("php://input");

// SET PROPERTY VALUE
$presensi->tanggal_presensi  = $data;

// RETRIEVE DATA
if(empty($presensi->tanggal_presensi) && $presensi->retrieve()) {

    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array(
            "data" => $presensi->result,
            "data2" => $presensi->result2
        )
    );
}
else {
    if(!empty($presensi->tanggal_presensi) && $presensi->retrieve()) {
        // SET RESPONSE
        http_response_code(200);
        
        // DISPLAY MESSAGE: BERHASIL
        echo json_encode(array(
                "data" => $presensi->result,
                "data2" => $presensi->result2
            )
        );
    }
    else {
        // SET RESPONSE
        http_response_code(400);
     
        // DISPLAY MESSAGE: GAGAL
        echo json_encode(array("message" => "Gagal menampilkan data."));
    }
}
?>