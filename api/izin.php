<?php

// HEADER API
//header("Access-Control-Allow-Origin: http://localhost/Presensi/");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/izin.php';
 
// MENDAPATKAN KONEKSI DARI DB
$database   = new Database();
$db         = $database->getConnection();
 
// INISIALISASI OBJEK
$izin   = new Izin($db);

// MENDAPATKAN DATA
$data = json_decode(file_get_contents("php://input"));

$izin->nim              = $data->nim;
$izin->waktuIzinAwal    = $data->waktuIzinAwal;
$izin->waktuIzinAkhir   = (!empty($data->waktuIzinAkhir)) ? $data->waktuIzinAkhir : "";
$izin->keterangan       = $data->keterangan;

if(empty($data->waktuIzinAkhir) || $data->waktuIzinAwal <= $data->waktuIzinAkhir)
    if($izin->asistenIzin()) {

        die( json_encode(
            array(
                "message" => "Izin Berhasil.",
                "success" => 1
            )
        ));
    }
    else {

        die( json_encode(
            array(
                "message" => "Anda telah melakukan Izin. Izin Gagal.",
                "success" => 0
            )
        ));
    }
else {

    die( json_encode(
        array(
            "message" => "Periksa kembali waktu Izin Anda. Izin Gagal.",
            "success" => 0
        )
    ));
}
?>