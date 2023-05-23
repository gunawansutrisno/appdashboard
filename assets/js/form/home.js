var base_url_tag = global_url+'articles/';
// alert(base_url_tag);
$(function() {
    var str = window.location.href;
    // alert(str);
    $("#menu_dashboard").addClass("active");

    var dataGrid = $('#datatables').dataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        searching: true,
        ajax : {
            url : base_url_tag + 'ajax_list/',
            type : 'post',
            data:  function(d){
                d.url = $('#url').val();
                d.tahun = $('#tahun').val();
                d.bulan = $('#bulan').val();
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
    $(document).ready(function () {
        $('#detail-data').on('show.bs.modal', function (event) {
            var rowid = $(event.relatedTarget).data('id');
            // alert(base_url_tag);
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