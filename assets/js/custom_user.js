$(document).ready(function() {
    // INISIALISASI OBJEK
    var indo    = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
    var date    = new Date(indo);

    // AKTIFKAN KOMPONEN MATERIALIZE
    $('.sidenav').sidenav();
    $('.dropdown-trigger').dropdown();
    $('.modal').modal();
    $('.fixed-action-btn').floatingActionButton();
    $('.datepickerAll').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        maxDate: new Date(date.getFullYear(),date.getMonth(),date.getDate())
    });
    $('.datepickerIzin').datepicker({
        format: 'yyyy-mm-dd',
        minDate: new Date(date.getFullYear(),date.getMonth(),date.getDate())
    });

    // DETIK DI PRESENSI
    displayTime();
    setInterval('displayTime()', 1000);

    validateToken();

    // VALIDASI JWT
    function validateToken() {

        // WAKTU HARI INI, FORMAT (TAHUN-BULAN-HARI)
        var now     = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();

        if(now.length == 9) {
            var now     = date.getFullYear()+"-0"+(date.getMonth()+1)+"-"+date.getDate();
        }

        // GET JWT DARI CACHE
        var jwt     = getCookie('jwt');

        var token   = JSON.stringify({jwt:jwt});

        // CEK VALID/TIDAKNYA JWT
        $.ajax({
            url         : "../api/validate_token.php",
            type        : "POST",
            contentType : 'application/json',
            data        : token,
            success     : function(result) {
                if(result.success == 1) {

                    if(result.data.jabatan == "Asisten" || result.data.jabatan == "Calon Asisten") {

                        $('.userName').html(result.data.nama);
                        // $('.userNIM').html(result.data.nim);
                        $('#getNIM').val(result.data.nim);
                        $("#getAsisten").append('<input class="valid black-text" value="'+result.data.nim+" - "+result.data.nama+'" disabled required readonly>');
                        retrievePresensi(result.data.nim);
                        retrieveAllPresensi(now);
                        retrieveAllPresensiCalas(now);
                        retrieveAllIzin(now);
                        $("#allContent").css("display", "unset");
                    }
                    else {
                        swal ( "Akses ditolak." , "Silahkan Masuk untuk Melanjutkan." ,  "warning" , {
                            buttons: false,
                            closeOnClickOutside: false,
                            timer: 2000,
                        })
                        .then(function() {
                            location.href = "http://localhost/Presensi/";
                        });
                    }
                }
                else {
                    swal ( result.message , "Silahkan Masuk untuk Melanjutkan." ,  "warning" , {
                        buttons: false,
                        closeOnClickOutside: false,
                        timer: 2000,
                    })
                    .then(function() {
                        location.href = "http://localhost/Presensi/";
                    });
                }
            },
            error       : function() {
                swal ( data.message , "Silahkan Masuk untuk Melanjutkan." ,  "warning" , {
                    buttons: false,
                    closeOnClickOutside: false,
                    timer: 2000,
                })
                .then(function() {
                    location.href = "http://localhost/Presensi/";
                });
            }
        });
    }

    // get or read cookie
    function getCookie(cname) {

        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' '){
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    // function to make form values to json format
    $.fn.serializeObject = function(){
    
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
});

// FUNGSI MENAMPILKAN DETIK SAAT ENTRY PRESENSI BARU
function displayTime() {
    var indo = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
    var time = new Date(indo);
    var sh = time.getHours() + "";
    var sm = time.getMinutes() + "";
    var ss = time.getSeconds() + "";

    var second   = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
    $("#clock").html(second);
}

function estimasiWaktu(id) {

    var indo = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
    var time = new Date(indo);
    var sh = time.getHours() + "";
    var sm = time.getMinutes() + "";
    var ss = time.getSeconds() + "";

    var waktuSekarang       = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
    var splitwaktuSekarang  = waktuSekarang.split(":");

    var splitwaktuDatang    = id.split(":");
    var jam     = parseInt(splitwaktuDatang[0]) + parseInt("08");
    var menit   = parseInt(splitwaktuDatang[1]);
    var detik   = parseInt(splitwaktuDatang[2]);
    
    if(jam < 16) {
        jam     = parseInt("16") - parseInt(splitwaktuSekarang[0]);
        menit   = parseInt(splitwaktuSekarang[1]);
        if(menit < 0) {
            jam     = jam - 1;
            menit   = parseInt(60) + parseInt(menit);
        }
    }
    else {
        jam     = parseInt(jam) - parseInt(splitwaktuSekarang[0]);
        menit   = parseInt(menit) - parseInt(splitwaktuSekarang[1]);
        detik   = parseInt(detik) - parseInt(splitwaktuSekarang[2]);

        if(menit < 0) {
            jam     = jam - 1;
            menit   = parseInt(60) + parseInt(menit);
        }
        if(detik < 0) {
            menit   = menit - 1;
            detik   = parseInt(60) + parseInt(detik);
        }
    }
    
    if(menit < 0 || jam < 0 || jam == 0 && menit == 0 && detik == 0) {
        $("#pesanPresensi").html('<label class="orange-text">Anda dapat melakukan presensi pulang sekarang!.</label>');
    }
    else {
        if(jam == 0 && menit == 0) {
            $("#estimasiWaktu").html(detik+" detik lagi");
        }
        else {
            $("#estimasiWaktu").html(jam+" jam "+menit+" menit");
        }
    }
}

