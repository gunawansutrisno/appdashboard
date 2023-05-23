    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$title?>
      </h1>
      <?=$breadcrumbs?>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title" id="form-head">Ubah Profile</h3>
                </div>
                <div class="box-body">
                  <form action="<?php echo $base_url; ?>save_profile" method="post" id="formPengguna">
                    <input type="hidden" id="id" name="id" value="<?=$data['id']?>" />
                   <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" value="<?=$data['nama']?>" class="form-control" placeholder="Nama Lengkap" name="fullname" id="fullname" required="required">
                        <p class="help-block">Nama Lengkap Pengguna</p>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" value="<?=$data['username']?>" class="form-control" placeholder="Username" name="username" id="username" required="required">
                        <p class="help-block">Username untuk login</p>
                    </div>
                    <div class="form-group">
                        <label id="pass_label">Password Lama</label>
                        <input type="password" class="form-control" placeholder="Password" name="old_password" id="old_password" >
                        <p class="help-block pass_notif">Kosongkan jika tidak ingin mengubah</p>
                    </div>
                    <div class="form-group">
                        <label id="pass_label">Password Baru</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" >
                        <p class="help-block pass_notif">Kosongkan jika tidak ingin mengubah</p>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password Baru</label>
                        <input type="password" class="form-control" placeholder="Password" name="confirm_password" id="confirm_password" >
                        <p class="help-block pass_notif">Kosongkan jika tidak ingin mengubah</p>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                        <a href="<?php echo BASE_URL('home');?>"><button type="button"  id="batal" class="btn btn-warning btn-flat"><span class="glyphicon glyphicon-backward"></span> Batal </button></a>
                    </div>
                  </form>
                </div><!-- /.box-body -->
              </div>
        </div>
      </div>
    </section><!-- /.content -->
    
    <!-- alert -->
    <?php
      $alert = $this->session->flashdata("alert_pengguna");
      if(isset($alert) && !empty($alert)):
        $message = $alert['message'];
        $status = ucwords($alert['status']);
        $class_status = ($alert['status'] == "success") ? 'success' : 'danger';
        $icon = ($alert['status'] == "success") ? 'check' : 'ban';
    ?>
    <div class="modal modal-<?php echo $class_status ?> fade" id="myModal" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            <h4 class="modal-title"><span class="icon fa fa-<?php echo $icon ?>"></span> <?php echo $status?></h4>
          </div>
          <div class="modal-body">
            <p><?php echo $message ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal">OK</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <?php endif; ?>
