var base_url_tag = global_url+'transaksi/';

$(function() {
    if ($('#myModal').length > 0) {
        $('#myModal').modal();                     
        $('#myModal').modal('show');  
    }

    $('.money-input').mask("#.##0", {reverse: true});    
    ///$('.money-input').digits();

    $(".select2").select2();

    $('#tanggal').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });
    $(".select2").select2();
    $('#formTransaksi').on('keypress', function(e){
        return e.which !== 13;
    });
    
    $("#menu_transaksi").addClass("active");
    $("#menu_transaksi_input").addClass("active");
    
    $( "#id_agen" ).change(function() {
         var id_agen = $( "#id_agen" ).val();
         if(id_agen != 0){
            loadDataAgen(id_agen);
            $(".pilih_barang").removeAttr("disabled");
            $("#add_barang").css("display","inline");
            resetBarang();
         }
         else{
            $("#alamat").val("");
            $("#no_telpon").val("");
            $("#id_kelas_harga").val("");
            $("#kelas_harga").val("");
            $("#nama_agen").val("");
            $(".pilih_barang").attr("disabled","disabled");
            $("#add_barang").css("display","none");
            resetBarang();
         }
         
      });
     
});

function getHarga(row){
    var dly = 50;
    var id_barang = $("#"+row).val();
    var indexRow = row.replace('id_barang_','');
    var id_kelasharga = $("#id_kelas_harga").val();
    var dup = checkDuplicate();
    if(dup == false){
        setTimeout(function (){
            $.ajax({
                url: base_url_tag+'getharga/'+id_barang+'/'+id_kelasharga
            })
            .done(function( msg ) {
                if(msg != null){
                    $("#harga_"+indexRow).val(toCurrency(msg.harga_barang));
                }
                else{
                    $("#harga_"+indexRow).val("0");
                }
                $("#jumlah_"+indexRow).val("0");
                $("#diskon_"+indexRow).val("0");
                $("#total_"+indexRow).val("0");
                getTotalHarga();
            });
            return false;
        },dly);
    }
    else{
        $("#"+row).val(0);
        alert("Duplikat barang, Barang yang anda pilih sudah terdaftar");
    }
    
    
}

function checkDuplicate(){
    var key = [];
    var results = [];
    var ret = false;
    $(".pilih_barang").each(function(){
        key.push(this.value);        
    });
    var sorted_arr = key.slice().sort(); 
    
    for (var x = 0; x < key.length - 1; x++) {
        if (sorted_arr[x + 1] == sorted_arr[x] && sorted_arr[x + 1] != 0) {
            results.push(sorted_arr[x]);
        }
    }
    
    if(results.length > 0){
        ret = true;
    }
    
    return ret;
}

function addBarang(){
    var idRow = $('#tabel_barang tr:last').attr('data-id');
    if( idRow == undefined){
        idRow = 0;
    }else{
        idRow = parseInt(idRow)+1;
          var lastRow = parseInt($('#index_row').val());
    }
    var lastRow = parseInt($('#index_row').val());
   if(lastRow != idRow){
       lastRow = idRow;
       var nextRow = lastRow;
   } else {
       lastRow = parseInt(lastRow);
       var nextRow = lastRow+1;
   }
   
    var htmlRow = $("#barang_0").html();
    htmlRow = htmlRow.replace('style="display: none;"', '');
    htmlRow = htmlRow.split("id_barang_0").join("id_barang_"+idRow); 
    htmlRow = htmlRow.split("jumlah_0").join("jumlah_"+idRow);
    htmlRow = htmlRow.split("diskon_0").join("diskon_"+idRow);
    htmlRow = htmlRow.split("harga_0").join("harga_"+idRow);
    htmlRow = htmlRow.split("total_0").join("total_"+idRow);
    htmlRow = htmlRow.split("delete_0").join("delete_"+idRow);
    htmlRow = htmlRow.split("barang_0").join("barang_"+idRow);
    htmlRow = '<tr id="barang_'+idRow+'" data-id="'+idRow+'">'+htmlRow+'</tr>';
    $("#tabel_barang tbody").append(htmlRow);
    $('#index_row').val(nextRow);
}

