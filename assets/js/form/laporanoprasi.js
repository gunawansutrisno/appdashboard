var base_url_tag = global_url+'Laporan/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }

    $('.money-input').mask("#.##0", {reverse: true});    
    $(".select2").select2();
    
     $('#date1').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
    });
    $('#date2').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
    });
    $('#formTransaksi').on('keypress', function(e){
        return e.which !== 13;
    });
    
    $("#menu_laporan").addClass("active");
    $("#menu_laporan_fico").addClass("active");
    
    var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag + 'getData/',
            type : 'post',
            data:  function(d){
                d.date1 = $('#date1').val();
                d.date2 = $('#date2').val();
                d.nomor_surat = $('#nomor_surat').val();
                d.isi_ringkasan = $('#isi_ringkasan').val();
                d.kode = $('#kode').val();
            }
        },
        columns : [
            {data : 'nomor'},
            {data : 'kode'},
            {data : 'dari'},
            {data : 'kepada'},
            {data : 'tgl'},
            {data : 'isi'},
//            {data : 'notes'},
            
        ]         
    });

    $(document).on('click', '#export-xls', function(){
        $('[name="date1"]').val($('#date1').val());
        $('[name="date2"]').val($('#date2').val());        
        $('[name="status"]').val($('#status_pembayaran').val());   
        
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
     
});