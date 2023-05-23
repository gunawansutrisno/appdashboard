var base_url_tag = global_url+'barang/';
var id_barang = $('#id').val();
$(function() {
   if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }    
    $("#menu_data").addClass("active");
    $("#menu_data_barang").addClass("active"); 
    $('.money-input').mask('#.##0' , {reverse : true}); 
      
  
      $(document).ready(function(){
            
			
        });
    var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag + 'get_baranglist/',
            type : 'post',
            data:  function(d){
                d.search = $('#search').val();
                d.id_jenis_barang = $('#id_jenis_barang').val();
            }
        },
          
    columnDefs: [
        { 
            targets : [ -1 ], //last column
            orderable: false, //set not orderable
        },
        ],

         
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
    $('#formBarang').validate({
        ignore : "",
        rules : {
            "kode_barang" :{
                required : true,
                remote : {
                    url : global_url + "barang/checkKodeBarang",
                    type : "POST"
                }
            },
            "nama_barang" :{
                required : true,
            },
            "tipe_barang" :{
                required : true,
            }
        }
    });
     if(id_barang!=""){
        $('#kode_barang').rules('remove');
        $('#kode_barang').attr("readonly" , "readonly");
    }
});

function deleteData(id) {
    locationDel = base_url_tag+"delete/"+id;
    msg = "Apakah Anda Akan menghapus Data Barang Ini ? ";
    
    var r = confirm(msg);
    if (r==true) {
           window.location = locationDel;
    }
}