<?php

// HEADER API
header("Access-Control-Allow-Origin: http://localhost/Presensi/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// DIGUNAKAN UNTUK DECODE JWT
include_once '../config/core.php';
include_once '../assets/libs/php-jwt-master/src/BeforeValidException.php';
include_once '../assets/libs/php-jwt-master/src/ExpiredException.php';
include_once '../assets/libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../assets/libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// MENDAPATKAN DATA
$data   = json_decode(file_get_contents("php://input"));
 
// CEK ADA ATAU TIDAKNYA JWT DARI $data
$jwt    = isset($data->jwt) ? $data->jwt : "";

// CEK JIKA JWT ADA
if($jwt) {
 
    try {
        // DECODE JWT
        $decoded    = JWT::decode($jwt, $key, array('HS256'));
 
        // MEMBUAT USER DETAIL MIRIP SESSION
        die( json_encode(
            array(
                "message" => "Akses diberikan.",
                "success" => 1,
                "data" => $decoded->data
            )
        ));
    }
    // JIKA JWT ADA, TETAPI JWT TIDAK VALID
    catch (Exception $e){
    
        die( json_encode(
            array(
                "message" => "Akses ditolak.",
                "success" => 0
            )
        ));
    }
}
else{

    die( json_encode(
        array(
            "message" => "Akses ditolak.",
            "success" => 0
        )
    ));
}
?>