<div class="row">
    <div class="col m12 s12 mt-3">
        <div class='card hoverable'>
            <div class="card-content">
                <div class="card-title center">
                    <div class="hr-sect">
                        <h5 class="mt-0 mx-1 blue-text">
                            Tambah Asisten<br>
                            <small class="grey-text">Entry Data Asisten Baru</small>
                        </h5>
                    </div>
                </div>

                <form id='registration_form' method="post">
                    <div class="row my-0">
                        <div class="input-field col m5 s12 offset-m1">
                            <label for="nim">NIM</label>
                            <input id="nim" type="number" class="validate" name="nim" required>
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
                            <p class="pt-2">
                                <label class="mr-5">
                                    <input type="radio" class="validate with-gap" name="jenis_kelamin" value="Laki-Laki" checked>
                                    <span>Laki-laki</span>
                                </label>
                                <label>
                                    <input type="radio" class="validate with-gap" name="jenis_kelamin" value="Perempuan">
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
                                <option value="Calon Asisten" selected>Calon Asisten</option>
                                <option value="Asisten">Asisten</option>
                                <option value="Supervisor">Supervisor</option>
                            </select>
                            <label>Jabatan</label>
                        </div>
                        <div class="input-field col m10 s12 offset-m1">
                            <label for="kata_sandi">Kata Sandi</label>
                            <input id="kata_sandi" type="password" class="validate" name="kata_sandi" required>
                        </div>
                        <div class="input-field col m10 s12 offset-m1">
                            <a href="index.php?hal=asisten" class="modal-close waves-effect waves-light btn grey col m3 s5 offset-m3 offset-s1 mr-1 hoverable"><i class="material-icons left">arrow_back</i>Kembali</a>
                            <button type="submit" class="waves-effect waves-light btn teal lighten-1 col m3 s5 ml-1 hoverable">Simpan<i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>