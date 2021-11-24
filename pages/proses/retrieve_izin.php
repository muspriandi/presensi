<?php

include_once '../../config/database.php';
include_once '../../objects/izin.php';

$database   = new Database();
$db         = $database->getConnection();

$izin       = new Izin($db);

// GET POSTED DATA
$data       = file_get_contents("php://input");

// SET PROPERTY VALUE
$izin->tanggal_izin  = $data;

// RETRIEVE DATA
if(empty($izin->tanggal_izin) && $izin->retrieve()) {

    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array(
            "data" => $izin->result,
            "data2" => $izin->result2,
            "data3" => $izin->result3
        )
    );
}
else {
    if(!empty($izin->tanggal_izin) && $izin->retrieve()) {
        // SET RESPONSE
        http_response_code(200);
        
        // DISPLAY MESSAGE: BERHASIL
        echo json_encode(array(
                "data" => $izin->result,
                "data2" => $izin->result2,
                "data3" => $izin->result3
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