<?php
    if(!empty($_SESSION['dataCetak'])) {
        $data   = $_SESSION['dataCetak'];
    }
    else {
        header('location: index.php?hal=beranda');
    }
?>
<div class="row">
    <div class="col m12 s12 my-3">
        <div class="card hoverable">
            <div class="card-content">
                <div class="card-title center">
                    <div class="hr-sect">
                        <h5 class="mt-0 mx-1 blue-text">
                            Pratinjau Laporan Presensi<br>
                            <small class="grey-text">Periode : <?php echo $data['waktu']['waktuAwal']; ?> s/d <?php echo $data['waktu']['waktuAkhir']; ?></small>
                        </h5>
                    </div>
                </div>

                <div class="center">
                    <a target="_blank" class="btn blue waves-effect waves-light m-3" href="admin/export-excel.php">Buat Excel <small style="text-transform: lowercase;">(.xls)</small></a>
                    <a target="_blank" class="btn team waves-effect waves-light m-3" href="admin/export-pdf.php">Buat PDF <small style="text-transform: lowercase;">(.pdf)</small></a>
                </div>
                <div class="m-3">
                    <table class="centered responsive-table striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Jumlah<br>Hadir</th>
                                <th>Jumlah<br>Lembur</th>
                                <th>Jumlah<br>Izin</th>
                                <th>Jumlah Waktu<br>Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                echo "<div class='row my-0'>";
                                echo    "<p class='col m2 s4'>Periode</p>";
                                echo    "<p class='col m10 s8'>: ".$data['waktu']['waktuAwal']." s/d ".$data['waktu']['waktuAkhir']."</p>";
                                echo    "<p class='col m2 s4'>Jumlah hari</p>";
                                echo    "<p class='col m10 s8'>: ".$data['waktu']['waktu']." Hari</p>";
                                echo "</div>";

                                $nomor  = 1;
                                $flag   = 0;
                                
                                echo "<tr>";
                                // LOOP DATA ASISTEN
                                for($i = 0 ; $i < count($data['data_asisten']) ; $i++) {
                        
                                    // LOOP DATA PRESENSI
                                    for($j = 0 ; $j < count($data['data_presensi']) ; $j++) {
                                        
                                        if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_presensi'][$j]['nim']) {

                                            echo "<td>".$nomor++."</td>";
                                            echo "<td>".$data['data_asisten'][$i]['nim']."</td>";
                                            echo "<td class='left'>".$data['data_asisten'][$i]['nama']."</td>";
                                            echo "<td>".$data['data_presensi'][$j]['totalHadir']."</td>";

                                            // LOOP DATA LEMBUR
                                            for($k = 0 ; $k < count($data['data_lembur']) ; $k++) {
                                                if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_lembur'][$k]['nim']) {

                                                    echo "<td>".$data['data_lembur'][$k]['totalLembur']."</td>";
                                                    $flag   = 1;
                                                }
                                            }

                                            if($flag == 0) {
                                                echo "<td>0</td>";
                                            }
                                            $flag = 0;
                                            
                                            // LOOP DATA PRESENSI
                                            for($k = 0 ; $k < count($data['data_izin']) ; $k++) {
                                                
                                                if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_izin'][$k]['nim']) {
                                                    
                                                    echo "<td>".$data['data_izin'][$k]['totalIzin']."</td>";
                                                    $flag   = 1;
                                                }
                                            }
                                            
                                            if($flag == 0) {
                                                echo "<td>0</td>";
                                            }
                                            $flag = 0;
                                            
                                            // LOOP DATA TELAT PRESENSI
                                            $totalTelat = 0;
                                            for($k = 0 ; $k < count($data['data_telat']) ; $k++) {

                                                if($data['data_asisten'][$i]['nim'] == $data['data_telat'][$k]['nim']) {

                                                    $jumlahTelat    = (strtotime($data['data_telat'][$k]['waktu_datang']) -strtotime('08:00:00')) / 60;
                                                    $totalTelat     = $totalTelat + $jumlahTelat;

                                                    $flag   = 1;
                                                }
                                            }
                                            
                                            if($flag == 1) {
                                                echo "<td>".round($totalTelat)." Menit</td>";
                                            }
                                            else {
                                                echo "<td>0 Menit</td>";
                                            }
                                            $flag = 0;
                                        }
                                    }
                                    
                                    echo "</tr>";
                                }
                                
                                if(count($data['data_presensi']) == 0) {
                                    echo    "   <td colspan='7' class='p-3 cPointer'><h5>Laporan tidak tersedia!<br><small>Tidak ada presensi masuk pada periode ini.</small></h5></td>
                                            </tr>";
                                }
                                // unset($_SESSION['dataCetak']);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>