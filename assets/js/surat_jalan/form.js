var base_url_tag = global_url+'transaksi/';

function formatRepo (repo) {
      if (repo.loading) return repo.text;
      var markups = "<div class='select2-result-repository clearfix'>" +
          "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.no_invoice + " - "+repo.nama_agen+"</div>"+
          "<div class='select2-result-repository__description'>Tanggal Transaksi : " + repo.tanggal_transaksi + "</div>"
          +"</div></div>";
      ///markups = repo.txtIndonesianName;
      return markups;
}
    
function formatRepoSelection (repo) {
      return repo.no_invoice || repo.text;
}

var jenis_pengiriman = "";
var id_trans_barang = $('input[name=id_trans_barang]').val();
$( document ).ready(function(){
    $('#tanggal').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });

    $('#formSuratJalan').validate({
        rules : {
            "txtNoInvoice" : {
                required : true,
            },
            "alamat_pengiriman" : {
                required : true,
            },
            "intIDColi[]" : {
                min : 1,
            },
            "ongkir" : {
                required : true,
            }
        }  
    });    

    var idJenisPengiriman = $('#jenis_pengiriman').val();
    showPengiriman(idJenisPengiriman);
    getDetailAgenByNoInvoice(id_trans_barang);
    
    $('#jenis_pengiriman').change(function(){
        idJenisPengiriman = $('#jenis_pengiriman').val();
        showPengiriman(idJenisPengiriman);
    });
    
});



function getDetailAgenByNoInvoice(id_trans_barang){
    $.ajax({
        url : global_url+'transaksi/getAgenByNoInvoice/',
        type : "POST",
        data : "id_trans_barang="+id_trans_barang,
        success : function msg(response){
            var result = $.parseJSON(response);
            var status = result['status'];
            if(status==true){
                var data = result['data'];
                $('#nama_agen').val(data['nama_agen']);
                $('#alamat').val(data['alamat']);
                $('#no_telpon').val(data['no_telpon']);
                $('#nama_pemilik').val(data['nama_pemilik']);
                if($('#alamat_pengiriman').val()==""){
                    $('#alamat_pengiriman').val(data['alamat']);
                }
                
            }
        }
    });
}

function showPengiriman(id_pengiriman){
    if(id_pengiriman==1){
        $('.form_mandiri').css("display" , "inherit");
        $('.form_agen').css("display" , "none");
        $( "#agen_pengiriman" ).rules( "remove");
        $( "#no_resi" ).rules( "remove");
    }else{
        $('.form_mandiri').css("display" , "none");
        $('.form_agen').css("display" , "inherit");
        $( "#agen_pengiriman" ).rules( "add",{
            required : true,
        });
    }
}