<?php

include_once '../../config/database.php';
include_once '../../objects/asisten.php';

$database   = new Database();
$db         = $database->getConnection();

$asisten   = new Asisten($db);

// GET POSTED DATA
$data   = json_decode(file_get_contents("php://input"));
 
// SET PROPERTY VALUE
$asisten->nim              = $data->nim;
$asisten->nama             = $data->nama;
$asisten->jenis_kelamin    = $data->jenis_kelamin;
$asisten->surel            = $data->surel;
$asisten->no_telp          = $data->no_telp;
$asisten->jabatan          = $data->jabatan;
$asisten->kata_sandi       = $data->kata_sandi;
$asisten->imei             = $data->imei;
$asisten->status           = "Aktif";

switch(substr($data->nim,2,2)) {
    case '11' : $asisten->fakultas = "Fakultas Teknologi Informasi"; $asisten->jurusan= "Teknik Informatika"; break;
    case '12' : $asisten->fakultas = "Fakultas Teknologi Informasi"; $asisten->jurusan= "Sistem Informasi"; break;
    case '13' : $asisten->fakultas = "Fakultas Teknologi Informasi"; $asisten->jurusan= "Sistem Komputer"; break;
    case '31' : $asisten->fakultas = "Fakultas Ekonomi"; $asisten->jurusan= "Managemen"; break;
    case '32' : $asisten->fakultas = "Fakultas Ekonomi"; $asisten->jurusan= "Akuntansi"; break;
    case '42' : $asisten->fakultas = "Fakultas Ilmu Sosial & Politik"; $asisten->jurusan= "Ilmu Hubungan Internasional"; break;
    case '43' : $asisten->fakultas = "Fakultas Ilmu Sosial & Politik"; $asisten->jurusan= "Kriminologi"; break;
    case '51' : $asisten->fakultas = "Fakultas Teknik"; $asisten->jurusan= "Arsitektur"; break;
    case '52' : $asisten->fakultas = "Fakultas Teknik"; $asisten->jurusan= "Teknik Elektro"; break;
    
    default : $asisten->fakultas = "-"; $asisten->jurusan= "-";
}
 
// CREATE THE asisten
if(!empty($asisten->nim) && !empty($asisten->nama) && !empty($asisten->fakultas) && !empty($asisten->jurusan) && !empty($asisten->jenis_kelamin) && !empty($asisten->surel) && !empty($asisten->no_telp) && !empty($asisten->jabatan) && !empty($asisten->kata_sandi) && !empty($asisten->imei) && !empty($asisten->status) && $asisten->create()) {
 
    // SET RESPONSE
    http_response_code(200);
 
    // DISPLAY MESSAGE: BERHASIL
    echo json_encode(array("message" => "Selamat bergabung ".$asisten->nama."."));
}
else {
    // SET RESPONSE
    http_response_code(400);
 
    // DISPLAY MESSAGE: GAGAL
    echo json_encode(array("message" => "NIM dan IMEI harus unique."));
}
?>