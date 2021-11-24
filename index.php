<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="Aplikasi Presensi" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Presensi - Lab ICT Terpadu</title>
        
        <link rel="stylesheet" href="assets/css/materialize.min.css"/>
        <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
        <link rel="stylesheet" href="assets/css/custom.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body class="background">
        <!-- CONTENT -->
        <div class="container">
            <div class="row">
                <div class="col m6 s10 offset-m3 offset-s1 my-5">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-title center">Masuk</div>
                            <div class="divider"></div>
                            <form id='login_form' method="post">
                                <div class="row mt-3">
                                    <div class="input-field col m10 s12 offset-m1">
                                        <label for="nim">Nomor Induk Mahasiswa (NIM)</label>
                                        <input id="nim" type="number" class="validate" name="nim" required>
                                    </div>
                                    <div class="input-field col m10 s12 offset-m1">
                                        <label for="kata_sandi">Kata Sandi</label>
                                        <input id="kata_sandi" type="password" class="validate" name="kata_sandi" required>
                                    </div>
                                    <div class="input-field col m10 s12 offset-m1">
                                        <button class="waves-effect waves-light btn col m6 s12 offset-m3 blue" type="submit">Masuk <i class="material-icons right">exit_to_app</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/materialize.min.js"></script>
        <script src="assets/js/sweetalert2.all.min.js"></script>
        <script src="assets/js/custom.js"></script>
    </body>
</html>
