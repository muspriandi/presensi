<div class="row">
    <div class="col m8 s12 my-3">
        <div class="card hoverable">
            <div class="card-content">
                <div class="card-title center">
                    <div class="hr-sect">
                        <h5 class="mt-0 mx-1 blue-text">
                            Izin Asisten Lab ICT Terpadu<br>
                            <small class="grey-text">Izin Tanggal <span id="waktuDataPresensi"></span></small>
                        </h5>
                    </div>
                </div>

                <div class="row center">
                    <a href="index.php?hal=tambah-izin" class="waves-effect waves-light btn teal lighten-1 col m10 s10 offset-m1 offset-s1 my-2 hoverable"><i class="material-icons left">add_circle</i><strong>+</strong>Izin<i class="material-icons right">event_note</i></a>
                </div>
                
                <table class="striped responsive-table centered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="listDataIzin">
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
                                    <small class="grey-text">Data Izin Harian</small>
                                </h5>  
                            </div>
                        </div>
                        <table class="striped responsive-table centered">
                            <tr>
                                <td id="izin">0 Asisten</td>
                                <td class="orange-text">Izin</td>
                            </tr>
                            <tr>
                                <td id="izinCalonAsisten">0 Calon Asisten</td>
                                <td class="orange-text">Izin</td>
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
                                    Ganti Izin<br>
                                    <small class="grey-text">Ganti Waktu Izin</small>
                                </h5>  
                            </div>
                        </div>
                        <div class="row center">
                            <button value="" id="btnGantiWaktu" class="datepickerAll waves-effect waves-light btn teal lighten-1 col m10 s10 offset-m1 offset-s1 my-2 hoverable"><i class="material-icons right">event</i>Ganti Waktu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDetailIzin" class="modal">
    <div class="modal-content mx-5 mt-3 center">
        <div class="hr-sect mt-0">
            <h5 class="mt-0 blue-text">Detail Izin</h5>
        </div>
        
        <form id='update_formIzin' method="post">

            <div class="row my-0">
                <div class="input-field col m4 s12 offset-m1">
                    <label for="nim">NIM</label>
                    <input type="text" class="valid" id="get_nimIzin" name="nim" readonly required>
                </div>
                <div class="input-field col m6 s12">
                    <label for="nama">Nama</label>
                    <input type="text" class="valid" id="get_namaIzin" readonly>
                </div>
            </div>
            
            <div class="row my-0">
                <div class="input-field col m10 s12 offset-m1">
                    <label for="keterangan">Keterangan Izin</label>
                    <textarea name="keterangan" id="get_keteranganIzin" class="materialize-textarea validate" required></textarea>
                </div>
            </div>

            <div class="row my-0">
                <div class="input-field col m10 s12 offset-m1" id="waktuIndonesia">
                    <label class="active">Tanggal Izin</label>
                </div>
            </div>
            
            <div class="row my-0">
                <div class="input-field center my-3">
                    <button id="btnHapusIzin" class="waves-effect waves-light btn red hoverable mr-2"><i class="material-icons right">delete</i> Hapus</button>
                    <button type="submit" class="modal-close waves-effect waves-light btn orange hoverable ml-2"><i class="material-icons left">edit</i> Ubah</button>
                </div>
            </div>
        
        </form>
    </div>
</div>