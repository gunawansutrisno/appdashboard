var base_url_tag = global_url+'profile/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    
    $("#formPengguna").submit(function(){
        var id = $("#id").val();
        var pass = $("#password").val();
        var cpass = $("#confirm_password").val();
        if(id == ""){
           if(pass == "" && cpass == ""){
               alert("Password todak boleh kosong!");
               return false;
           }
           if(pass != cpass ){
               alert("Password yang anda masukan pada confirm password tidak sama!");
               return false;
           }
           return true;
        }
        else{
            if(pass != cpass ){
               alert("Password yang anda masukan tidak sama!");
               return false;
           }
           return true;
        }
        
    });
});