// FUNGSI TAMPIL DATA PRESENSI TIAP ASISTEN
function retrievePresensi(id) {
    // SELECT DATA DARI DB
    $.ajax({
        url         : "proses/retrieve_presenceUser.php",
        type        : "POST",
        data        : id,
        success     : function(result) {
            var data = jQuery.parseJSON(result);
            
            if(data.data == "") {
                $("#waktuDatang").html("-");
                $("#waktuTelat").html("-");
                $("#pesanPresensi").html('<label class="red-text">Anda belum melakukan presensi hari ini. Segeralah lakukan!</label>');
            }
            else {

                $("#waktuDatang").html(data.data[0].waktu_datang);

                if(data.data[0].waktu_datang < "08:00:00") {
                    $("#waktuTelat").html("0 Menit");
                }
                else {
                    var splitwaktuDatang    = data.data[0].waktu_datang.split(":");
                    var jam     = parseInt(splitwaktuDatang[0]) - parseInt("08");
                    var menit   = parseInt(splitwaktuDatang[1]);
                    menit       = jam*60 + menit;
                    
                    $("#waktuTelat").html(menit+" Menit");
                }

                if(data.data[0].waktu_pulang == null) {
                    $("#pesanPresensi").html('<label class="orange-text">Estimasi waktu untuk melakukan presensi pulang : <strong id="estimasiWaktu">1 Jam 20 Menit</strong>.</label>');
                    
                    // ESTIMASI WAKTU
                    waktu_datang = data.data[0].waktu_datang;
                    estimasiWaktu(waktu_datang);
                    setInterval('estimasiWaktu(waktu_datang)', 1000);
                }
                else {
                    if(data.data[0].waktu_datang != null && data.data[0].waktu_pulang != null) {
                        $("#pesanPresensi").html('<label class="teal-text">Anda telah melakukan presensi pulang. Terima Kasih!</label>');
                    }
                    else {
                        $("#waktuDatang").html("-");
                        $("#waktuTelat").html("-");
                        $("#pesanPresensi").html("-");
                    }
                }
            }
        },
        error       : function() {
            location.href = "http://localhost/Presensi/pages/index_user.php?hal=beranda";
        }
    });
}

// FUNGSI TAMPIL SELURUH DATA PRESENSI BERDASARKAN TANGGAL
function retrieveAllPresensi(id) {
    // SELECT DATA DARI DB
    $.ajax({
        url         : "proses/retrieve_presence.php",
        type        : "POST",
        data        : id,
        success     : function(result) {
            var data = jQuery.parseJSON(result);
            var tableContent = "";
            var number  = 1;
            var tepat   = 0;
            var telat   = 0;

            $.each(data.data, function () {

                tableContent += `
                    <tr class="hoverable cPointer">
                        <td>`+number+`</td>
                        <td>`+this.nim+`</td>
                        <td>`+this.nama+`</td>
                `;

                if(this.waktu_datang > '08:00:00') {
                    tableContent += `<td class="red-text">`+this.waktu_datang+`</td>`;
                    telat   = telat + 1;
                }
                else {
                    tableContent += `<td class="green-text">`+this.waktu_datang+`</td>`;
                    tepat   = tepat + 1;
                }
                
                if(this.waktu_pulang != null) {
                    tableContent += `<td>`+this.waktu_pulang+`</td>`;
                }
                else {
                    tableContent += `<td>-</td>`;
                }

                if(this.waktu_datang > '08:00:00') {
                    
                    splitmenitDatang    = this.waktu_datang.split(":");
                    menitDatang         = (parseInt(splitmenitDatang[0]) * 60) + parseInt(splitmenitDatang[1]);
                    menitTelat          = parseInt(menitDatang) - (parseInt("08") * 60) + parseInt("00");

                    tableContent += `<td class="orange-text">`+menitTelat+` Menit</td>`;
                }
                else {
                    tableContent += `<td>-</td>`;
                }

                tableContent += `</tr>`;

                number++;
            });

            if(number == 1) {
                tableContent += `<tr>
                                    <td colspan='6' class='p-3 cPointer'><h5>Belum ada yang Hadir<br><small>Data hadir asisten masih kosong!</small></h5></td>
                                </tr>`;
            }
            
            var waktuDataPresensi = ubahFormatkeID(id);

            $("#waktuDataPresensi").html(waktuDataPresensi);
            $("#hadir").html((tepat+telat) +" Asisten");
            $("#tidakHadir").html((data.data2-(tepat+telat)) +" Asisten");
            $("#tepat").html(tepat+" Asisten");
            $("#telat").html(telat+" Asisten");
            $("#listDataPresensi").html(tableContent);
        },
        error       : function() {
            location.href = "http://localhost/Presensi/pages/index_user.php?hal=beranda";
        }
    });
}

