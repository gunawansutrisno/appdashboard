var base_url_tag = global_url + 'surat/';
var idagen = $('#id').val();
$(function () {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }
    $("#menu_preview").addClass("active");
//    $("#menu_transaksi_diagnostik").addClass("active");
    $(".select2").select2();
     $('#date1').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
    });
    $('#date2').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
    });
    $(document).ready(function () {
        $('#update-data').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget).data('id');
            var url = base_url_tag + "update/" + div;
            var modal = $(this)
            modal.find('#update-true-data').attr("href", url);
        })

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
    $(document).ready(function () {
        $('#edit-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');            
            var url = base_url_tag + "edit/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('#id').val(rowid);
                }
            })
        });
    });
    $(document).ready(function () {
        $('#detail-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            var url = base_url_tag + "getDataview/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched-data').html(data);
                }
            })
        });
    });
    $(document).ready(function () {
        $('#print-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            var url = base_url_tag + "getDataview/";
            $.ajax({
                url: url,
                type: "POST",
                data: 'rowid=' + rowid,
                success: function (data) {
                    $('.fetched-data').html(data);
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
