<?php
// MENAMPILKAN PESAN ERROR
error_reporting(E_ALL);
 
// SET DEFAULT TIMEZONE
date_default_timezone_set('Asia/Jakarta');
 
// VARIABEL UNTUK JWT
$key = "KKPGasal2019/2020";
$iss = "http://labict.budiluhur.ac.id";
$aud = "http://labkom.budiluhur.ac.id";
$iat = time();
$nbf = time();
?>