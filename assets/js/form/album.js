var base_url_album = global_url+'gallery/album/';


function closeFormCategory() {
    //code
    $('#form-category-album')[0].reset();
    $('#modal-album-edit').modal('hide');
    
}

function addCategory(){
    var categoryName = $('#form_category_name').val();
    if (categoryName=="") {
        //code
        alert("Isi Nama Category Terlebih Dahulu!!!");
    }else{
    $.ajax({
       url : base_url_album+"addCategory/",
       data : $('#form-category-album').serialize(),
       dataType : "html",
       type : "POST",
       success: function msg(res){
            var data = jQuery.parseJSON(res);
            var status = data['status'];
            var message = data['message'];
            if (status==true) {
                //code
                $('#result-category').html("<label class='alert alert-success'>"+message+"</alert>");
                closeFormCategory();
                $('#result-category').html("");
                window.location.reload();
            }else{
                //alert(message);
                $('#result-category').html("<label class='alert alert-danger'>"+message+"</alert>");
            }
       }
  });    
    }
    
}

function getImageByAlbum(id){
    $('.list-category-album').removeClass('active');
    $('#image_cat_'+id).addClass('active');
    $('#cat_id_selected').val(id);
    $('#form_category_list').val(id);
    $('#page').val(1);
    $('#list_album').html("");
    getImageByCategory(id , 1);
}

function addImageByCategory() {
    //code
    var id = $('#cat_id_selected').val();
    var page = $('#page').val();
    getImageByCategory(id , page);
}

function refreshImageByCategory() {
    //code
    var id = $('#cat_id_selected').val();
    var page = $('#page').val();
    getImageByCategory(id , page);
}

function getImageByCategory(idCategory , page) {
    //code
    $.ajax({
       url : base_url_album+"getImageByCategory/",
       data : "id="+idCategory+"&page="+page,
       dataType : "html",
       type : "POST",
       success: function msg(res){
            var data = jQuery.parseJSON(res);
            var status = data['status'];
            var message = data['message'];
            if (status==true) {
                //code
                var htmlRes = data['html'];
                var page_next= data['page_next'];
                $('#list_album').append(htmlRes);
                $('#page').val(page_next);
            }
       }
  });
}

////*Media Image JS Additional For Form*////
var base_url_media = global_url+'media/';
/// Modal Media

Dropzone.options.fileUploadInsert = {
  paramName: "file_upload", // The name that will be used to transfer the file
  maxFilesize: 2, // MB
  accept: function(file, done) {
    if (file.name == "justinbieber.jpg") {
      done("Naha, you don't.");
    }
    else { done(); }
  },
  complete : function(file){
        var _this = this;
        this.removeFile(file);
  },
  success: function(file , response) {
    var data = jQuery.parseJSON(response);
    var html = '<div class="col-xs-2">' +
                    '<a class="thumbnail" href="#" data-toggle="modal" data-id="'+data['id_post']+'" data-target="#mymodal">' +
                        '<img class="img-responsive" src="'+data['link_thumb']+'" alt="">' +
                    '</a>' +
                  '</div>';
    $('#tab_1').removeClass('active');
    $('#tab_2').addClass('active');
    //$('#image-library').append(html);
    $('#page_modal_media').val(1);
    getLatestMedia();
  }
};


$('#modal-media').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var id = button.data('id')
  getLatestMedia();
});

$('#modal-photo-edit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  var id = button.data('id')
  $.ajax({
       url : base_url_album+"getDetailPhoto/",
       type : "POST",
       data : "id="+id,
       type : "post",
       dataType : "html",
       success: function msg(res){
            var data = jQuery.parseJSON(res);
            var modal = $(this);
            $('#form_id_photo').val(data['id_album_photo']);
            $('#form_photo_name').val(data['title_photo']);
            $('#form_photo_desc').val(data['desc_photo']);
            $('#form_photo_status').val(data['status_photo']);
       }
  });
});

$('#modal-video').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) 
  
});

// Insert Media
function insertMedia() {
       //code
       var imageSource = $('#form_url').val();
       var altText = $('#form_alt_text').val();
       var name = $('#form_name').val();
       var caption = $('#form_caption').val();
       if (imageSource=='') {
              //code
              alert("Please Select Image First!!!!")
       }else{
              $.ajax({
                     url : base_url_media+"saveDetailMeta/",
                     type : "POST",
                     data : $('#detail-media').serialize(),
                     dataType : "html",
                     success: function msg(res){
                          var data = jQuery.parseJSON(res);
                          var status = data['status'];
                          insertMediaToAlbum();
                     }
              });       
       }       
}