// FUNGSI TAMPIL SELURUH DATA PRESENSI CALAS BERDASARKAN TANGGAL
function retrieveAllPresensiCalas(id) {
    // SELECT DATA DARI DB
    $.ajax({
        url         : "proses/retrieve_presenceCalas.php",
        type        : "POST",
        data        : id,
        success     : function(result) {
            var data = jQuery.parseJSON(result);
            var tableContent = "";
            var number  = 1;
            var tepat   = 0;
            var telat   = 0;
            var menitDatang = 0;
            var menitTelat  = 0;

            var indo    = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
            var date    = new Date(indo);
            var now     = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();

            if(now.length == 9) {
                var now     = date.getFullYear()+"-0"+(date.getMonth()+1)+"-"+date.getDate();
            }

            $.each(data.data, function () {

                if(id == now) {
                    tableContent += `
                        <tr data-target="modalDetailPresensi" onclick="getDataPresensi('`+this.nim+`')" class="modal-trigger hoverable cPointer">
                    `;
                }
                else {
                    tableContent += `
                        <tr class="hoverable cPointer">
                    `;
                }

                tableContent += `
                        <td>`+number+`</td>
                        <td>`+this.nim+`</td>
                        <td>`+this.nama+`</td>
                `;

                if(this.waktu_datang > '07:30:00') {
                    tableContent += `<td class="red-text">`+this.waktu_datang+`</td>`;
                    telat   = telat + 1;
                }
                else {
                    tableContent += `<td class="green-text">`+this.waktu_datang+`</td>`;
                    tepat   = tepat + 1;
                }
                
                if(this.waktu_pulang != null) {
                    tableContent += `<td>`+this.waktu_pulang+`</td>`;
                }
                else {
                    tableContent += `<td>-</td>`;
                }

                if(this.waktu_datang > '07:30:00') {
                    
                    splitmenitDatang    = this.waktu_datang.split(":");
                    menitDatang         = (parseInt(splitmenitDatang[0]) * 60) + parseInt(splitmenitDatang[1]);
                    menitTelat          = parseInt(menitDatang) - (parseInt("07") * 60) - parseInt("30");

                    tableContent += `<td class="orange-text">`+menitTelat+` Menit</td>`;
                }
                else {
                    tableContent += `<td>-</td>`;
                }

                tableContent += `</tr>`;

                number++;
            });

            if(number == 1) {
                tableContent += `<tr>
                                    <td colspan='6' class='p-3 cPointer'><h5>Belum ada yang Hadir<br><small>Data hadir calon asisten masih kosong!</small></h5></td>
                                </tr>`;
            }
            
            var waktuDataPresensi = ubahFormatkeID(id);

            $("#waktuDataPresensi").html(waktuDataPresensi);
            $("#hadirCalonAsisten").html((tepat+telat) +" Calon Asisten");
            $("#tidakHadirCalonAsisten").html((data.data2-(tepat+telat)) +" Calon Asisten");
            $("#tepatCalonAsisten").html(tepat+" Calon Asisten");
            $("#telatCalonAsisten").html(telat+" Calon Asisten");
            $("#listDataPresensiCalas").html(tableContent);
        },
        error       : function() {
            location.href = "http://localhost/Presensi/pages/index.php?hal=beranda";
        }
    });
}

