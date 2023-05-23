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
                  <h3 class="box-title" id="form-head">Tambah Pengguna Baru</h3>
                </div>
                <div class="box-body">
                  <form action="<?php echo $base_url; ?>save" method="post" id="formPengguna">
                    <input type="hidden" id="id" name="id" value="" />
                   <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" id="nama">
                        <p class="help-block" style="color:red">* Nama Lengkap Pengguna</p>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username">
                        <p class="help-block" style="color:red">* Username Untuk Login</p>
                    </div>
                    <div class="form-group">
                        <label id="pass_label">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" >
                        <p class="help-block pass_notif" style="color:red">* Password Untuk Login</p>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="confirm_password" id="confirm_password" >
                        <p class="help-block pass_notif" style="color:red">* Masukkan Ulang Password</p>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select id="id_level" name="id_level" class="form-control">
                            <option>Select Level</option>
                            <?php $lv = array(); ?>
                            <?php foreach($level as $l):?>
                            <option value="<?=$l->id?>">
                                <?=$l->nama?>
                                <?php $lv[$l->id] = $l->nama?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block"  style="color:red">* Level Pengguna</p>
                    </div>
                    <div class="form-group">
                        <label>Company Code</label>
                        <select id="id_company" name="id_company" class="form-control">
                            <option>Select Company Code</option>
                            <?php $lv = array(); ?>
                            <?php foreach($company as $l):?>
                            <option value="<?=$l->id?>">
                                <?=$l->code?>
                                <?php $lv[$l->id] = $l->code?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block"  style="color:red">* Company Code</p>
                    </div>
                    <div class="box-footer">
                        <button type="reset" class="btn btn-warning btn-flat"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                        <button type="submit" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-save-file"></span> Simpan</button>
                        <a href="<?php echo BASE_URL('pengguna');?>"><button type="button" style="display: none;"  id="batal" class="btn btn-warning btn-flat"><span class="glyphicon glyphicon-backward"></span> Batal </button></a>
                    </div>
                  </form>
                </div><!-- /.box-body -->
              </div>
        </div>
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-header">
                  <h3 class="box-title">Daftar User</h3>
                </div>
                
                <div class="box-body table-responsive ">
                    <table class="table table-hover table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Company Code</th>
                            <th>Aksi</th>
                        </tr>
                        
                        <?php foreach($data as $d):?>
                        <tr>
                            <td><?=$d->nama?></td>
                            <td><?=$d->username?></td>
                            <td><?= $d->jabatan?></td>
                            <td><?= $d->status==0 ? '<span class="label label-warning">Tidak Aktif</span>' : '<span class="label label-success">Aktif</span>'?></td>
                            <td><?= $d->code?></td>
                            <td>
                                <a href="#" onclick="loadData('<?php echo $base_url; ?>edit/<?=$d->id?>')"class="btn btn-warning btn-flat" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="javascript:void(0)" onclick="deleteData(<?= $d->id ;?>)" class="btn btn-danger btn-flat" title="Delete" data-toggle="modal" data-target="#delete-data"><span class="glyphicon glyphicon-trash"></span></a>
                                <?php if($d->status==0){?>
                                    <a href="javascript:void(0)" onclick="updateData(<?= $d->id ;?>)" class="btn btn-success btn-flat" title="Activate" data-toggle="modal" data-target="#update-data"><span class="glyphicon glyphicon-ok"></span></a>
                                  <?php } else {?>
                                    <a href="javascript:void(0)" onclick="updateData(<?= $d->id ;?>)" class="btn btn-danger btn-flat" title="Deactivate" data-toggle="modal" data-target="#update-data"><span class="glyphicon glyphicon-remove"></span></a>
                                 <?php }?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <?=$pagination?>
                </div>
            </div>
        </div>
          <div id="delete-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Konfirmasi</b></h4>
                    </div>
                    <div class="modal-body">
                        <h4><b> Apakah Anda yakin ingin menghapus data Pengguna ini ? </b></h4>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-danger" id="hapus-true-data">Hapus</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                    </div>

                </div>
            </div>
        </div>
        <div id="update-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Konfirmasi</b></h4>
                    </div>
                    <div class="modal-body">
                        <h4><b> Apakah Anda yakin ingin mengkonfirmasi data Pengguna ini ? </b></h4>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-danger" id="update-true-data">Iya</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                    </div>

                </div>
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
