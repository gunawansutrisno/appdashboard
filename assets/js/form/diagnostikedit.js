var base_url_tag = global_url+'surat/';
var idagen = $('#id').val();
$(function() {
 
    
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show'); 
    }
    
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_diagnostik").addClass("active");
    $(".select2").select2();
    
    $('#date1').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        daysOfWeekDisabled: [0, 6],
    });
    $('#date2').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        daysOfWeekDisabled: [0, 6],
    });     
     
    
    $( "#id_surat" ).change(function() {
         var id_surat = $( "#id_surat" ).val();
          if(id_surat == "surat masuk") {
                $("#formnomor").css("display", "inline");
            } else {
                 $("#formnomor").css("display", "none");
            }
         if(id_surat != 0){
//            loadDataAgen(id_surat);
//            $(".pilih_barang").removeAttr("disabled");
            $("#add_barang").css("display","inline");
            resetBarang();
         }
         else{
            $(".pilih_barang").attr("disabled","disabled");
            $("#add_barang").css("display","none");
            resetBarang();
         }
         
      });
       CKEDITOR.replace('editor1')
    $('.textarea').wysihtml5()
});
function removeBarang(id){
    var dly = 50;
    $("#"+id).remove();
}
function addBarang(){
    var idRow = $('#tabel_barang tr:last').attr('data-id');
    if( idRow == undefined){
        idRow = 0;
    }else{
        idRow = parseInt(idRow)+1;
          var lastRow = parseInt($('#index_row').val());
    }
    var lastRow = parseInt($('#index_row').val());
   if(lastRow != idRow){
       lastRow = idRow;
       var nextRow = lastRow;
   } else {
       lastRow = parseInt(lastRow);
       var nextRow = lastRow+1;
   }
   
    var htmlRow = $("#barang_0").html();
    htmlRow = htmlRow.replace('style="display: none;"', '');
    htmlRow = htmlRow.split("dari_0").join("dari_"+idRow); 
    htmlRow = htmlRow.split("kepada_0").join("kepada_"+idRow);
//    htmlRow = htmlRow.split("diskon_0").join("diskon_"+idRow);
//    htmlRow = htmlRow.split("harga_0").join("harga_"+idRow);
//    htmlRow = htmlRow.split("total_0").join("total_"+idRow);
//    htmlRow = htmlRow.split("delete_0").join("delete_"+idRow);
//    htmlRow = htmlRow.split("barang_0").join("barang_"+idRow);
    htmlRow = '<tr id="barang_'+idRow+'" data-id="'+idRow+'">'+htmlRow+'</tr>';
    $("#tabel_barang tbody").append(htmlRow);
    $('#index_row').val(nextRow);
}
function resetBarang(){
    var lastRow = parseInt($('#index_row').val());
    for(var i=2; i <= lastRow; i++){
        if($("#barang_"+i).length > 0){
            $("#barang_"+i).remove();
        }
    }
    $("#dari_1").val("");
    $("#kepada_1").val("");
    $('#index_row').val("1");
}