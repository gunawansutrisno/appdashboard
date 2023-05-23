var base_url_tag = global_url+'jenisobat/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }    
    $("#menu_data").addClass("active");
    $("#menu_data_jenis_barang").addClass("active"); 
});

function loadData(url) {
    $.ajax({
        url: url
    })
    .done(function( msg ) {
        $("#form-head").html("Edit Jenis Obat");
        $("#id").val(msg.id);
        $("#nama").val(msg.nama_jenis);
//        $("#jenis_barang").val(msg.jenis_barang);
    });
    return false;
}

function deleteData(id) {
    locationDel = base_url_tag+"delete/"+id;
    msg = "Apakah Anda Akan menghapus Jenis Obat Ini ? ";
    
    var r = confirm(msg);
    if (r==true) {
           window.location = locationDel;
    }
}