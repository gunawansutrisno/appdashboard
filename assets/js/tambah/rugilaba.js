var base_url_tag = global_url + 'tambahan/';
var idagen = $('#id').val();
$(function () {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();
        $('#myModal').modal('show');
    }
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_rugilaba").addClass("active");
    $(".select2").select2();
    $('#tanggal').daterangepicker({autoclose: true,
        format: 'dd-mm-yyyy', });
    $('#tanggal_kadaluarsa').daterangepicker({autoclose: true,
        format: 'dd-mm-yyyy', });

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
            url: base_url_tag + 'getDatarugilaba/',
            type: 'post',
            data: function (d) {
                d.IDprovinsi = $('#IDprovinsi').val();
            }
        },
        columns: [
            {data: 'id'},
            {data: 'createddate'},
            {data: 'bulan'},
            {data: 'tahun'},
            {data: 'action'},
        ]
    });

    $('#btnFilter').click(function () {
        dataGrid.api().ajax.reload();
    });
    $(document).ready(function () {
        $('#edit-data').on('show.bs.modal', function (event) {

            var rowid = $(event.relatedTarget).data('id');
            //alert(rowid);
            var url = base_url_tag + "getDataviewrugilaba/";
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

});
function deleteData(id) {
     $('#delete-data').on('show.bs.modal', function (event) {
        var url = base_url_tag+"deletion/"+id;
        var modal = $(this)
        modal.find('#hapus-true-data').attr("href",url);
        })
    }