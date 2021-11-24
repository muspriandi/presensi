$(document).ready(function(){
    // MERESET JWT YANG DISIMPAN DALAM COOKIE
    setCookie("jwt", "", 1);

    // trigger when login form is submitted
    $(document).on('submit', '#login_form', function(){

        // get form data
        var login_form  = $(this);
        var form_data   = JSON.stringify(login_form.serializeObject());
    
        // submit form data to api
        $.ajax({
            url         : "pages/proses/login.php",
            type        : "POST",
            contentType : 'application/json',
            data        : form_data,
            success     : function(result) {
        
                // store jwt to cookie
                setCookie("jwt", result.jwt, 1);
                
                // show home page & tell the user it was a successful login
                swal ( "Berhasil!" ,  result.message ,  "success" , {
                    buttons: false,
                    closeOnClickOutside: false,
                    timer: 2000,
                })
                .then(function() {
                    if(result.jabatan == "Supervisor") {
                        location.href = "http://localhost/Presensi/pages/index.php?hal=beranda";
                    }
                    else {
                        if(result.jabatan == "Asisten") {
                            location.href = "http://localhost/Presensi/pages/index_user.php?hal=beranda";
                        }
                        else {
                            location.href = "http://localhost/Presensi/pages/index_calas.php?hal=beranda";
                        }
                    }
                });
            },
            error       : function(x) {
                // on error, tell the user login has failed & empty the input boxes
                var data = JSON.parse(x.responseText);
                swal ( "Oops..." ,  data.message ,  "error" )
                .then(function() {

                    $("#login_form").trigger('reset');
                    M.updateTextFields();
                });
            }
        });
    
        return false;
    });

    // function will help us store JWT on the cookie
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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