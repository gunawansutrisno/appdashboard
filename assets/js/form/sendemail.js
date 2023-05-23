var base_url_tag = global_url+'email/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }

   $('#formworkorder').on('keypress', function(e){
        return e.which !== 13;
    });
    
     $("#menu_data").addClass("active");
    $("#menu_data_email").addClass("active"); 
    
    $("#formicd").submit(function(){
        var id = $("#id").val();
        var nama = $("#nama").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var subject = $("#subject").val();
        var deskripsi = $("#deskripsi").val();
        if(id == ""){
           if(nama == ""){
               alert("Nama Pengirim tidak boleh kosong!");
               return false;
           }
           if(email == ""){
               alert("Email Pengirim tidak boleh kosong!");
               return false;
           }
           if(password == ""){
               alert("password tidak boleh kosong!");
               return false;
           }
           if(subject == ""){
               alert("subject tidak boleh kosong!");
               return false;
           }
           return true;
        }
    });
    var dataGrid = $('#datatable').dataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        searching: true,
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
        $("#form-head").html("Edit Data ");
        $("#id").val(msg.id);
        $("#nama").val(msg.nama);
          $("#email").val(msg.email);
          $("#subject").val(msg.subject);
          $("#deskripsi").val(msg.isi);
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
        var url = base_url_tag+"delete/"+id;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href",url);
        })
    }