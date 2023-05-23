<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= $title?></h1>
    <?= $breadcrumbs; ?>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo $base_url; ?>" method="post" id="formTransaksi" class="form-horizontal">
                <!-- Agen -->
                <!--<div class="col-md-12">-->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title" id="form-head">Searching Data</h3>
                                </div>
                                <div class="box-body ">
                                    <div class="form-group">
                                        <label class="control-label form-label col-sm-3">Month</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <select class="form-control  select2" id="bulan" name="bulan" style="width: 200%;">
                                                    <option>-- Select Month --</option>
                                                    <option value="1" <?= $bulan == 1 ? 'selected' : ''; ?>>Januari</option>
                                                    <option value="2" <?= $bulan == 2 ? 'selected' : ''; ?>>Februari</option>
                                                    <option value="3" <?= $bulan == 3 ? 'selected' : ''; ?>>Maret</option>
                                                    <option value="4" <?= $bulan == 4 ? 'selected' : ''; ?>>April</option>
                                                    <option value="5" <?= $bulan == 5 ? 'selected' : ''; ?>>Mei</option>
                                                    <option value="6" <?= $bulan == 6 ? 'selected' : ''; ?>>Juni</option>
                                                    <option value="7" <?= $bulan == 7 ? 'selected' : ''; ?>>Juli</option>
                                                    <option value="8" <?= $bulan == 8 ? 'selected' : ''; ?>>Agustus</option>
                                                    <option value="9" <?= $bulan == 9 ? 'selected' : ''; ?>>September</option>
                                                    <option value="10" <?= $bulan == 10 ? 'selected' : ''; ?>>Oktober</option>
                                                    <option value="11" <?= $bulan == 11 ? 'selected' : ''; ?>>November</option>
                                                    <option value="12" <?= $bulan == 12 ? 'selected' : ''; ?>>Desember</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-1 text-center">
                                            <label class="control-label form-label">Tahun</label>
                                        </div> -->
                                        <label class="control-label form-label col-sm-1">Year</label>
                                        <div class="col-sm-3">
                                            <!--<div class="input-group date">-->
                                            <div class="input-group date">
                                                <select class="form-control " id="tahun" name="tahun" style="width: 220%;">
                                                    <option>--  Select Year --</option>
                                                    <?php for ($i = date('Y'); $i >= date('Y') - 3; $i-=1) { ?>
                                                        <option value="<?= $i; ?>" <?= $tahun == $i ? 'selected' : ''; ?>><?= $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!--</div>-->
                                        </div>

                                    </div>

                                    <div class="box-footer">
                                        
                                        <input type="hidden" name="name" id="url" value="<?= $urisegment ;?>"/>
                                        <button type="submit" id="btnFilter"  class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-search"></span> Searching</button>
                                        <a href="<?= $base_url ;?>"><button type="button" id="btnFilter"  class="btn btn-warning btn-flat"><span class="glyphicon glyphicon-refresh"></span> Refresh</button></a>
                                    </div>
                                </div><!-- /.box-body -->   
                            </div>
                        </div>
                    </div>
                <!--</div>-->  
            </form>
        </div>
        <?php if(!empty($data)){ ?>
        
            <!-- Barang -->
            <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">List Data </h3>
                   
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped " id="datatables">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created date</th>
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
        <?php } ?>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="detail-data" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #00a65a;">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title" style="color:white;"><b>Preview</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="fetched-data">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- alert -->
<?php
$alert = $this->session->flashdata("alert_transaksi");
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
