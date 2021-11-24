<div class="row">
    <div class="col m12 s12 mt-3">
        <div class='card hoverable'>
            <div class="card-content">
                <div class="card-title center">
                    <div class="hr-sect">
                        <h5 class="mt-0 mx-1 blue-text">
                            Data Asisten<br>
                            <small class="grey-text">Data Profil Asisten Lab ICT Terpadu</small>
                        </h5>
                    </div>
                </div>

                <div class="row center">
                    <a href="index.php?hal=tambah-asisten" class="waves-effect waves-light btn blue lighten-1 my-3 hoverable col m8 s10 offset-m2 offset-s1"><i class="material-icons left">add_circle</i><strong>+</strong>Asisten<i class="material-icons right">person_add</i></a>
                </div>

                <table class="responsive-table centered dataTables">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Jurusan</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="listDataAsisten">
                        <!--  DIISI MELALUI JAVASCRIPT -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modalDetail" class="modal">
    <div class="modal-content mx-5 mt-3">
        <div class="hr-sect center mt-0">
            <h5 class="mt-0 blue-text">Detail Data Asisten</h5>
        </div>
        
        <table class="responsive-table">
            <tbody>
                <tr>
                    <th width="20%">Nomor Induk Mahasiswa</th>
                    <td id="get_nim"></td>
                    <th width="20%">Jenis Kelamin</th>
                    <td id="get_jenis_kelamin"></td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td id="get_nama"></td>
                    <th>Status</th>
                    <td id="get_status"></td>
                </tr>
                    <th width="20%">Fakultas</th>
                    <td id="get_fakultas"></td>
                    <th width="20%">Jurusan</th>
                    <td id="get_jurusan"></td>
                </tr>
                <tr>
                    <th width="20%">Email</th>
                    <td id="get_surel"></td>
                    <th width="20%">Nomor Telepon</th>
                    <td id="get_no_telp"></td>
                </tr>
                <tr>
                    <th width="20%">Jabatan</th>
                    <td id="get_jabatan"></td>
                    <th width="20%">IMEI</th>
                    <td id="get_imei"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer mb-2">
        <button id="btnUbahStatus"  class="waves-effect waves-light btn orange hoverable mx-5 left"></button>
        <button class="modal-close waves-effect waves-light btn grey hoverable mx-5"><i class="material-icons left">close</i> Tutup</button>
    </div>
</div>

<div id="modalUpdate" class="modal">
    <div class="modal-content mx-5 mt-3">
        <div class="hr-sect center mt-0">
            <h5 class="mt-0 blue-text">Ubah Data Asisten</h5>
        </div>
        <form id='update_form' method="post">
            <div class="row my-0">
                <div class="input-field col m5 s12 offset-m1">
                    <label for="nim">NIM</label>
                    <input id="nim" type="number" class="valid" name="nim" readonly required>
                </div>
                <div class="input-field col m5 s12">
                    <label for="nama">Nama Lengkap</label>
                    <input id="nama" type="text" class="validate" name="nama" required>
                </div>
            </div>
            <div class="row my-0">
                <div class="input-field col m5 s12 offset-m1">
                    <label for="surel">Alamat Surel</label>
                    <input id="surel" type="email" class="validate" name="surel" required>
                </div>
                <div class="col m5 s12">
                    <label>Jenis Kelamin</label>
                    <p>
                        <label class="mr-4">
                            <input type="radio" class="validate with-gap" id="Laki-laki" name="jenis_kelamin" value="Laki-Laki">
                            <span>Laki-laki</span>
                        </label>
                        <label>
                            <input type="radio" class="validate with-gap" id="Perempuan" name="jenis_kelamin" value="Perempuan">
                            <span>Perempuan</span>
                        </label>
                    </p>
                </div>
            </div>
            <div class="row my-0">
                <div class="input-field col m5 s12 offset-m1">
                    <label for="no_telp">Nomor <i>Handphone</i></label>
                    <input id="no_telp" type="number" class="validate" name="no_telp" required>
                </div>
                <div class="input-field col m5 s12">
                    <label for="imei">IMEI <i>Handphone</i> Android</label>
                    <input id="imei" type="number" class="validate" name="imei" required>
                </div>
            </div>
            <div class="row my-0">
                <div class="input-field col m10 s12 offset-m1">
                    <select name="jabatan">
                        <option id="CALAS" value="Calon Asisten">Calon Asisten</option>
                        <option id="Asisten" value="Asisten">Asisten</option>
                        <option id="Supervisor" value="Supervisor">Supervisor</option>
                    </select>
                    <label>Jabatan</label>
                </div>
                <div class="input-field col m10 s12 offset-m1">
                    <label for="kata_sandi">Kata Sandi</label>
                    <input type="password" class="validate" name="kata_sandi">
                </div>
            </div>
            <div class="row my-2">
                <div class="input-field center">
                    <button type="button" class="modal-close waves-effect waves-light btn grey hoverable mr-1"><i class="material-icons left">arrow_back</i>Batal</button>
                    <button type="submit" class="waves-effect waves-light btn teal hoverable">Ubah <i class="material-icons right">send</i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="modalDelete" class="modal">
    <div class="modal-content mx-5 mt-3 center">
        <div class="hr-sect mt-0">
            <h5 class="mt-0 blue-text">Hapus Data Asisten</h5>
        </div>

        <p>Apakah Anda yakin ingin menghapus data Asisten: <span id="get_nimHapus"></span> - <span id="get_namaHapus"></span>?</p>
        
        <div class="row my-0">
            <div class="input-field center my-3">
                <button type="button" class="modal-close waves-effect waves-light btn grey hoverable mr-1"><i class="material-icons left">arrow_back</i>Batal</button>
                <button id="btnHapus" class="waves-effect waves-light btn red hoverable"><i class="material-icons right">delete</i> Hapus</button>
            </div>
        </div>
    </div>
</div>