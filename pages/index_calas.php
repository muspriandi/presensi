<?php
    ob_start();
    include('calas/layouts/header.php');

    // CEK ADA ATAU TIDAKNYA URL
    if(isset($_GET['hal'])) {
        
        // MEMBERIKAN NILAI UNTUK index.php?hal=<<NILAI>>
        switch($_GET['hal']) {
            // SAAT index?hal=beranda, TAMPILKAN ISI DARI beranda.php
            case 'beranda'  : include 'calas/beranda.php'; break;

            // SAAT index?hal=presensi, TAMPILKAN ISI DARI presensi.php
            case 'presensi' : include 'calas/presensi.php'; break;

            // SAAT index?hal=izin, TAMPILKAN ISI DARI izin.php
            case 'izin' : include 'calas/izin.php'; break;

            // SAAT index?hal=tambah-izin, TAMPILKAN ISI DARI tambah-izin.php
            case 'tambah-izin'  : include 'calas/tambah-izin.php'; break;

            // SAAT index?hal=keluar, TAMPILKAN ISI DARI keluar.php
            case 'keluar'   : header('location:../index.php'); break;
            ob_clean();
            
            // SELAIN YANG DI ATAS MAKA AKAN MENAMPILKAN HALAM 404
            default : include 'calas/404.php';
        }
    }
    else {
        // HALAMAN YANG DITAMPILKAN SETELAH LOGIN (PERTAMA KALI)
        include 'calas/beranda.php';
    }

    include('calas/layouts/footer.php');
?>