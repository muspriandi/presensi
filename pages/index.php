<?php
    ob_start();
    session_start();
    include('admin/layouts/header.php');

    // CEK ADA ATAU TIDAKNYA URL
    if(isset($_GET['hal'])) {
        
        // MEMBERIKAN NILAI UNTUK index.php?hal=<<NILAI>>
        switch($_GET['hal']) {
            // SAAT index?hal=beranda, TAMPILKAN ISI DARI beranda.php
            case 'beranda'  : include 'admin/beranda.php'; break;

            // SAAT index?hal=asisten, TAMPILKAN ISI DARI asisten.php
            case 'asisten'  : include 'admin/asisten.php'; break;

            // SAAT index?hal=tambah-asisten, TAMPILKAN ISI DARI tambah-asisten.php
            case 'tambah-asisten'  : include 'admin/tambah-asisten.php'; break;

            // SAAT index?hal=presensi, TAMPILKAN ISI DARI presensi.php
            case 'presensi' : include 'admin/presensi.php'; break;

            // SAAT index?hal=presensi, TAMPILKAN ISI DARI presensi.php
            case 'presensi-calas' : include 'admin/presensi-calas.php'; break;

            // SAAT index?hal=tambah-presensi, TAMPILKAN ISI DARI tambah-presensi.php
            case 'tambah-presensi'  : include 'admin/tambah-presensi.php'; break;

            // SAAT index?hal=tambah-presensiCalas, TAMPILKAN ISI DARI tambah-presensiCalas.php
            case 'tambah-presensi-calas'  : include 'admin/tambah-presensiCalas.php'; break;

            // SAAT index?hal=izin, TAMPILKAN ISI DARI izin.php
            case 'izin' : include 'admin/izin.php'; break;

            // SAAT index?hal=tambah-izin, TAMPILKAN ISI DARI tambah-izin.php
            case 'tambah-izin'  : include 'admin/tambah-izin.php'; break;

        
            // SAAT index?hal=laporan, TAMPILKAN ISI DARI laporan.php
            case 'laporan'  : include 'admin/laporan.php'; break;

            
            // SAAT index?hal=keluar, TAMPILKAN ISI DARI keluar.php
            case 'keluar'   : header('location:../index.php'); break;
            ob_clean();
            
            // SELAIN YANG DI ATAS MAKA AKAN MENAMPILKAN HALAM 404
            default : include 'admin/404.php';
        }

        if($_GET['hal'] != 'laporan') {
            session_destroy();
        }
    }
    else {
        // HALAMAN YANG DITAMPILKAN SETELAH LOGIN (PERTAMA KALI)
        include 'admin/beranda.php';
    }

    include('admin/layouts/footer.php');
?>