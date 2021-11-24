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

// RETRIEVE DATA
if(!empty($asisten->nim) && $asisten->getUserData()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array(
            "nim"           => $asisten->nim,
            "nama"          => $asisten->nama,
            "status"        => $asisten->status,
            "surel"         => $asisten->surel,
            "fakultas"      => $asisten->fakultas,
            "jurusan"       => $asisten->jurusan,
            "jenis_kelamin" => $asisten->jenis_kelamin,
            "no_telp"       => $asisten->no_telp,
            "jabatan"       => $asisten->jabatan,
            "imei"          => $asisten->imei
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