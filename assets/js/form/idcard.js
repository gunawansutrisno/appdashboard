var base_url_tag = global_url + 'idcard/';
var idagen = $('#id').val();
$(function () {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_masterdata").addClass("active");
    $(".select2").select2();
    $('#tanggal').daterangepicker({autoclose: true,
        format: 'dd-mm-yyyy', });
    $('#tanggal_kadaluarsa').daterangepicker({autoclose: true,
        format: 'dd-mm-yyyy', });
    $(document).ready(function () { // Ketika halaman sudah siap (sudah selesai di load)
        $("#check-all").click(function () { // Ketika user men-cek checkbox all
            if ($(this).is(":checked")) { // Jika checkbox all diceklis
                $(".check-item").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"
                $("#btn-delete").css("display", "inline");
            } else {// Jika checkbox all tidak diceklis
                $(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
                $("#btn-delete").css("display", "none");
            }
        });

        $("#btn-delete").click(function () { // Ketika user mengklik tombol delete
            var confirm = window.confirm("Apakah Anda yakin ingin Mengirim semua email ke semua master data?"); // Buat sebuah alert konfirmasi

            if (confirm) // Jika user mengklik tombol "Ok"
                $("#form-send").submit(); // Submit form
        });
    });
     
    $(document).ready(function () {
        $('#update-data').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget).data('id');
            var url = base_url_tag + "update/" + div;
            var modal = $(this)
            modal.find('#update-true-data').attr("href", url);
        })

    });
    $('#nama').autocomplete({
        minLength: 5,
        serviceUrl: base_url_tag + "getDataPPK",
        onSelect: function (suggestion) {
            $('#value').val('' + suggestion.nama);
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
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nopol'},
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
//    $(document).ready(function () {
//        $('#delete-data').on('show.bs.modal', function (event) {
//            var div = $(event.relatedTarget).data('id');
//            
//            var url = base_url_tag + "delete/";
//         
//            $.ajax({
//                url: url,
//                type: "POST",
//                data: 'div=' + div,
//                success: function (data) {
//                    $("#idd").val(div);
//                }
//            })
//        })
//
//    });
    $(document).ready(function () {
        $('#edit-data').on('show.bs.modal', function (event) {

            var rowid = $(event.relatedTarget).data('id');
            //alert(rowid);
            var url = base_url_tag + "getDataview/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched-data').html(data);
                    $('#tanggal_kadaluarsa').daterangepicker({autoclose: true,
                        format: 'dd-mm-yyyy', });

                    $('#tanggal').daterangepicker({autoclose: true,
                        format: 'dd-mm-yyyy', });
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
    $(document).ready(function () {
        $('#send-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            var url = base_url_tag + "getDataSend/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched_send-data').html(data);
                     CKEDITOR.replace('editor1')
    $('.textarea').wysihtml5();
                }

            })
        });
    });
    $(document).ready(function () {
        $('#send-data_all').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
//            alert(rowid);
            var url = base_url_tag + "getDataSend_All/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched_send_all-data').html(data);
                }

            })
        });
    });

});
function deleteData(id) {
     $('#delete-data').on('show.bs.modal', function (event) {
        var url = base_url_tag+"delete/"+id;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href",url);
        })
    }
//function checkAll(ele) {
//       var checkboxes = document.getElementsByTagName('input');
//       if (ele.checked) {
//           for (var i = 0; i < checkboxes.length; i++) {
//               if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
//                   checkboxes[i].checked = true;
//               }
//           }
//            $("#add_barang").css("display","inline");
//       } else {
//           for (var i = 0; i < checkboxes.length; i++) {
//               if (checkboxes[i].type == 'checkbox') {
//                   checkboxes[i].checked = false;
//               }
//           }
//           $("#add_barang").css("display","none");
//       }
//   }