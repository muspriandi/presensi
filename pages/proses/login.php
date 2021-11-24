<?php

// HEADER API
header("Access-Control-Allow-Origin: http://localhost/Presensi/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/asisten.php';
 
// MENDAPATKAN KONEKSI DARI DB
$database   = new Database();
$db         = $database->getConnection();
 
// INISIALISASI OBJEK
$asisten       = new Asisten($db);
 
// MENDAPATKAN DATA
$data = json_decode(file_get_contents("php://input"));
 
// CEK NIM
$asisten->nim  = $data->nim;
$nim_exists     = $asisten->nimExists();

// DIGUNAKAN UNTUK MEMBUAT JWT
include_once '../../config/core.php';
include_once '../../assets/libs/php-jwt-master/src/BeforeValidException.php';
include_once '../../assets/libs/php-jwt-master/src/ExpiredException.php';
include_once '../../assets/libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../../assets/libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// JIKA NIM ADA DALAM DB DAN kata_sandi SESUAI
if($nim_exists && password_verify($data->kata_sandi, $asisten->kata_sandi)) {
 
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "nim"        => $asisten->nim,
           "nama"       => $asisten->nama,
           "jabatan"    => $asisten->jabatan
       )
    );
 
    // SET RESPONSE SUKSES (DIHAPUS SAAT DEVELOPMENT)
    http_response_code(200);
 
    // GENERATE JWT
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message"   => "Selamat datang ".$asisten->nama.".",
                "jwt"       => $jwt,
                "jabatan"   => $asisten->jabatan
            )
        );
}
else {

    // SET RESPONSE ERROR(DIHAPUS SAAT DEVELOPMENT)
    http_response_code(401);
 
    echo json_encode(array("message" => "Periksa kembali NIM dan Kata sandi Anda."));
}
?>