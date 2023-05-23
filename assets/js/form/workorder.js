var base_url_tag = global_url+'workorder/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }

   $('#formworkorder').on('keypress', function(e){
        return e.which !== 13;
    });
   
    $("#menu_gudang").addClass("active");
    $("#menu_work_order").addClass("active");
    
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
    $( "#id_agen" ).change(function() {
         var id_agen = $( "#id_agen" ).val();
         if(id_agen != 0){
            loadDataAgen(id_agen);
            resetBarang();
         }
         else{
            $("#alamat").val("");
            $("#no_telpon").val("");
            $("#id_kelas_harga").val("");
            $("#kelas_harga").val("");
            $("#nama_agen").val("");
            $(".pilih_barang").attr("disabled","disabled");
            $("#add_barang").css("display","none");
            resetBarang();
         }
         
      });
       $(".select2").select2();
       var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag+'dataWork/',
            type : 'post',
            data:  function(d){
                d.tanggal = $('#tanggal').val();
                d.status_work_order = $('#status_work_order').val();
                d.no_work_order =  $('#no_work_order').val();
            }
        },
        columns : [
            {data : 'tanggal_work_order'},
            {data : 'no_work_order'},
            {data : 'tanggal_selesai'},
            {data : 'status_work_order'},
            {data : 'action'},
           
            
        ]         
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
});

function addBarang(){
    var lastRow = parseInt($('#index_row').val());
    var htmlRow = $("#barang_0").html();
    var nextRow = lastRow + 1;
    htmlRow = htmlRow.replace('style="display: none;"', '');
    htmlRow = htmlRow.split("id_barang_0").join("id_barang_"+nextRow); 
    htmlRow = htmlRow.split("jumlah_0").join("jumlah_"+nextRow);
    htmlRow = htmlRow.split("delete_0").join("delete_"+nextRow);
    htmlRow = htmlRow.split("barang_0").join("barang_"+nextRow);
    htmlRow = '<tr id="barang_'+nextRow+'">'+htmlRow+'</tr>';
    $("#tabel_barang tbody").append(htmlRow);
    $('#index_row').val(nextRow);
}

function removeBarang(id){
    var dly = 50;
    $("#"+id).remove();
    setTimeout(function (){
        getTotalHarga();
    },dly);
}

function deleteData(id) {
    locationDel = base_url_tag+"delete/"+id;
    msg = "Apakah Anda Akan menghapus Detail Work Order Ini ? ";
    
    var r = confirm(msg);
    if (r==true) {
           window.location = locationDel;
    }
}