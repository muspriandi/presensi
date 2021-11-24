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

                <div class="row center">
                    <a href="index.php?hal=tambah-presensi" class="waves-effect waves-light btn teal lighten-1 col m10 s10 offset-m1 offset-s1 my-2 hoverable"><i class="material-icons left">add_circle</i><strong>+</strong>Presensi<i class="material-icons right">event_available</i></a>
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
                    <tbody id="listDataPresensi">
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
                                    <small class="grey-text">Data Presensi Asisten</small>
                                </h5>  
                            </div>
                        </div>
                        <table class="striped responsive-table centered">
                            <tr>
                                <td id="hadir">0 Asisten</td>
                                <td class="green-text">Hadir</td>
                            </tr>
                            <!-- <tr>
                                <td id="izin">0 Asisten</td>
                                <td class="orange-text">Izin</td>
                            </tr> -->
                            <tr>
                                <td id="tidakHadir">0 Asisten</td>
                                <td class="red-text">Tidak Hadir</td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td id="tepat">0 Asisten</td>
                                <td class="green-text">Tepat Waktu</td>
                            </tr>
                            <tr>
                                <td id="telat">0 Asisten</td>
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

<div id="modalDetailPresensi" class="modal">
    <div class="modal-content mx-5 mt-3 center">
        <div class="hr-sect mt-0">
            <h5 class="mt-0 blue-text">Detail Presensi</h5>
        </div>
        
        <form id='update_formPresensi' method="post">

            <div class="row my-0">
                <div class="input-field col m4 s12 offset-m1">
                    <label for="nim">NIM</label>
                    <input type="text" class="valid" id="get_nimPresensi" name="nim" readonly required>
                </div>
                <div class="input-field col m6 s12">
                    <label for="nama">Nama</label>
                    <input type="text" class="valid" id="get_namaPresensi" readonly>
                </div>
            </div>
            
            <div class="row my-0">
                <div class="input-field col m5 s12 offset-m1">
                    <label for="waktu_datang">Waktu Datang</label>
                    <input type="text" id="waktu_datang" name="waktu_datang" class="timepicker cPointer validate" required>
                </div>
                <div class="input-field col m5 s12">
                    <label for="waktu_pulang">Waktu Pulang</label>
                    <input type="text" id="waktu_pulang" name="waktu_pulang" class="timepicker cPointer validate" required>
                </div>
            </div>

            <div class="row my-0">
                <div class="input-field col m10 s12 offset-m1" id="waktuIndonesia">
                    <label class="active">Tanggal Presensi</label>
                </div>
            </div>
            
            <div class="row my-0">
                <div class="input-field center my-3">
                    <button id="btnHapusPresensi" class="waves-effect waves-light btn red hoverable mr-2"><i class="material-icons right">delete</i> Hapus</button>
                    <button type="submit" class="modal-close waves-effect waves-light btn orange hoverable ml-2"><i class="material-icons left">edit</i> Ubah</button>
                </div>
            </div>
        
        </form>
    </div>
</div>