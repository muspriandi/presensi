<?php

// HEADER API
// header("Access-Control-Allow-Origin: http://localhost/Presensi/");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/asisten.php';
 
// MENDAPATKAN KONEKSI DARI DB
$database   = new Database();
$db         = $database->getConnection();
 
// INISIALISASI OBJEK
$asisten       = new Asisten($db);
 
// MENDAPATKAN DATA
$data = json_decode(file_get_contents("php://input"));

// CEK IMEI & NIM
$asisten->imei = $data->imei;
$asisten->nim  = $data->nim;
$imei_valid = $asisten->imeiValid();
$nim_exists = $asisten->nimExists();

// DIGUNAKAN UNTUK MEMBUAT JWT
include_once '../config/core.php';
include_once '../assets/libs/php-jwt-master/src/BeforeValidException.php';
include_once '../assets/libs/php-jwt-master/src/ExpiredException.php';
include_once '../assets/libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../assets/libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

if($imei_valid) {

    // JIKA NIM ADA DALAM DB DAN PASSWORD SESUAI
    if($nim_exists && password_verify($data->kata_sandi, $asisten->kata_sandi)) {
    
        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "data" => array(
                "nim"       => $asisten->nim,
                "nama"      => $asisten->nama,
                "jabatan"   => $asisten->jabatan
            )
        );
    
        // GENERATE JWT
        $jwt = JWT::encode($token, $key);

        die( json_encode(
                array(
                    "message" => "Anda Berhasil Masuk. Selamat datang ".$asisten->nama.".",
                    "success" => 1,
                    "jwt" => $jwt
                )
            ));
        }
        else {
    
        die( json_encode(
            array(
                "message" => "NIM atau Kata Sandi salah.",
                "success" => 0
            )
        ));
    }
}
else {

    die( json_encode(
        array(
            "message" => "IMEI Anda Tidak Sesuai.",
            "success" => 0
        )
    ));
}
?>