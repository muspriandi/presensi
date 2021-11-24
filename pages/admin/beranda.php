<?php
    include_once '../config/database.php';
    include_once '../objects/asisten.php';
    include_once '../objects/presensi.php';
    include_once '../objects/izin.php';

    $database   = new Database();
    $db         = $database->getConnection();
                        
    $asisten    = new Asisten($db);
    $presensi   = new Presensi($db);
    $izin       = new izin($db);
?>

<div class="row center">
    <div class="col m6 s12 mt-3">
        <div class="card hoverable">
            <div class="card-content center px-3">
                <div class="card-title">
                    <div class="hr-sect">
                        <h6 class="mt-0 mx-1 black-text">
                            Jumlah Asisten Aktif
                        </h6>
                    </div>
                </div>
                
                <?php
                    if($asisten->countAsistenAktif()) {
                        echo '<a href="http://localhost/Presensi/pages/index.php?hal=asisten"><h4 class="my-2">'.$asisten->result.' Asisten</h4></a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col m6 s12 mt-3">
        <div class="card hoverable">
            <div class="card-content center px-3">
                <div class="card-title">
                    <div class="hr-sect">
                        <h6 class="mt-0 mx-1 black-text">
                            Jumlah Calon Asisten Aktif
                        </h6>
                    </div>
                </div>
                
                <?php
                    if($asisten->countCalonAsistenAktif()) {
                        echo '<a href="http://localhost/Presensi/pages/index.php?hal=asisten"><h4 class="my-2">'.$asisten->result.' Asisten</h4></a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col m6 s12 mt-3">
        <div class="card hoverable">
            <div class="card-content center px-3">
                <div class="card-title">
                    <div class="hr-sect">
                        <h6 class="mt-0 mx-1 black-text">
                            Jumlah Presensi Hari Ini
                        </h6>
                    </div>
                </div>
                <h5>
                    <?php
                        if($presensi->countPresensi()) {
                            echo '<a href="http://localhost/Presensi/pages/index.php?hal=presensi">'.$presensi->result.' Asisten</a>';
                        }
                        echo '<hr style="border-bottom: 0.5px solid lightgray; width: 222px;">';
                        if($presensi->countCalonAsistenPresensi()) {
                            echo '<a href="http://localhost/Presensi/pages/index.php?hal=presensi-calas">'.$presensi->result.' Calon Asisten</a>';
                        }
                    ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="col m6 s12 mt-3">
        <div class="card hoverable">
            <div class="card-content center px-3">
                <div class="card-title">
                    <div class="hr-sect">
                        <h6 class="mt-0 mx-1 black-text">
                            Jumlah Izin Hari ini
                        </h6>
                    </div>
                </div>
                <h5>
                    <?php
                        if($izin->countIzin()) {
                            echo '<a href="http://localhost/Presensi/pages/index.php?hal=izin">'.$izin->result.' Asisten</a>';
                        }
                        echo '<hr style="border-bottom: 0.5px solid lightgray; width: 222px;">';
                        if($izin->countCalonAsistenIzin()) {
                            echo '<a href="http://localhost/Presensi/pages/index.php?hal=izin">'.$izin->result.' Calon Asisten</a>';
                        }
                    ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="col m6 s12 mt-3">
        <div class="card hoverable">
            <div class="card-content center">
                <div class="card-title">
                    <div class="hr-sect">
                        <h6 class="mt-0 mx-1 black-text">
                            Cetak Laporan Presensi (Excel)
                        </h6>
                    </div>
                </div>
                <a class="modal-trigger" href="#modalCetakExcel">
                    <h5 class="cPointer blue-text">
                        <i style="vertical-align: middle;" class="material-icons medium">description</i> <span>Cetak Laporan!</span>
                    </h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col m6 s12 mt-3">
        <div class="card hoverable">
            <div class="card-content center">
                <div class="card-title">
                    <div class="hr-sect">
                        <h6 class="mt-0 mx-1 black-text">
                            Cetak Laporan Presensi (PDF)
                        </h6>
                    </div>
                </div>
                
                <a class="modal-trigger" href="#modalCetakExcel">
                    <h5 class="cPointer blue-text">
                        <i style="vertical-align: middle;" class="material-icons medium">description</i> <span>Cetak Laporan!</span>
                    </h5>
                </a>
            </div>
        </div>
    </div>
    <div class="col m12 s12 mt-3 mb-3">
        <div class="card hoverable">
            <div class="card-content center">
                <div class="card-title">
                    <div class="hr-sect">
                        <h6 class="mt-0 mx-1 black-text">
                            Pengelompokkan Asisten Aktif
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s3"><a class="active" href="#test1">Fakultas & Jurusan</a></li>
                            <li class="tab col s3"><a href="#test2">Jenis Kelamin</a></li>
                            <li class="tab col s3"><a href="#test3">Tahun Masuk</a></li>
                            <li class="tab col s3"><a href="#test4">Jabatan</a></li>
                        </ul>
                    </div>
                    <div id="test1" class="col s12">
                        <?php
                            if($asisten->getJurusanAsisten()) {
                                $ti = 0;    $ma = 0;    $el = 0;
                                $si = 0;    $ak = 0;    $hi = 0;
                                $sk = 0;    $ar = 0;    $kr = 0;

                                for($i = 0; $i < count($asisten->result) ; $i++) {
                                    switch($asisten->result[$i]['jurusan']) {
                                        case 'Teknik Informatika' : $ti = $ti + 1; break;
                                        case 'Sistem Informasi' : $si = $si + 1; break;
                                        case 'Sistem Komputer' : $sk = $sk + 1; break;
                                        case 'Managemen' : $ma = $ma + 1; break;
                                        case 'Akuntansi' : $ak = $ak + 1; break;
                                        case 'Arsitektur' : $ar = $ar + 1; break;
                                        case 'Teknik Elektro' : $el = $el + 1; break;
                                        case 'Ilmu Hubungan Internasional' : $hi = $hi + 1; break;
                                        case 'Kriminologi' : $kr = $kr + 1; break;
                                    }
                                }

                                echo '  <table class="striped centered responsive-table">
                                            <tr>
                                                <th></th>
                                                <th class="center">Teknik Informatika</th>
                                                <th class="center">Sistem Informasi</th>
                                                <th class="center">Sistem Komputer</th>
                                                <th class="center">Total</th>
                                            </tr>
                                            <tr>
                                                <th>Fakultas Teknologi Informasi</th>
                                                <td><strong>'.$ti.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$si.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$sk.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.($ti+$si+$sk).'</strong> <small>Asisten</small></td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="center">Managemen</th>
                                                <th colspan="2" class="center">Akuntansi</th>
                                                <th class="center">Total</th>
                                            </tr>
                                            <tr>
                                                <th>Fakultas Ekonomi</th>
                                                <td><strong>'.$ma.'</strong> <small>Asisten</small></td>
                                                <td colspan="2"><strong>'.$ak.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.($ma+$ak).'</strong> <small>Asisten</small></td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="center">Arsitektur</th>
                                                <th colspan="2" class="center">Teknik Elektro</th>
                                                <th class="center">Total</th>
                                            </tr>
                                            <tr>
                                                <th>Fakultas Teknik</th>
                                                <td><strong>'.$ar.'</strong> <small>Asisten</small></td>
                                                <td colspan="2"><strong>'.$el.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.($ar+$el).'</strong> <small>Asisten</small></td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="center">Ilmu Hubungan Internasional</th>
                                                <th colspan="2" class="center">Kriminologi</th>
                                                <th class="center">Total</th>
                                            </tr>
                                            <tr>
                                                <th>Fakultas Ilmu Sosial & Politik</th>
                                                <td><strong>'.$hi.'</strong> <small>Asisten</small></td>
                                                <td colspan="2"><strong>'.$kr.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.($hi+$kr).'</strong> <small>Asisten</small></td>
                                            </tr>
                                        </table>';
                            }
                            else {
                                echo '  <div class="hr-sect m-5">
                                            <a class="px-2" href="http://localhost/Presensi/pages/index.php?hal=beranda"><h4 class="my-2">Error</h4></a>\
                                        </div>';
                            }
                        ?>
                    </div>
                    <div id="test2" class="col s12">
                        <?php
                            if($asisten->getJenKelAsisten()) {
                                $laki = 0;    $perempuan = 0;

                                for($i = 0; $i < count($asisten->result) ; $i++) {
                                    switch($asisten->result[$i]['jenis_kelamin']) {
                                        case 'Laki-laki' : $laki = $laki + 1; break;
                                        case 'Perempuan' : $perempuan = $perempuan + 1; break;
                                    }
                                }

                                echo '  <table class="striped centered responsive-table">
                                            <tr>
                                                <th></th>
                                                <th class="center">Laki-laki</th>
                                                <th class="center">Perempuan</th>
                                            </tr>
                                            <tr>
                                                <th class="center">'.($laki + $perempuan).' Asisten</th>
                                                <td><strong>'.$laki.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$perempuan.'</strong> <small>Asisten</small></td>
                                            </tr>
                                        </table>';
                            }
                            else {
                                echo '  <div class="hr-sect m-5">
                                            <a class="px-2" href="http://localhost/Presensi/pages/index.php?hal=beranda"><h4 class="my-2">Error</h4></a>\
                                        </div>';
                            }
                        ?>
                    </div>
                    <div id="test3" class="col s12">
                        <?php
                            if($asisten->getTahunAsisten()) {
                                $tahun1 = 0;                $tahun2 = 0;                $tahun3 = 0;                $tahun4 = 0;
                                $tahun_1 = Date('y')-3;     $tahun_2 = Date('y')-2;     $tahun_3 = Date('y')-1;     $tahun_4 = Date('y');

                                for($i = 0; $i < count($asisten->result) ; $i++) {
                                    switch(substr($asisten->result[$i]['nim'],0,2)) {
                                        case $tahun_1 : $tahun1 = $tahun1 + 1; break;
                                        case $tahun_2 : $tahun2 = $tahun2 + 1; break;
                                        case $tahun_3 : $tahun3 = $tahun3 + 1; break;
                                        case $tahun_4 : $tahun4 = $tahun4 + 1; break;
                                    }
                                }

                                echo '  <table class="striped centered responsive-table">
                                            <tr>
                                                <th></th>
                                                <th class="center">20'.$tahun_1.'</th>
                                                <th class="center">20'.$tahun_2.'</th>
                                                <th class="center">20'.$tahun_3.'</th>
                                                <th class="center">20'.$tahun_4.'</th>
                                            </tr>
                                            <tr>
                                                <th class="center">'.($tahun1 + $tahun2 + $tahun3 + $tahun4).' Asisten</th>
                                                <td><strong>'.$tahun1.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$tahun2.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$tahun3.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$tahun4.'</strong> <small>Asisten</small></td>
                                            </tr>
                                        </table>';
                            }
                            else {
                                echo '  <div class="hr-sect m-5">
                                            <a class="px-2" href="http://localhost/Presensi/pages/index.php?hal=beranda"><h4 class="my-2">Error</h4></a>\
                                        </div>';
                            }
                        ?>
                    </div>
                    <div id="test4" class="col s12">
                        <?php
                            if($asisten->getJabatanAsisten()) {
                                $s_spv = 0;
                                $s_asisten = 0;
                                $s_calas = 0;
                                
                                for($i = 0; $i < count($asisten->result) ; $i++) {
                                    switch($asisten->result[$i]['jabatan']) {
                                        case 'Supervisor' : $s_spv = $s_spv + 1; break;
                                        case 'Asisten' : $s_asisten = $s_asisten + 1; break;
                                        case 'Calon Asisten' : $s_calas = $s_calas + 1; break;
                                    }
                                }

                                echo '  <table class="striped centered responsive-table">
                                            <tr>
                                                <th></th>
                                                <th class="center">Supervisor</th>
                                                <th class="center">Asisten</th>
                                                <th class="center">Calon Asisten</th>
                                            </tr>
                                            <tr>
                                                <th class="center">'.($s_spv + $s_asisten + $s_calas).' Asisten</th>
                                                <td><strong>'.$s_spv.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$s_asisten.'</strong> <small>Asisten</small></td>
                                                <td><strong>'.$s_calas.'</strong> <small>Asisten</small></td>
                                            </tr>
                                        </table>';
                            }
                            else {
                                echo '  <div class="hr-sect m-5">
                                            <a class="px-2" href="http://localhost/Presensi/pages/index.php?hal=beranda"><h4 class="my-2">Error</h4></a>\
                                        </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalCetakExcel" class="modal">
    <div class="modal-content mx-5 mt-3">
        <div class="hr-sect center mt-0">
            <h5 class="mt-0 mx-1 blue-text">
                Cetak Laporan<br>
                <small class="grey-text">Pilih periode</small>
            </h5>
        </div>
        <form id='cetakExcel_pdf' method="post">
            <div class="row my-0">
                <div class="input-field col m4 s12 offset-m1">
                    <label for="waktuCetakExcelAwal">Waktu Awal</label>
                    <input type="text" id="waktuCetakExcelAwal" name="waktuCetakExcelAwal" class="datepickerCetak cPointer validate" required>
                </div>
                <div class="input-field col m2 s12 center mt-2 pt-3">
                    <span>s/d</span>
                </div>
                <div class="input-field col m4 s12">
                    <label for="waktuCetakExcelAkhir">Waktu Akhir</label>
                    <input type="text" id="waktuCetakExcelAkhir" name="waktuCetakExcelAkhir" class="datepickerCetak cPointer validate" required>
                </div>
                <div class="col m10 s12 offset-m1 center">
                    <h5 class="mt-0 mx-1 blue-text">
                        <small class="grey-text">Pilih laporan yang akan dicetak</small>
                    </h5>
                    <label class="px-3">
                        <input type="radio" name="targetCetak" value="all" checked>
                        <span>Semua</span>
                    </label>
                    <label class="px-3">
                        <input type="radio" name="targetCetak" value="asisten">
                        <span>Asisten</span>
                    </label>
                    <label class="px-3">
                        <input type="radio" name="targetCetak" value="calas">
                        <span>Calon Asisten</span>
                    </label>
                </div>
            </div>
            <br>
            <div class="row my-2">
                <div class="input-field center">
                    <button type="button" class="modal-close waves-effect waves-light btn grey hoverable mr-1"><i class="material-icons left">arrow_back</i>Batal</button>
                    <button type="submit" class="waves-effect waves-light btn teal hoverable">Cetak <i class="material-icons right">send</i></button>
                </div>
            </div>
        </form>
    </div>
</div>