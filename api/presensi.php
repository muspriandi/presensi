<?php

// HEADER API
//header("Access-Control-Allow-Origin: http://localhost/Presensi/");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/presensi.php';
 
// MENDAPATKAN KONEKSI DARI DB
$database   = new Database();
$db         = $database->getConnection();
 
// INISIALISASI OBJEK
$presensi   = new Presensi($db);
 
// MENDAPATKAN DATA
$data = json_decode(file_get_contents("php://input"));

// CEK IMEI & NIM
$presensi->nim  = $data->nim;
$cek_presensi   = $presensi->presensi();

if($cek_presensi) {
    
    die($cek_presensi);
}
else {

    die( json_encode(
        array(
            "message" => "Presensi Gagal!",
            "success" => 0
        )
    ));
}
?>