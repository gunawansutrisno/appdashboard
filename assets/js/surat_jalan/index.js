
$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }
    
    $('#tanggal').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

    var dataGrid = $('#dataTable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : global_url + 'suratjalan/getDataSuratJalan/',
            type : 'post',
            data:  function(d){
                d.tgl_surat = $('#tanggal').val();
                d.intIDAgen = $('#intIDAgen').val();
                d.intIDStatus = $('#intIDStatus').val();
                d.txtStatus =  $('#txtNoSuratJalan').val();
            }
        },
        columns : [
            {data : 'created_date'},
            {data : 'no_invoice'},
            {data : 'no_surat_jalan'},
            {data : 'nama_agen'},
            {data : 'status'},
            {data : 'action'},
        ]         
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
});