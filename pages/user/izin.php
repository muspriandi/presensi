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
                    <a href="index_user.php?hal=tambah-izin" class="waves-effect waves-light btn teal lighten-1 col m10 s10 offset-m1 offset-s1 my-2 hoverable"><i class="material-icons left">add_circle</i><strong>+</strong>Izin<i class="material-icons right">event_note</i></a>
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
                                    <small class="grey-text">Data Harian Asisten</small>
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