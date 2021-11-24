<?php

include_once '../../config/database.php';
include_once '../../objects/presensi.php';

$database   = new Database();
$db         = $database->getConnection();

$presensi       = new Presensi($db);

// GET POSTED DATA
$data       = file_get_contents("php://input");

// SET PROPERTY VALUE
$presensi->nim  = $data;

// RETRIEVE DATA
if(!empty($presensi->nim) && $presensi->retrieveUser()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array(
            "nim"           => $presensi->nim,
            "nama"          => $presensi->nama,
            "waktu_datang"  => $presensi->waktu_datang,
            "waktu_pulang"  => $presensi->waktu_pulang
        )
    );
}
else {
    // SET RESPONSE
    http_response_code(400);
 
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "Gagal mengambil data."));
}
?>