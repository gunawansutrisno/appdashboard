
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>&nbsp;</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=ASSETS_URL?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=ASSETS_URL?>bootstrap/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=ASSETS_URL?>bootstrap/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=ASSETS_URL?>dist/css/AdminLTE.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header text-center text-uppercase">
           <?=$data['kop_surat']  ;?><br>
           <?=$data['jenis_surat']  ;?><br>
           <small class="text-center"> <?= $data['isi_kop_surat'];?></small>
            <small class="pull-left"> Tanggal Cetak : <?= date('d-m-Y');?></small>
         <small class="pull-right">Jam : <?= date('H:i:s');?></small> 
          </h2>
        
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-12 invoice-col">
            <table style="width:100%">
                <tr>
                    <td>TGL </td>
                    <td> :</td>
                    <td><?= date('d-m-Y', strtotime($data['tgl']));?></td>
                </tr>
                <tr>
                    <td>Ind</td>
                    <td> :</td>
                    <td><?= $data['index_id'];?></td>
                </tr>
                <tr>
                    <td>Nomor </td>
                    <td> :</td>
                    <td><?= $data['nomor'];?></td>
                </tr>
                <tr>
                    <td>Dari </td>
                    <td> :</td>
                    <td><?= $data['dari'];?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?= $data['dari1'] ? $data['dari1'] : '';?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?= $data['dari2'] ? $data['dari2'] : '';?></td>
                </tr>
                
            </table>
        </div>
         <div class="col-sm-5 invoice-col pull-right">
             <table style="width:100%">
                <tr>
                    <td >Tanggal </td>
                    <td> :</td>
                    <td><?= date('d-m-Y', strtotime($data['tgl']));?></td>
                </tr>
                <tr>
                    <td>No.Urut </td>
                    <td> :</td>
                    <td><?= $data['no'];?></td>
                </tr>
                <tr>
                    <td>Kode </td>
                    <td> :</td>
                    <td><?= $data['kode'];?></td>
                </tr>
                <tr>
                    <td>Kepada </td>
                    <td> :</td>
                    <td><?= $data['kepada'] ? $data['kepada'] : '';?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?= $data['kepada1'] ? $data['kepada1'] : '';?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?= $data['kepada2'] ? $data['kepada1'] : '';?></td>
                </tr>
                
            </table>
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>ISI RINGKASAN</th>
          </tr>
          </thead>
          <tbody>
          <tr>
           <td><?= $data['isi'];?></td>
          </tr>
          <tr>
              <td>&nbsp;</td>
          </tr>
          </tbody>
        </table>
      </div>
      </div>
        <hr>
    <div class="row">
<!--        <div class="col-xs-6">
            <address>
                Pengelola : <br>
                <p><br>
                <p>
                 (<?= $data['nama'] ;?>)
             </address>
        </div>-->
        <div class="col-xs-6 pull-right">
            <table style="width:100%">
                <tr>
                    <td>Pengelola :</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>Menyetujui</td>
                </tr>
                <tr>
                    
                    <td colspan="3"> &nbsp;</td>
                </tr>
                <tr>
                    <td>(<?= $data['nama'];?>)</td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>(Yolha)</td>
                </tr>
                
            </table>
<!--            <address class="pull-right">
                Paraf : <br>
                <p> <br>
                <p>
                    (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
         </address>-->
        </div>
      </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
