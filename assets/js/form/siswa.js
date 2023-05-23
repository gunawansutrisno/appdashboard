var base_url_tag = global_url+'dokter/';
var idagen = $('#id').val();
$(function() {
  
    
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show'); 
    }
    
    $("#menu_data").addClass("active");
    $("#menu_data_siswa").addClass("active");
    $(".select2").select2();
    $(document).ready(function(){
        $("#telp").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
                $("#pesan").html("isikan angka").show().fadeOut("slow");
                return false;
            }
        });
    });
    $(document).ready(function() {
        $('#edit-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            //alert(rowid);
            var url = base_url_tag+"getCekSiswa/";
                $.ajax({
                    url: url,
                    type: "POST",
                    data :  'rowid='+ rowid,
                    success : function(data){
                    $('.fetched-data').html(data);
                    }
                   
                })
        });
    });
    $(document).ready(function() {
        $('#detail-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            var url = base_url_tag+"getDetSiswa/";
                $.ajax({
                    url: url,
                    type: "POST",
                    data :  'rowid='+ rowid,
                    success : function(data){
                    $('.fetched-data').html(data);
                    }
                   
                })
        });
    });
      $(document).ready(function(){
 
        $('#delete-data').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget).data('id');
        var url = base_url_tag+"delete/"+div;
//alert(url);
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href",url);
        })

        });
     var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        responsive: true,
        ajax : {
            url : base_url_tag + 'getDataSiswaAll/',
            type : 'post',
            data:  function(d){
                d.nis = $('#nis').val();
                d.id_siswa = $('#id_siswa').val();
            }
        },
        columns : [
            {data : 'nis'},
            {data : 'kode_dokter'},
            {data : 'nama_siswa'},
            {data : 'alamat'},
//            {data : 'id_dokter'},
            {data :  'action'},
        ]         
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
 
});
