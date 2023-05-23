var base_url_tag = global_url+'transaksi/';
$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    $('.money-input').mask("#.##0", {reverse: true});    
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_data").addClass("active");
});
