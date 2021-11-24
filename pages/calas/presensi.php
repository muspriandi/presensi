<div class="row">
    <div class="col m8 s12 my-3">
        <div class="card hoverable">
            <div class="card-content">
                <div class="card-title center">
                    <div class="hr-sect">
                        <h5 class="mt-0 mx-1 blue-text">
                            Presensi Asisten Lab ICT Terpadu<br>
                            <small class="grey-text">Presensi Tanggal <span id="waktuDataPresensi"></span></small>
                        </h5>
                    </div>
                </div>
                
                <table class="striped responsive-table centered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Waktu Datang</th>
                            <th>Waktu Pulang</th>
                            <th>Jumlah Telat</th>
                        </tr>
                    </thead>
                    <tbody id="listDataPresensiCalas">
                        <!--  DIISI MELALUI JAVASCRIPT -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col m4 s12 mt-3">
        <div class="row">
            <div class="col m12 s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <div class="card-title center">
                            <div class="hr-sect">
                                <h5 class="mt-0 blue-text">
                                    Rekap Harian<br>
                                    <small class="grey-text">Data Harian Asisten</small>
                                </h5>  
                            </div>
                        </div>
                        <table class="striped responsive-table centered">
                            <tr>
                                <td id="hadirCalonAsisten">0 Asisten</td>
                                <td class="green-text">Hadir</td>
                            </tr>
                            <tr>
                                <td id="tidakHadirCalonAsisten">0 Asisten</td>
                                <td class="red-text">Tidak Hadir</td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td id="tepatCalonAsisten">0 Asisten</td>
                                <td class="green-text">Tepat Waktu</td>
                            </tr>
                            <tr>
                                <td id="telatCalonAsisten">0 Asisten</td>
                                <td class="red-text">Terlambat</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col m12 s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <div class="card-title center">
                            <div class="hr-sect">
                                <h5 class="mt-0 blue-text">
                                    Ganti Presensi<br>
                                    <small class="grey-text">Ganti Waktu Presensi</small>
                                </h5>  
                            </div>
                        </div>
                        <div class="row center">
                            <button value="" id="btnGantiWaktu" class="datepicker waves-effect waves-light btn teal lighten-1 col m10 s10 offset-m1 offset-s1 my-2 hoverable"><i class="material-icons right">event</i>Ganti Waktu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>