<?php
    ob_start();

    session_start();
    if(!empty($_SESSION['dataCetak'])) {
        $data   = $_SESSION['dataCetak'];
    }
    else {
        header('location: index.php?hal=beranda');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="Aplikasi Presensi" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Presensi - Lab ICT Terpadu</title>
	</head>
	<body>
		<?php
			$namafile = "Lap-Presensi[".$data['waktu']['waktuAwal']."-".$data['waktu']['waktuAkhir']."]";
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=$namafile.xls");
            
            ob_clean();
		?>
		<table style="text-align: center;">
			<thead>
				<?php
                    echo '  <tr>
                                <td></td>
								<th colspan="7" style="border: 0"><h2>Laporan Kehadiran Asisten<br><small>Lab ICT Terpadu Universitas Budi Luhur</small></h2></th>
							</tr>
                            <tr style="text-align: left;">
                                <td></td>
								<th style="text-align: left;" colspan="2">Periode</th>
								<td colspan="4">: '.$data['waktu']['waktuAwal']." s/d ".$data['waktu']['waktuAkhir'].'</td>
							</tr>
                            <tr style="text-align: left;">
                                <td></td>
								<th style="text-align: left;" colspan="2">Jumlah hari</th>
								<td colspan="4">: '.$data['waktu']['waktu'].' Hari</td>
							</tr>';
				?>
				<tr>
					<td><br></td>
				</tr>
                <tr>
                    <td></td>
                    <th style="border: 1px solid black;">No</th>
                    <th style="border: 1px solid black;">NIM</th>
                    <th style="border: 1px solid black;">Nama Asisten</th>
                    <th style="border: 1px solid black;">Jumlah<br>Hadir</th>
                    <th style="border: 1px solid black;">Jumlah<br>Lembur</th>
                    <th style="border: 1px solid black;">Jumlah<br>Izin</th>
                    <th style="border: 1px solid black;">Jumlah Waktu<br>Keterlambatan</th>
                </tr>
            </thead>
            <tbody>
				<?php
                    $nomor  = 1;
                    $flag   = 0;
                    // LOOP DATA ASISTEN
                    for($i = 0 ; $i < count($data['data_asisten']) ; $i++) {
                        // LOOP DATA PRESENSI
                        for($j = 0 ; $j < count($data['data_presensi']) ; $j++) {
                            if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_presensi'][$j]['nim']) {
                                echo "<tr>";
                                echo "<td></td>";
                                echo "<td  style='border: 1px solid black;' style='text-align: center;'>".$nomor++."</td>";
                                echo "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_asisten'][$i]['nim']."</td>";
                                echo "<td  style='border: 1px solid black;' style='text-align: left;'>".$data['data_asisten'][$i]['nama']."</td>";
                                echo "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_presensi'][$j]['totalHadir']."</td>";
                                // LOOP DATA LEMBUR
                                for($k = 0 ; $k < count($data['data_lembur']) ; $k++) {
                                    if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_lembur'][$k]['nim']) {
                                        echo "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_lembur'][$k]['totalLembur']."</td>";
                                        $flag   = 1;
                                    }
                                }
                                if($flag == 0) {
                                    echo "<td  style='border: 1px solid black;' style='text-align: center;'>0</td>";
                                }
                                $flag = 0;
                                // LOOP DATA PRESENSI
                                for($k = 0 ; $k < count($data['data_izin']) ; $k++) {
                                    
                                    if($flag == 0 && $data['data_asisten'][$i]['nim'] == $data['data_izin'][$k]['nim']) {
                                        
                                        echo "<td  style='border: 1px solid black;' style='text-align: center;'>".$data['data_izin'][$k]['totalIzin']."</td>";
                                        $flag   = 1;
                                    }
                                }
                                if($flag == 0) {
                                    echo "<td  style='border: 1px solid black;' style='text-align: center;'>0</td>";
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
                                    echo "<td  style='border: 1px solid black;' style='text-align: center;'>".round($totalTelat)." Menit</td>";
                                }
                                else {
                                    echo "<td  style='border: 1px solid black;' style='text-align: center;'>0 Menit</td>";
                                }
								$flag = 0;
								
								echo "</tr>";
                            }
                        }
                    }
                    // unset($_SESSION['dataCetak']);
                ?>
			</tbody>
		</table>
	</body>
</html>