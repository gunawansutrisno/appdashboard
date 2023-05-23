var base_url_tag = global_url+'transaksi/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_data").addClass("active");
    
    $('#tanggal').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
     $(".select2").select2();
    var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag + 'getDataTransaksi/',
            type : 'post',
            data:  function(d){
                d.no_invoice = $('#no_invoice').val();
                d.tgl_surat = $('#tanggal').val();
                d.status_pembayaran = $('#status_pembayaran').val();
                d.status_barang = $('#status_barang').val();
                d.id_agen =  $('#id_agen').val();
            }
        },
        columns : [
            {data : 'tanggal_transaksi'},
            {data : 'no_invoice'},
            {data : 'nama_agen'},
            {data : 'total_tagihan'},
            {data : 'status_barang'},
            {data : 'status_pembayaran'},
            {data : 'action'},
        ]         
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
});