function insertMediaToAlbum(){
    var id = $('#form_category_list').val();
    
    $.ajax({
        url : base_url_album+"addImageByCategory/",
        type : "POST",
        data : $('#detail-media').serialize(),
        dataType : "html",
        success: function msg(res){
             var data = jQuery.parseJSON(res);
             var status = data['status'];
             var message = data['message'];
             if (status==true) {
                 //code
                 $('#modal-media').modal('hide');
                 getImageByAlbum(id);
             }else{
                 alert(message);
             }
        }
    });      
}

function refreshGallery() {
    //code
    var id = $('#form_category_list').val();
    getImageByAlbum(id);
}


function getLatestMedia(){
    var page = $('#page_modal_media').val();
    $.ajax({
       url : base_url_media+"latestMedia/",
       type : "POST",
       data : "type=post&page="+page,
       dataType : "html",
       success: function msg(res){
            var data = jQuery.parseJSON(res);
            console.log(data);
            var htmlPage = data["html"];
            if (page==1) {
              //code
              $('#image-library').html(htmlPage);
            }else{
              $('#image-library').append(htmlPage);
            }
            //page = parseInt(page + 1);
            var pageNext = data["page_next"];
            $('#page_modal_media').val(pageNext);
       }
    });
}

function getDetailMedia(idMedia){
       $.ajax({
              url : base_url_media+"detailMedia/",
              type : "POST",
              data : "id="+idMedia,
              type : "post",
              dataType : "html",
              success: function msg(res){
                   var data = jQuery.parseJSON(res);
                   console.log(data);
                   $('#form_id_post').val(idMedia);
                   $('#form_url').val(data['form_url']);
                   $('#form_title').val(data['form_title']);
                   $('#form_caption').val(data['form_caption']);
                   $('#form_alt_text').val(data['form_alt_image']);
                   $('#form_desc').val(data['form_description']);
              }
       });
}

function updatePhoto() {
    //code
    
    
    $.ajax({
              url : base_url_album+"updatePhotoAlbum/",
              type : "POST",
              data : $('#form-photo').serialize(),
              dataType : "html",
              success: function msg(res){
                   var data = jQuery.parseJSON(res);
                   console.log(data);
                   var status = data['status'];
                   var message = data['error_stat'];
                   if (status==true) {
                    //code
                    var photo_status = $('#form_photo_status').val();
                    var id_photo = $('#form_id_photo').val();
                    if (photo_status==0) {
                        //code
                        $('#album_img_'+id_photo+" .thumbnail").attr("style" , "border-color:'red';");   
                    }else{
                        $('#album_img_'+id_photo+" .thumbnail").removeAttr("style");   
                    }
                    $('#result-photo').html("<label class='alert alert-success'>"+message+"</alert>");
                    clearFormPhoto();
                    $('#result-photo').html("");
                   }else{
                    $('#result-photo').html("<label class='alert alert-danger'>"+message+"</alert>");
                   }
              }
       });
}

function clearFormPhoto(){
    $('#form-photo')[0].reset();
    $('#modal-photo-edit').modal('hide');
}

function deletePhoto() {
    
    var r = confirm("Apakah Anda Akan Menghapus Image INi ?? ");
    if (r==true) {
        //code
        $.ajax({
              url : base_url_album+"deletePhotoAlbum/",
              type : "POST",
              data : $('#form-photo').serialize(),
              dataType : "html",
              success: function msg(res){
                   var data = jQuery.parseJSON(res);
                   var status = data['status'];
                   var message = data['error_stat'];
                   var id_deleted = data['id_deleted'];
                   if (status==true) {
                    //code
                    $('#result-photo').html("<label class='alert alert-success'>"+message+"</alert>");
                    $('#album_img_'+id_deleted).remove();   
                    clearFormPhoto();
                    $('#result-photo').html("");
                    
                   }else{
                    $('#result-photo').html("<label class='alert alert-danger'>"+message+"</alert>");
                   }
              }
       });
    }
    //code
    
}

function getDetailCategory() {
    //code
    var id = $('#cat_id_selected').val();
    $.ajax({
              url : base_url_album+"getDetailCategory/",
              type : "POST",
              data : "id="+id,
              dataType : "html",
              success: function msg(res){
                   var data = jQuery.parseJSON(res);
                   var status = data['status'];
                   
                   if (status==true) {
                    //code
                    var cat_detail = data['data_cat'];
                    $('#form_id_category').val(cat_detail['id_album_category']);
                    $('#form_category_name').val(cat_detail['name_album_category']);
                    $('#form_category_desc').val(cat_detail['desc_album_category']);
                    $('#form_category_status').val(cat_detail['status_album_category']);
                    $('#modal-album-edit').modal('show');
                   }else{
                    alert("Data Tidak Ada");
                   }
              }
       });
    
}


