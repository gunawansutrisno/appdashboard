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
                  <h3 class="box-title" id="form-head">Tambah Level</h3>
                </div>
                <div class="box-body">
                  <form action="<?php echo $base_url; ?>save" method="post" id="formLevel">
                    <input type="hidden" id="id" name="id" value="" />
                   <div class="form-group">
                        <label>Nama Level</label>
                        <input type="text" class="form-control" placeholder="Nama Level" name="nama" id="nama" required="required">
                        <!--<p class="help-block">Nama Level</p>-->
                    </div>
<!--                    <div class="form-group">
                        <label>Hak Akses ke Menu :</label>
                    </div>-->
                    <?php // foreach ($menu_list as $m):?>
<!--                    <div class="checkbox" style="margin:10px 0px 20px 5px;">
                        <label>
                            <input type="checkbox" class="allowed_menu_list" name="allowed_menu[]" id="<?=$m['init']?>" value="<?=$m['init']?>" <?php echo (in_array($m['init'], $menu_default)) ? '' : '' ?>>
                          <?=$m['name']?>
                        </label>
                    </div>-->
                    <?php // if($m['init'] == "LGN"){ break; }?>
                    <?php // endforeach;?>
                    
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                          <a href="<?php echo BASE_URL('level');?>"><button type="button"  id="batal" class="btn btn-warning btn-flat"><span class="glyphicon glyphicon-backward"></span> Batal </button></a>
                    </div>
                  </form>
                </div><!-- /.box-body -->
              </div>
        </div>
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-header">
                  <h3 class="box-title">Daftar Level</h3>
                </div>
                
                <div class="box-body table-responsive ">
                    <table class="table table-hover table-striped" id="datatable">
                        <tr>
                            <th>No</th>
                            <th>Nama Level</th>
                            <th>Action</th>
                        </tr>
                        <?php $no=0;foreach($data as $d):$no++;?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$d->nama?></td>
                            <td><a href="#" onclick="loadData('<?php echo $base_url; ?>edit/<?=$d->id?>')" class="btn btn-warning btn-flat" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a href="javascript:void(0)" onclick="deleteData('<?=$d->id?>')" class="btn btn-danger btn-flat" title="Delete"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                        <?php endforeach ?>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <?=$pagination?>
                </div>
            </div>
        </div>
      </div>
    </section><!-- /.content -->
    
    <!-- alert -->
    <?php
      $alert = $this->session->flashdata("alert_level");
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