function removeBarang(id){
    var dly = 50;
    $("#"+id).remove();

    setTimeout(function (){
        getTotalHarga();
    },dly);
}

function resetBarang(){
    var lastRow = parseInt($('#index_row').val());
    for(var i=2; i <= lastRow; i++){
        if($("#barang_"+i).length > 0){
            $("#barang_"+i).remove();
        }
    }
    $("#id_barang_1").val("0");
    $("#jumlah_1").val("0");
    $("#diskon_1").val("0");
    $("#harga_1").val("0");
    $("#total_1").val("0");
    $("#total_tagihan").val("0");
    $("#ongkir").val("0");
    $("#tipe_pembayaran").val("tunai");
    $("#jumlah_terbayar").val("0");
    $("#sisa_pembayaran").val("0");
    $('#index_row').val("1");
}

function getTotalHargaItem(row){
    $(".maks").mask("#.##0",{reverse:true});
    var dly = 50;
    var indexRow = row.replace('id_barang_','');
    
    setTimeout(function (){
       var jumlah = ($("#jumlah_"+indexRow).val() == "") ? 0 : parseFloat($("#jumlah_"+indexRow).val());
       if(jumlah < 0){
           alert("Jumlah Barang tidak boleh kurang dari 0");
           $("#jumlah_"+indexRow).val(0);
       }
       else{
            var harga = parseFloat($("#harga_"+indexRow).cleanVal());
            var diskon = ($("#diskon_"+indexRow).val() == "") ? 0 : parseFloat($("#diskon_"+indexRow).cleanVal());
            var totalNoDis = jumlah * harga;
            var dis = (diskon == 0) ? 0 : diskon;
            var totwithDis = totalNoDis - dis;
            $("#total_"+indexRow).val(toCurrency(totwithDis));
             setTimeout(function (){
                 getTotalHarga();
             },dly);
       }
        return false;
    },dly);
    
}

function getTotalHarga(){
    var idRow = $('#tabel_barang tr:last').attr('data-id');
    var lastOngkir = parseInt($('#ongkir').cleanVal());
    var lastRows = parseInt($('#jumlah_terbayar').cleanVal());
    var total = 0;
    
    for(var i=1; i <= idRow; i++){
        if($("#barang_"+i).length > 0){
            harga = parseFloat($("#total_"+i).cleanVal());
            total = total + harga;
        }
    }

    $("#total_tagihan").val(toCurrency(total));
    $("#tipe_pembayaran").val("tunai");
    if(lastRows !=null){
        $("#ongkir").val(toCurrency(lastOngkir));
        $("#jumlah_terbayar").val(toCurrency(lastRows));
        $("#sisa_pembayaran").val(toCurrency(total - lastRows));
    } else {
        $("#ongkir").val("0");
        $("#jumlah_terbayar").val("0");
        $("#sisa_pembayaran").val(toCurrency(total));
    }

    
}

function getSisa(){
    var totTagihan = parseFloat($("#total_tagihan").cleanVal());
    var ongkir = parseFloat($("#ongkir").cleanVal());
    var bayar = parseFloat($("#jumlah_terbayar").cleanVal());
    var sisa = (totTagihan + ongkir) - bayar;
    $("#sisa_pembayaran").val(toCurrency(sisa));
}

function loadDataAgen(id) {
    $.ajax({
        url: base_url_tag+'getAgen/'+id
    })
    .done(function( msg ) {
        $("#alamat").val(msg.alamat);
        $("#no_telpon").val(msg.no_telpon);
        $("#id_kelas_harga").val( msg.id_kelas_harga);
        $("#kelas_harga").val( msg.kelas_harga);
        $("#nama_agen").val( msg.nama_agen);
    });
    return false;
}

function transferField(){
    var tipe = $("#cara_pembayaran").val();
    if(tipe == "transfer"){
        $(".transfer").css("display","block");
        $(".transfer_field").attr("required","required");
    }
    else{
        $(".transfer").css("display","none");
        $(".transfer_field").removeAttr("required");
    }
}