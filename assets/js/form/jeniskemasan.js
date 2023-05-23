var base_url_tag = global_url+'jeniskemasan/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }    
    $("#menu_data").addClass("active");
    $("#menu_data_jenis_kemasan").addClass("active"); 
});

function loadData(url) {
    $.ajax({
        url: url
    })
    .done(function( msg ) {
        $("#form-head").html("Edit Jenis Kemasan");
        $("#id").val(msg.id_jenis_kemasan);
        $("#jenis_kemasan").val(msg.jenis_kemasan);
        console.log(msg);
    });
    return false;
}

function deleteData(id) {
    locationDel = base_url_tag+"delete/"+id;
    msg = "Apakah Anda Akan menghapus Data Kemasan Ini ? ";
    
    var r = confirm(msg);
    if (r==true) {
           window.location = locationDel;
    }
}