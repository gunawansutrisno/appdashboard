var base_url_tag = global_url+'jenistindakan/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }

   $('#formworkorder').on('keypress', function(e){
        return e.which !== 13;
    });
    
     $("#menu_data").addClass("active");
    $("#menu_data_jenis_tindakan").addClass("active"); 
     
    var dataGrid = $('#datatable').dataTable({
        processing : true,
        serverSide : true,
        searching : false,
        ajax : {
            url : base_url_tag + 'ajax_list/',
            type : 'post',
            data:  function(d){
                d.IDprovinsi = $('#IDprovinsi').val();
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
});
function loadData(url) {
//    alert(url);
    $.ajax({
        url: url
    })
    .done(function( msg ) {
         var segments = url.split( '/' );
        var action = segments[3];
        var controller = segments[4];
        var fungsi = segments[5];
        var id = segments[6];
//        alert(id);
        if(id != 0) {
        $("#form-head").html("Edit Data ICD ");
        $("#id").val(msg.id);
        $("#name").val(msg.name);
//          $("#in_bahasa").val(msg.in_bahasa);
        console.log(msg);
         $("#batal").css("display","inline");
         } else {
              $("#batal").css("display","none");
         }
    });
    return false;
}


function deleteData(id) {
     $('#delete-data').on('show.bs.modal', function (event) {
//        var div = $(event.relatedTarget).data(id);
        var url = base_url_tag+"delete/"+id;
//alert(url);
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href",url);
        })
//    locationDel = base_url_tag+"delete/"+id;
////    msg = "Apakah Anda Akan menghapus Data Kabupaten / Kota Ini ? ";
//    
//    var r = confirm(msg);
//    if (r==true) {
//           window.location = locationDel;
//    }
    }