// FUNGSI TAMPIL SELURUH DATA IZIN BERDASARKAN TANGGAL
function retrieveAllIzin(id) {
    // SELECT DATA DARI DB
    $.ajax({
        url         : "proses/retrieve_izin.php",
        type        : "POST",
        data        : id,
        success     : function(result) {
            var data = jQuery.parseJSON(result);
            var tableContent = "";
            var number  = 1;

            $.each(data.data, function () {

                tableContent += `
                    <tr class="hoverable cPointer">
                        <td>`+number+`</td>
                        <td>`+this.nim+`</td>
                        <td>`+this.nama+`</td>
                        <td>`+this.keterangan+`</td>
                    </tr>`;

                number++;
            });

            if(number == 1) {
                tableContent += `<tr>
                                    <td colspan='4' class='p-3 cPointer'><h5>Belum ada yang Izin<br><small>Data izin asisten masih kosong!</small></h5></td>
                                </tr>`;
            }
            
            var waktuDataIzin = ubahFormatkeID(id);

            $("#waktuDataIzin").html(waktuDataIzin);
            $("#izin").html(data.data2 +" Asisten");
            $("#izinCalonAsisten").html(data.data3 +" Calon Asisten");
            $("#listDataIzin").html(tableContent);
        },
        error       : function() {
            location.href = "http://localhost/Presensi/pages/index_user.php?hal=beranda";
        }
    });
}

// FUNGSI UBAH FORMAT WAKTU MENJADI FORMAT WAKTU INDONESIA
function ubahFormatkeID(id) {
    var waktuIndonesia = "";
    var tahun   = id.substr(0,4);
    var bulan   = "";
    var tanggal = id.substr(8,2);
    if(tanggal == "") {
        tanggal = "0"+id.substr(7,1);
    }

    switch(id.substr(5,2)) {
        case '01' : bulan = "Januari"; break;
        case '02' : bulan = "Februari"; break;
        case '03' : bulan = "Maret"; break;
        case '04' : bulan = "April"; break;
        case '05' : bulan = "Mei"; break;
        case '06' : bulan = "Juni"; break;
        case '07' : bulan = "Juli"; break;
        case '08' : bulan = "Agustus"; break;
        case '09' : bulan = "September"; break;
        case '10' : bulan = "Oktober"; break;
        case '11' : bulan = "November"; break;
        case '12' : bulan = "Desember"; break;

        default : bulan = "-";
    }

    if(bulan == "-") {
        switch(id.substr(5,1)) {
            case '1'  : bulan = "Januari"; break;
            case '2'  : bulan = "Februari"; break;
            case '3'  : bulan = "Maret"; break;
            case '4'  : bulan = "April"; break;
            case '5'  : bulan = "Mei"; break;
            case '6'  : bulan = "Juni"; break;
            case '7'  : bulan = "Juli"; break;
            case '8'  : bulan = "Agustus"; break;
            case '9'  : bulan = "September"; break;
            case '10' : bulan = "Oktober"; break;
            case '11' : bulan = "November"; break;
            case '12' : bulan = "Desember"; break;
        }
    }
    
    waktuIndonesia = tanggal+ " " +bulan+ " " +tahun;

    $("#waktuIndonesia").find('input').remove();
    $("#waktuIndonesia").append('<input class="valid black-text" value="'+waktuIndonesia+'" disabled required readonly>');

    return waktuIndonesia;
}

// FUNGSI GANTI WAKTU PRESENSI
$("#btnGantiWaktu").on('change', function() {
    var date = $("#btnGantiWaktu").val();
    retrieveAllPresensi(date);
    retrieveAllPresensiCalas(date);
    retrieveAllIzin(date);
})

// KETIKA SUBMIT TAMBAH DATA IZIN
$(document).on('submit', '#izin_form', function(){
    // GET FORM DATA
    var izin_form       = $(this);
    var form_data       = JSON.stringify(izin_form.serializeObject());

    // KIRIM form_data DENGAN AJAX
    $.ajax({
        url         : "proses/izinIn.php",
        type        : "POST",
        contentType : 'application/json',
        data        : form_data,
        success     : function(x) {
            
            var data = JSON.parse(x);
            swal ( "Berhasil!" ,  data.message ,  "success" )
            .then(function() {
                location.href = "http://localhost/Presensi/pages/index_user.php?hal=izin";
            });
        },
        error       : function(x) {

            var data = JSON.parse(x.responseText);
            swal ( "Oops..." ,  data.message ,  "error" )
            .then(function() {

                $("#izin_form").trigger('reset');
                M.updateTextFields();
            });
        }
    });

    return false;
})
