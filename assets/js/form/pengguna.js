var base_url_tag = global_url+'pengguna/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    $("#menu_pengguna").addClass("active");
    $("#menu_add_edit_pengguna").addClass("active");
    
    $("#formPengguna").submit(function(){
        var charakter = 8;
        var id = $("#id").val();
        var nama = $("#nama").val();
        var username = $("#username").val();
        var pass = $("#password").val();
        var cpass = $("#confirm_password").val();
        if(id == ""){
           if(nama == ""){
               alert("Nama tidak boleh kosong!");
               return false;
           }
           if(username == ""){
               alert("Username tidak boleh kosong!");
               return false;
           }
           if (pass.length < charakter){
                    alert("Panjang Username Minimal 8 Karater!");
               return false;
                  }
           if(pass == "" && cpass == ""){
               alert("Password tidak boleh kosong!");
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

function loadData(url) {
    $.ajax({
        url: url
    })
    .done(function( msg ) {
        $("#form-head").html("Edit Pengguna");
        $("#id").val(msg.id);
        $("#nama").val(msg.nama);
        $("#username").val(msg.username);
        $("#id_level").val(msg.id_level);
        $("#id_company").val(msg.id_company);
        $("#pass_label").html("Ubah Password");
        $(".pass_notif").html("Kosongkan jika tidak ingin mengubah");
         console.log(msg);
         $("#batal").css("display","inline");
        
    });
    return false;
}
function deleteData(id) {
     $('#delete-data').on('show.bs.modal', function (event) {
            var url = base_url_tag+"delete/"+id;
            var modal = $(this)
            modal.find('#hapus-true-data').attr("href",url);
        })
    }
function updateData(id) {
     $('#update-data').on('show.bs.modal', function (event) {
            var url = base_url_tag+"updateNonaktif/"+id;
            var modal = $(this)
            modal.find('#update-true-data').attr("href",url);
        })
    }