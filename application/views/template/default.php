<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?=$meta_title?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?=ASSETS_URL?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    
    <link href="<?=ASSETS_URL?>dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?= ASSETS_URL ?>img/favicon.png" rel="shortcut icon" type="image/x-icon" width="16" height="16" />
    <link href="<?=ASSETS_URL?>dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css" />
    <link href="<?=ASSETS_URL?>custom/css/global.css" rel="stylesheet" type="text/css" />
    <link href="<?=ASSETS_URL?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
   
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>-->
    <!-- new post -->
    <!-- date and time picker -->
    <!-- Bootstrap datetime Picker -->
    <script>
      var global_url = '<?=$base_url_admin;?>';
      function cetak()
      {
      window.print()
    }
    
    //Initialize Select2 Elements
  
    </script>
    <?php
      echo $custom_css;
    ?>
  </head>
   <?php $data = $this->session->userdata('user_level');?>
  <body class="skin-green fixed <?= $data == 1 ? '' : 'sidebar-collapse'  ;?>">
    <div class="wrapper">
    <?=$head_navbar?>
         
    <?php if($data == 1 ){?>
        <?=$side_navbar?>
    <?php } ?>
      <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?=$main_content?>
  </div><!-- /.content-wrapper -->
  <?=$main_footer?>
    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.3 -->
<script src="<?=ASSETS_URL?>plugins/jQuery/jquery-1.11.3.min.js"></script>

<!-- Bootstrap 3.3.2 JS -->
<script src="<?=ASSETS_URL?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="<?=ASSETS_URL?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?=ASSETS_URL?>plugins/fastclick/fastclick.min.js'></script>
<script src='<?=ASSETS_URL?>plugins/datatables/jquery.dataTables.min.js'></script>
<script src='<?=ASSETS_URL?>plugins/datatables/dataTables.bootstrap.min.js'></script>
<script src="<?=ASSETS_JS_URL?>global.js"></script><!-- Input Mask -->
<script src='<?=ASSETS_URL?>plugins/mask/jquery.mask.min.js'></script>

<!-- AdminLTE App -->
<script src="<?=ASSETS_URL?>dist/js/app.min.js" type="text/javascript"></script>
<?=$custom_js?>
<script type="text/javascript">
<!--
function showTime() {
    var a_p = "";
    var a = "";
    var today = new Date();
    var curr_hour = today.getHours();
  //  alert(curr_hour);
    var curr_minute = today.getMinutes();
    var curr_second = today.getSeconds();
    if (curr_hour < 12) {
        a_p = "AM";
    } else {
        a_p = "PM";
    }
    if (curr_hour == 0) {
        curr_hour = 12;
    }
    if (curr_hour > 12) {
        curr_hour = curr_hour;
    }
    if((curr_hour >= 6) && (curr_hour <= 11)){
        a = "Selamat Pagi !!";
    } else if((curr_hour >= 11) && (curr_hour <= 14)){
        a = "Selamat Siang !!";
    }  else if (curr_hour == 16){
        a =" Saatnya Pulang !!"
    }
    else if ((curr_hour >= 15) && (curr_hour <= 18)){
        a = "Selamat Sore !!";
    } else {
        a = "Selamat Malam !!"
    }
  
    curr_hour = checkTime(curr_hour);
    
    curr_minute = checkTime(curr_minute);
    curr_second = checkTime(curr_second);
// document.getElementById('clock').innerHTML=curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p + ", " + a;
 document.getElementById('clock').innerHTML=curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p ;
    }

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
setInterval(showTime, 500);
//-->
</script>
  </body>
</html>
