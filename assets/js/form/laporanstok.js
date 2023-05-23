var base_url_tag = global_url+'laporanstok/';

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
    
    $('#formTransaksi').on('keypress', function(e){
        return e.which !== 13;
    });
    
    $("#menu_laporan").addClass("active");
    $("#menu_laporan_fico_keuangan").addClass("active");
    $(".select2").select2();
    var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag + 'getDataStok/',
            type : 'post',
            data:  function(d){
                d.tanggal = $('#tanggal').val();
                d.jenis_barang = $('#jenis_barang').val();
                d.id_barang =  $('#id_barang').val();
            }
        },
        columns : [
            {data : 'tanggal_transaksi'},
            {data : 'nama_barang'},
            {data : 'jumlah'},
           // {data : 'jumlah'},
            {data : 'total_tagihan'},
           
            
        ]         
    });

    $(document).on('click', '#export-xls', function(){
        $('[name="tgl"]').val($('#tanggal').val());
        $('[name="id_jenis_barang"]').val($('#jenis_barang').val());
        $('[name="barang"]').val($('#id_barang').val());
        
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
     
});