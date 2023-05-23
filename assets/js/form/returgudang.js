var base_url_tag = global_url+'retur/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }

    $('.money-input').mask("#.##0", {reverse: true});    
    $(".select2").select2();

   $('#tanggal').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
     $('#date').datepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
    $('#formTransaksi').on('keypress', function(e){
        return e.which !== 13;
    });
    
    $("#menu_gudang").addClass("active");
    $("#menu_rbarang").addClass("active");
    $(".select2").select2();
    var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag + 'getDataReturGudang/',
            type : 'post',
            data:  function(d){
                d.tanggal = $('#tanggal').val();
                d.status_retur = $('#status_retur').val();
                d.id_agen =  $('#id_agen').val();
            }
        },
        columns : [
            {data : 'tanggal_retur'},
            {data : 'no_retur_barang'},
            {data : 'no_invoice'},
            {data : 'nama_agen'},
            {data : 'jumlah_retur'},
            {data : 'status_retur'},
            {data : 'action'},
           
            
        ]         
    });

    /*$(document).on('click', '#export-xls', function(){
        $('[name="tgl"]').val($('#tanggal').val());
        $('[name="id_jenis_barang"]').val($('#jenis_barang').val());
        $('[name="barang"]').val($('#id_barang').val());
        
    });*/

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
     
});