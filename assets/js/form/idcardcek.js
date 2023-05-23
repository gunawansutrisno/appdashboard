var base_url_tag = global_url + 'idcard/';
var base_url = global_url + 'searc/';
var idagen = $('#id').val();
$(function () {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_idcard").addClass("active");
    $(".select2").select2();
    $('#tanggal').daterangepicker({autoclose: true,
        format: 'dd-mm-yyyy',});
    $(document).ready(function () {
        $('#update-data').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget).data('id');
            var url = base_url_tag + "update/" + div;
            var modal = $(this)
            modal.find('#update-true-data').attr("href", url);
        })

    });
       $('#nama').autocomplete({
            minLength:5,
                serviceUrl: base_url_tag+"getDataPPK",
                onSelect: function (suggestion) {
                    $('#value').val(''+suggestion.nama);
//                    $('#code').val(''+suggestion.code);
////                    $('#tgl_periksa').val(''+suggestion.tgl_periksa);
                }
            });
    var dataGrid = $('#datatable').dataTable({
        processing: true,
        responsive: {breakpoints: [{name: 'bigdesktop', width: Infinity},
                                    {name: 'meddesktop', width: 1480},
                                    {name: 'smalldesktop', width: 1280},
                                    {name: 'medium', width: 1188},
                                    {name: 'tabletl', width: 1024},
                                    {name: 'btwtabllandp', width: 848},
                                    {name: 'tabletp', width: 768},
                                    {name: 'mobilel', width: 480},
                                    {name: 'mobilep', width: 320}
                                  ]
                    },
        serverSide: false,
        searching: true,
        ajax: {
            url: base_url_tag + 'getData/',
            type: 'post',
            data: function (d) {
                d.IDprovinsi = $('#IDprovinsi').val();
            }
        },
        columns: [
            
            {data: 'nomor'},
            {data: 'nik'},
            {data: 'nama'},
//            {data: 'nama_pt'},
            {data: 'transportasi'},
            {data: 'pekerjaan'},
            {data: 'status_pekerjaan'},
            {data: 'tgl'},
            {data: 'qrcode'},
            {data: 'action'},
        ]
    });
    
    $('#btnFilter').click(function () {
        dataGrid.api().ajax.reload();
    });
    $(document).ready(function () {
        $('#delete-data').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget).data('id');
//            alert(div);exit;
            var url = base_url_tag + "delete/";
             $.ajax({
                url: url,
                type: "POST",
                data: 'div=' + div,
                success: function (data) {
                     $("#ids").val(div);
                }
            })
        })

    });
     $(document).ready(function() {
        $('#edit-data').on('show.bs.modal', function (event) {
           
            var rowid = $(event.relatedTarget).data('id');
            //alert(rowid);
            var url = base_url_tag+"getDataview/";
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
    $(document).ready(function () {
        $('#detail-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            var url = base_url_tag + "getDataview1/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched_preview-data').html(data);
                }
            })
        });
    });
    $(document).ready(function () {
        $('#qrcode-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            var url = base_url_tag + "getDataview2/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched_qr-data').html(data);
                }

            })
        });
    });
    $("#id_surat").change(function () {
        var id_surat = $("#id_surat").val();
        if (id_surat != 0) {
            $("#add_barang").css("display", "inline");
            resetBarang();
        }
        else {
            $(".pilih_barang").attr("disabled", "disabled");
            $("#add_barang").css("display", "none");
            resetBarang();
        }
    });
    
    $(document).ready(function () {
        $('#search-data').on('show.bs.modal', function (event) {
//            var rowid = $(event.relatedTarget).data('id');
            var url = base_url + "searching/";
            $.ajax({
                url: url,
                type: "POST",
                 data: {nosep : $("#nama").val()}, // data yang akan dikirim ke file proses
                success: function (data) {
                     $("#ids").val(data);
//                    $('.fetched_preview-data').html(data);
                }
            })
        });
    });
//    $(document).ready(function(){
//  $("#loading").hide(); 
//  
//    $("#btnFilter").click(function(){ 
//        search(); 
//    });
//    
//    $("#nama").keyup(function(){ // Ketika user menekan tombol di keyboard
//    if(event.keyCode==13){ // Jika user menekan tombol ENTER
//      search(); // Panggil function search
//    }
//  });
//});
});
function removeBarang(id) {
    var dly = 50;
    $("#" + id).remove();
}
function addBarang() {
    var idRow = $('#tabel_barang tr:last').attr('data-id');
    if (idRow == undefined) {
        idRow = 0;
    } else {
        idRow = parseInt(idRow) + 1;
        var lastRow = parseInt($('#index_row').val());
    }
    var lastRow = parseInt($('#index_row').val());
    if (lastRow != idRow) {
        lastRow = idRow;
        var nextRow = lastRow;
    } else {
        lastRow = parseInt(lastRow);
        var nextRow = lastRow + 1;
    }

    var htmlRow = $("#barang_0").html();
    htmlRow = htmlRow.replace('style="display: none;"', '');
    htmlRow = htmlRow.split("dari_0").join("dari_" + idRow);
    htmlRow = htmlRow.split("kepada_0").join("kepada_" + idRow);
    htmlRow = '<tr id="barang_' + idRow + '" data-id="' + idRow + '">' + htmlRow + '</tr>';
    $("#tabel_barang tbody").append(htmlRow);
    $('#index_row').val(nextRow);
}
function resetBarang() {
    var lastRow = parseInt($('#index_row').val());
    for (var i = 2; i <= lastRow; i++) {
        if ($("#barang_" + i).length > 0) {
            $("#barang_" + i).remove();
        }
    }
    $("#dari_1").val("");
    $("#kepada_1").val("");
    $('#index_row').val("1");
}