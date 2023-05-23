var base_url_tag = global_url+'level/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }    
    $("#menu_pengguna").addClass("active");
    $("#menu_user_level").addClass("active");
});

function loadData(url) {
    $(".allowed_menu_list").prop("checked", false);
    $.ajax({
        url: url
    })
    .done(function( msg ) {
        
        $("#form-head").html("Edit Level");
        $("#id").val(msg.id);
        $("#nama").val(msg.nama);
        jQuery.each(msg.allowed_menu, function (i, val){
            $("#"+val.menu).prop("checked",true);
        });
    });
    return false;
}

function deleteData(id) {
    locationDel = base_url_tag+"delete/"+id;
    msg = "Apakah Anda Akan menghapus Agen Ini ? ";
    
    var r = confirm(msg);
    if (r==true) {
           window.location = locationDel;
    }
}