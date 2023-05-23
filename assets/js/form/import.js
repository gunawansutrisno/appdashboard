var base_url_tag = global_url+'pasien/';
var idagen = $('#id').val();
$(function() {
  
    
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show'); 
    }
    $("#kosong").hide();
    $("#menu_file").addClass("active");
    $("#menu_add_file").addClass("active");
    $(".select2").select2();
    $(document).ready(function(){
        $("#ni").keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
                $("#pesan").html("isikan No Telphone Dengan Benar").show().fadeOut("slow");
                return false;
            }
        });
    });
//    $(document).ready(function(){
//        $("#telp").keypress(function(data){
//            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
//            {
//                $("#pesan").html("").show().fadeOut("slow");
//                return false;
//            }
//        });
//    });
//    $(document).ready(function(){
//        $("#nama").keypress(function(data){
//            if(data.which!=8 && data.which!=0 && (data.which<12))
//            {
//                $("#pesa").html("isikan No Telphone Dengan Benar").show().fadeOut("slow");
//                return false;
//            }
//        });
//    });
//    
$(document).ready(function() {
		   $( "#tahun" ).change(function() {
			 var dob = $( "#tahun" ).val();
			
			 if(dob != ''){
                           var dat = new Date();
                           var tahun = dat.getFullYear();
                          //  alert(n);
                            var dayDiff = Math.ceil(tahun - dob);
                            var age = parseInt(dayDiff);
                          // alert(age);
                           $('#age').val(age+' Tahun');
                        } 
		  });
                  return false;
      });
   // var dob = $('#tahun').val();
   
       
    $(document).ready(function() {
        $('#edit-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
//            alert(rowid);
            var url = base_url_tag+"getCekPasien/";
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
            var url = base_url_tag+"getDetPasien/";
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
            url : base_url_tag + 'getDataPasienAll/',
            type : 'post',
            data:  function(d){
                d.telp = $('#telp').val();
                d.nama_pasien = $('#nama_pasien').val();
                d.alamat = $('#alamat').val();
                d.kode_pasien = $('#kode_pasien').val();
            }
        },
        columns : [
            {data : 'kode_pasien'},
//            {data : 'nik'},
            {data : 'nama'},
            {data : 'alamat'},
            {data : 'telp'},
//            {data : 'status_pasien'},
            
            {data : 'kode_dokter'},
            {data :  'action'},
        ]         
    });

    $('#btnFilter').click(function() {        
        dataGrid.api().ajax.reload();
    });
   
    
});
