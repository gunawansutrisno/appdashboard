var base_url_tag = global_url+'transaksi/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_riwayat").addClass("active");
    $(".select2").select2();
    var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag + 'getDataRiwayat/',
            type : 'post',
            data:  function(d){
                d.id_agen =  $('#id_agen').val();
                d.status =  $('#status').val();
            }
        },
        columns : [
            {data : 'tanggal_transaksi'},
            {data : 'no_invoice'},
            {data : 'nama_agen'},
            {data : 'jumlah_pembayaran'},
            {data : 'sisa_pembayaran'},
            {data : 'status_pembayaran'},
            {data : 'action'},
        ]         
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
});
