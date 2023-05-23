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
        <!-- Barang -->
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">List Data </h3>
                     <a href="<?= $base_url;?>add"><button type="button"  class="btn bg-maroon btn-flat margin pull-right"><span class="glyphicon glyphicon-plus"></span> New Article</button>
                    </a>
                        
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped " id="datatable">
                        <thead>
                            <tr>
                                <th>Company Code</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Menu Dashboard</th>
                                <th>SubMenu Dashboard</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>

        </div> 
        <div id="edit-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Notification</b></h4>
                    </div>
                    <div class="modal-body">
                        <h4><b>Are you sure you want to edit this data ? </b></h4>
                    </div>
                    <form action="<?= base_url('surat/edit/'); ?>" method="post">
                        <input type="hidden" name="id" id="id" value="" >
                        <div class="modal-footer ">
                            <button class="btn btn-success btn-flat" type="submit"> Yes</button>
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Delete Data  -->

        <div id="delete-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Notification</b></h4>
                    </div>
                    <div class="modal-body">
                        <h4><b> Are you sure you want to delete this data ? </b></h4>
                    </div>
                    <form action="<?= base_url('surat/delete/'); ?>" method="post">
                        <input type="hidden" name="id" id="ids" value="" >
                        <div class="modal-footer ">
                            <button class="btn btn-success btn-flat" type="submit"> Yes</button>
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="detail-data" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #00a65a;">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title" style="color:white;"><b>Print Preview</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="fetched-data">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="print-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Print Surat</b></h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('surat/Getprintout'); ?>" method="post" id="pasien" target="_blank">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Perusahaan</label>
                                    <select id="kopsurat"  name="kopsurat" class="form-control">
                                    <option value="">-- Pilih Jenis Kop Surat --</option>
                                    <?php foreach ($perusahaan as $b): ?>
                                        <option value="<?= $b->in_bahasa ?>"><?= $b->code . " - " . $b->in_bahasa ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Surat</label>
                                    <select required=""  name="surat" id="surat" class="form-control">
                                        <option value="">-- Pilih Jenis Surat --</option>
                                        <option value="surat masuk">Surat Masuk</option>
                                        <option value="surat Keluar">Surat Keluar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select class="form-control" required="" name="tahun">
                                        <option>--Tahun--</option>
                                        <?php
                                        $date = date('Y');
                                        for ($i = 2017; $i <= $date; $i++) {
                                            ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Urut Surat Pertama</label>
                                    <input type="text" class="form-control" name="kode1" placeholder="" id="noka" required="">
                                    <span id="pesa" style="color:red"> example : 00001</span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Urut Surat Kedua</label>
                                    <input type="text" required="" class="form-control" id="nama" name="kode2" placeholder="">
                                    <span id="pesa" style="color:red"> example : 00002</span>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <div class="modal-footer ">
                                <button class="btn btn-info btn-flat btn-sm" target="_blank" type="submit"><span class="glyphicon glyphicon-print"></span> Print</button>
                                <button type="button" class="btn btn-warning btn-flat btn-sm" data-dismiss="modal"> Batal</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>

                </div>
            </div> -->
        </div>
        <!-- END Modal Ubah -->
    </div>
</section><!-- /.content -->

<!-- alert -->
<?php
$alert = $this->session->flashdata("alert_diagnostik");
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
