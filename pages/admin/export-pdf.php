<?php
    session_start();
    if(!empty($_SESSION['dataCetak'])) {
        $data   = $_SESSION['dataCetak'];
    }
    else {
        header('location: index.php?hal=beranda');
    }

    require_once '../../assets/libs/dompdf-master/lib/html5lib/Parser.php';
    require_once '../../assets/libs/dompdf-master/src/Autoloader.php';
    Dompdf\Autoloader::register();

    // reference the Dompdf namespace
    use Dompdf\Dompdf;

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $html = '
            <h2 style="text-align: center; margin: 0;">Laporan Kehadiran Asisten</h2>
            <p style="text-align: center; margin: 0;">Lab ICT Terpadu Universitas Budi Luhur</p>
            <hr><br>
            <table>
                <tr>
                    <td><p style="text-align: left; margin: 0; font-weight: bold;">Periode</p></td>
                    <td> &nbsp; :</td>
                    <td><p style="text-align: left; margin: 0;">'.$data['waktu']['waktuAwal']." s/d ".$data['waktu']['waktuAkhir'].'</p></td>
                </tr>
                <tr>
                    <td><p style="text-align: left; margin: 0; font-weight: bold;">Jumlah Hari</p></td>
                    <td> &nbsp; :</td>
                    <td><p style="text-align: left; margin: 0;">'.$data['waktu']['waktu'].' Hari</p></td>
                </tr>
            </table>
            <table style="text-align: center; width: 100%; border-spacing: unset; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th cellspacing="0" style="border: 1px solid black;">No</th>
                        <th cellspacing="0" style="border: 1px solid black;">NIM</th>
                        <th cellspacing="0" style="border: 1px solid black; width: 190px;">Nama Asisten</th>
                        <th cellspacing="0" style="border: 1px solid black;">Jumlah<br>Hadir</th>
                        <th cellspacing="0" style="border: 1px solid black;">Jumlah<br>Lembur</th>
                        <th cellspacing="0" style="border: 1px solid black;">Jumlah<br>Izin</th>
                        <th cellspacing="0" style="border: 1px solid black;">Jumlah Waktu<br>Keterlambatan</th>
                    </tr>
                </thead>
                <tbody>';

                $nomor  = 1;
                $flag   = 0;
                // LOOP DATA ASISTEN
                for($i = 0 ; $i < count($data['data_asisten']) ; $i++) {
                    // LOOP DATA PRESENSI
                    for($j = 0 ; $j < count($data['data_presensi']) ; $j++) {
                        if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_presensi'][$j]['nim']) {
                            $html .= "<tr>";
                            $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>".$nomor++."</td>";
                            $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_asisten'][$i]['nim']."</td>";
                            $html .= "<td  style='border: 1px solid black;' style='text-align: left;'>".$data['data_asisten'][$i]['nama']."</td>";
                            $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_presensi'][$j]['totalHadir']."</td>";
                            // LOOP DATA LEMBUR
                            for($k = 0 ; $k < count($data['data_lembur']) ; $k++) {
                                if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_lembur'][$k]['nim']) {
                                    $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_lembur'][$k]['totalLembur']."</td>";
                                    $flag   = 1;
                                }
                            }
                            if($flag == 0) {
                                $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>0</td>";
                            }
                            $flag = 0;
                            // LOOP DATA PRESENSI
                            for($k = 0 ; $k < count($data['data_izin']) ; $k++) {
                                
                                if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_izin'][$k]['nim']) {
                                    
                                    $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_izin'][$k]['totalIzin']."</td>";
                                    $flag   = 1;
                                }
                            }
                            if($flag == 0) {
                                $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>0</td>";
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
                                $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>".round($totalTelat)." Menit</td>";
                            }
                            else {
                                $html .= "<td  style='border: 1px solid black;' style='text-align: center;'>0 Menit</td>";
                            }
                            $flag = 0;
                            
                            $html .= "</tr>";
                        }
                    }
                }
    
    $html .= '             
                </tbody>
            </table>';

    // Load content from html file
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation 
    $dompdf->setPaper('A4', 'portrait'); 

    // Render the HTML as PDF 
    $dompdf->render();

    // Output the generated PDF (1 = download and 0 = preview) 
    $dompdf->stream("Lap-Presensi[".$data['waktu']['waktuAwal']."-".$data['waktu']['waktuAkhir']."]", array("Attachment" => 1));
?>