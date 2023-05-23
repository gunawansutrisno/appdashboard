<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= $title ?>
    </h1>
    <?= $breadcrumbs ?>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $title ;?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="<?php echo $base_url; ?>save" method="post" id="formAgenr" enctype="multipart/form-data" method="post">
                    <div class="box-body">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                 <input type="hidden" name="id" value="<?= (isset($data->id)) ? $data->id :'' ;?>"/>
                                 <input type="text" placeholder="Title Article" class="form-control pull-right" name="title" value="<?= (isset($data->judul)) ? $data->judul : ''; ?>" id="nama_pasien">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Status</label>
                                    <select required=""  name="status" id="status" class="form-control select2">
                                        <option value="">-- Select Status Type --</option>
                                        <option value="1" <?= (isset($data->status)) ? $data->status == 1 ? 'selected' : '' :'' ;?>> Published    </option>
                                        <option value="0" <?= (isset($data->status)) ? $data->status == 0 ? 'selected' : '' :''; ?>> Unpublished  </option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Company Code </label>
                                    <select   name="plant" id="plant" class="form-control select2">
                                    <option value="0">-- Select Company Code --</option>
                                        <?php foreach ($company as $row){ ?>
                                        <option value="<?= $row->id;?>" <?= (isset($data->plant)) ? $data->plant == $row->id ? 'selected' : '' : ''; ?>> <?= strtoupper($row->code) ?>  </option>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category</label>
                                    <select required=""  name="kategori" id="kategori" class="form-control select2">
                                        <option value="0">-- Select Category Type --</option>
                                        <?php foreach ($kategori as $row){ ?>
                                        <option value="<?= $row->id;?>" <?= (isset($data->menu_id)) ? $data->menu_id == $row->id ? 'selected' : '' : ''; ?>> <?= strtoupper($row->nama) ?>  </option>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sub Category </label>
                                    <select   name="subkategori" id="subkategori" class="form-control select2">
                                        <?php if(!empty($data->submenu_id)){ ?>
                                            <option value=""><?= $data->submenu ;?></option>
                                        <?php }else { ?>
                                            <option value="">-- Select Sub Category Type --</option>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Upload File </label>
                                <input type="file" name="file">
                                        <?= (isset($data->file)) ? $data->file : '';?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Bulan</label>
                                <select class="form-control select2" name="bulan" style="width: 100%;">
                                        <option>Pilih Bulan</option>
                                        <option value="1" <?= (isset($data->bulan)) ? $data->bulan == 1 ? 'selected' : '' :'' ;?>>Januari</option>
                                        <option value="2" <?= (isset($data->bulan)) ? $data->bulan == 2 ? 'selected' : '' :'' ;?>>Februari</option>
                                        <option value="3" <?= (isset($data->bulan)) ? $data->bulan == 3 ? 'selected' : '' :'' ;?>>Maret</option>
                                        <option value="4" <?= (isset($data->bulan)) ? $data->bulan == 4 ? 'selected' : '' :'' ;?>>April</option>
                                        <option value="5" <?= (isset($data->bulan)) ? $data->bulan == 5 ? 'selected' : '' :'' ;?>>Mei</option>
                                        <option value="6" <?= (isset($data->bulan)) ? $data->bulan == 6 ? 'selected' : '' :'' ;?>>Juni</option>
                                        <option value="7" <?= (isset($data->bulan)) ? $data->bulan == 7 ? 'selected' : '' :'' ;?>>Juli</option>
                                        <option value="8" <?= (isset($data->bulan)) ? $data->bulan == 8 ? 'selected' : '' :'' ;?>>Agustus</option>
                                        <option value="9" <?= (isset($data->bulan)) ? $data->bulan == 9 ? 'selected' : '' :'' ;?>>September</option>
                                        <option value="10" <?= (isset($data->bulan)) ? $data->bulan == 10 ? 'selected' : '' :'' ;?>>Oktober</option>
                                        <option value="11" <?= (isset($data->bulan)) ? $data->bulan == 11 ? 'selected' : '' :'' ;?>>November</option>
                                        <option value="12" <?= (isset($data->bulan)) ? $data->bulan == 12 ? 'selected' : '' :'' ;?>>Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tahun</label>
                                <select class="form-control select2" required="" name="tahun">
                                        <option>--Tahun--</option>
                                        <?php
                                        $date = date('Y');
                                        for ($i = 2017; $i <= $date; $i++) {
                                            ?>
                                            <option value="<?= $i; ?>" <?= (isset($data->tahun)) ? $data->tahun == $i ? 'selected' : '' :'' ;?>><?= $i; ?></option>
<?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Deskripsi </label>
                                    <textarea id="editor1" rows="10" cols="80" name="deskripsi" rows="3" placeholder="isi Deskripsi ..." required><?= (isset($data->deskripsi)) ? $data->deskripsi : '';?></textarea>
                             
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="clearfix"></div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-save-file"></span> Simpan</button> 
                      <input type="reset"  class="btn bg-orange btn-flat">
                        <a href="<?php echo BASE_URL('manage');?>"><button type="button"  id="batal" class="btn btn-warning btn-flat"><span class="glyphicon glyphicon-backward"></span> Batal </button></a>
                     </div>
                </form>
            </div>
            <!-- /.box -->

        </div>
    </div>
</section><!-- /.content -->

<!-- alert -->
<?php
$alert = $this->session->flashdata("alert_kwintansi");
if (isset($alert) && !empty($alert)):
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
                    <h4 class="modal-title"><span class="icon fa fa-<?php echo $icon ?>"></span> <?php echo $status ?></h4>
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
