var base_url_tag = global_url + 'kwintansi/';

$(function () {

    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }

    $('.money-input').mask("#.##0", {reverse: true});
    $(".select2").select2();
    $('#nama').autocomplete({
        minLength: 2,
        serviceUrl: base_url_tag + "search",
        onSelect: function (suggestion) {
            $('#value').val('' + suggestion.nama);
            $('#noka').val('' + suggestion.noka);
            $('#tgl_periksa').val('' + suggestion.tgl_periksa);
        }
    });
    $('#title').autocomplete({
        minLength: 2,
        serviceUrl: base_url_tag + "getDataPPK",
        onSelect: function (suggestion) {
            $('#value').val('' + suggestion.title);
            $('#code').val('' + suggestion.code);
        }
    });
    $(".nav-tabs a").click(function () {
        $(this).tab('show');
    });
    $('#date1').datepicker({
         
        autoclose: true,
        format: 'dd-mm-yyyy',
//        daysOfWeekDisabled: [0, 6],
    });
    $('#date2').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
    });
    $('#formTransaksi').on('keypress', function (e) {
        return e.which !== 13;
    });
    $("#menu_transaksi").addClass("active");
//    $("#menu_transaksi_input").addClass("active");
    $("#menu_transaksi_diagnostik").addClass("active");
    var dataGrid = $('#datatable').dataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: base_url_tag + 'getDataKwintansi/',
            type: 'post',
            data: function (d) {
                d.date1 = $('#date1').val();
                d.date2 = $('#date2').val();
                d.status_pembayaran = $('#status_pembayaran').val();
            }
        },
        columns: [
            {data: 'nosep'},
            {data: 'pasien'},
            {data: 'tanggal'},
            {data: 'jenis_rawat'},
            {data: 'dokter'},
            {data: 'status'},
            {data: 'notes'},
        ]
    });
    CKEDITOR.replace('editor1')
    $('.textarea').wysihtml5()
    $('#btnFilter').click(function () {
        dataGrid.api().ajax.reload();
    });
    function myFunction() {
        window.print();
    }
    $("#id_surat").change(function () {
        var id_surat = $("#id_surat").val();
            if(id_surat == "surat masuk") {
                $("#formnomor").css("display", "inline");
            } else {
                 $("#formnomor").css("display", "none");
                 $("#formnomor").removeAttr("required");
            }
        if (id_surat != 0) {
            
            $(".kode").removeAttr("disabled");
            $(".no_surat").removeAttr("disabled");
            $(".nomor").removeAttr("disabled");
            $(".kategori").removeAttr("disabled");
            $(".isi_kop").removeAttr("disabled");
            $(".tanggal").removeAttr("disabled");
            $(".pilih_barang").removeAttr("disabled");
            $("#simpan").css("display", "inline");
            $("#kop").css("display", "inline");
            $("#add_barang").css("display", "inline");
            resetBarang();
        }
        else {
            $("#kop").attr("disabled", "disabled");
            $(".kategori").attr("disabled", "disabled");
            $(".kode").attr("disabled", "disabled");
            $(".no_surat").attr("disabled", "disabled");
            $(".nomor").attr("disabled", "disabled");
            $(".isi_kop").attr("disabled", "disabled");
            $(".tanggal").attr("disabled", "disabled");
            $(".pilih_barang").attr("disabled", "disabled");
            $("#add_barang").css("display", "none");
            $("#simpan").css("display", "none");
            $("#formnomor").css("display", "none");
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
    htmlRow = htmlRow.split("delete_0").join("delete_" + idRow);
    htmlRow = htmlRow.split("barang_0").join("barang_" + idRow);
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
function search() {
    $("#loading").show(); // Tampilkan loadingnya

    $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: base_url_tag + 'getSearch/', // Isi dengan url/path file php yang dituju
        data: {nosep: $("#nosep").val()}, // data yang akan dikirim ke file proses
        dataType: "json",
        beforeSend: function (e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function (response) {
            $("#loading").hide();

            if (response.status == "success") {
                $("#id").val(response.id);
                $("#name").val(response.nama);
                $("#nama").val(response.nama);
                $("#noka").val(response.noka);
                $("#tgl_periksa").val(response.tgl_periksa);
                $("#kode_pasien").val(response.kode_pasien);
            } else {
                alert("Data Tidak Ditemukan");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
        }
    });
}
$(document).ready(function () {
    $("#loading").hide();

    $("#btnFilter").click(function () {
        search();
    });

    $("#nosep").keyup(function () { // Ketika user menekan tombol di keyboard
        if (event.keyCode == 13) { // Jika user menekan tombol ENTER
            search(); // Panggil function search
        }
    });
});
$(document).ready(function () {

    $('#delete-data').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget).data('id');
        var url = base_url_tag + "delete/" + div;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href", url);
    })

});