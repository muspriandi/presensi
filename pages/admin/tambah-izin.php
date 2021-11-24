<div class="row">
    <div class="col m12 s12 mt-3">
        <div class='card hoverable'>
            <div class="card-content">
                <div class="card-title center">
                    <div class="hr-sect">
                        <h5 class="mt-0 mx-1 blue-text">
                            Tambah Izin<br>
                            <small class="grey-text">Entry Data Izin Asisten</small>
                        </h5>
                    </div>
                </div>

                <form id='izin_form' method="post">
                    <div class="row my-0">
                        <div class="input-field col m10 s12 offset-m1">
                            <select name="nim" id="cmbIzinAsisten">
                                <!-- DIISI MELALUI JAVASCRIPT -->
                            </select>
                            <label>NIM - Nama Asisten</label>
                        </div>
                    </div>
                    <div class="row my-0">
                        <div class="input-field col m5 s12 offset-m1">
                            <label for="waktuIzinAwal">Waktu Izin Awal</label>
                            <input type="text" id="waktuIzinAwal" name="waktuIzinAwal" class="datepickerIzin cPointer validate" required>
                        </div>
                        <div class="input-field col m5 s12">
                            <label for="waktuIzinAkhir">Waktu Izin Akhir <small>(Opsional)</small></label>
                            <input type="text" id="waktuIzinAkhir" name="waktuIzinAkhir" class="datepickerIzin cPointer validate">
                        </div>
                    </div>
                    <div class="row my-0">
                        <div class="input-field col m10 s12 offset-m1">
                            <label for="keterangan">Keterangan Izin</label>
                            <textarea name="keterangan" id="keterangan" class="materialize-textarea validate" required></textarea>
                        </div>
                    </div>
                    <div class="row my-0 pb-3">
                        <div class="input-field col m10 s12 offset-m1">
                            <a href="index.php?hal=izin" class="modal-close waves-effect waves-light btn grey col m3 s5 offset-m3 offset-s1 mr-1 hoverable"><i class="material-icons left">arrow_back</i>Kembali</a>
                            <button type="submit" class="waves-effect waves-light btn teal lighten-1 col m3 s5 ml-1 hoverable">Izin<i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>