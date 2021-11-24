<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="Aplikasi Presensi" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Presensi - Lab ICT Terpadu</title>
        
        <link rel="stylesheet" href="../assets/css/materialize.min.css"/>
        <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
        <link rel="stylesheet" href="../assets/css/custom.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <div id="allContent">
            <!-- NAVBAR -->
            <div class="navbar-fixed">
                <nav class="blue">
                    <div class="nav-wrapper container">
                        <a href="index_calas.php" class="brand-logo">
                            Presensi
                        </a>
                        <a href="#" data-target="mobile-demo" class="sidenav-trigger">&#9776;</a>
                        
                        <!-- Dropdown Structure -->
                        <ul id="dropdown1" class="dropdown-content">
                            <li><a href="index_calas.php?hal=keluar">Keluar <i class="material-icons right">exit_to_app</i></a></li>
                        </ul>
                        <ul class="right hide-on-med-and-down">
                            <li><a href="index_calas.php?hal=beranda"><i class="material-icons left">dashboard</i> Beranda</a></li>
                            <li><a href="index_calas.php?hal=presensi"><i class="material-icons left">event_available</i> Presensi</a></li>
                            <li><a href="index_calas.php?hal=izin"><i class="material-icons left">event_note</i> Izin</a></li>
                            <li><a class="dropdown-trigger" href="#" data-target="dropdown1"><i class="material-icons left">person_outline</i> <span class="userName"></span><!-- - <span class="userNIM"></span> --><i class="material-icons right">arrow_drop_down</i></a></li>
                        </ul>
                    </div>
                </nav>
            </div>

            <ul class="sidenav" id="mobile-demo">
                <li>
                    <div class="user-view white-text">
                        <div class="background">
                            <img src="../assets/img/background-user.jpg" width="100%">
                        </div>
                        <label href="#user"><img class="circle" src="../assets/img/admin-user.png"></label>
                        <span class="userName"></span> - <span class="userNIM"></span>
                    </div>
                </li> 
                <li><a href="index_calas.php?hal=beranda"><i class="material-icons left">dashboard</i> Beranda</a></li>
                <li><a href="index_calas.php?hal=presensi"><i class="material-icons left">event_available</i> Presensi</a></li>
                <li><a href="index_calas.php?hal=izin"><i class="material-icons left">event_note</i> Izin</a></li>
                <li><div class="divider"></div></li>
                <li><a href="index_calas.php?hal=keluar">Keluar <i class="material-icons right">exit_to_app</i></a></li>
            </ul>
            <!-- END NAVBAR -->

            <!-- CONTENT -->
            <div class="container">