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

// CEK PRESENSI PER USER
$presensi->nim  = $data->nim;
$getPresensi    = $presensi->retrievePerUser();

if($getPresensi) {
    
    die( json_encode(array('result'=>$presensi->result)) );
}
else {

    die( json_encode(
        array(
            "message" => "Gagal Menampilkan Data.",
            "success" => 0
        )
    ));
}
?>