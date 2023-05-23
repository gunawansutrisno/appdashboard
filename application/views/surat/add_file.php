<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> <?= $title ?> </h1>
    <?= $breadcrumbs ?>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <form action="<?php echo $base_url; ?>/getData" method="post" class="form-horizontal">
            <!-- Agen -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title" id="form-head">Filter</h3>
                            </div>
                            <div class="box-body ">
                                <div class="form-group">
                                    <label class="control-label form-label col-sm-3">Tanggal</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </div>
                                            <input id="date1" class="form-control pull-right" value="<?= $tgl1 ? $tgl1 : 'dd-mm-yyyy';?>" name="date1" id="date1" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <label class="control-label form-label">s.d.</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </div>
                                            <input id="date2" class="form-control pull-left" value="<?= $tgl2 ? $tgl2 : 'dd-mm-yyyy';?>" name="date2" id="date2" type="text">
                                        </div>
                                    </div>
                                </div>                          
                                <div class="box-footer">
                                    <button type="submit" id="btnFilter"  class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-search"></span> Cari</button>
									
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>  
        </form>
        <!-- Barang -->
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">List File Report</h3> <?php if(!empty($data2)){?> 
					 <form action="<?php echo $base_url; ?>/Ekspor" method="post" class="form-horizontal">
					 <button type="submit" id="btnFilter"  class="btn btn-primary btn-flat pull-right"><span class="glyphicon glyphicon-search"></span> Export To Excel</button>
					 <input type="hidden" name="date1" type="text" value="<?= $tgl1 ? $tgl1 : '';?>"/>
					 <input type="hidden" name="date2" type="text" value="<?= $tgl2 ? $tgl2 : '';?>"/>
					<?php }?></form>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>Plant</th>
                                <th>Date</th>
                                <th>Inspection Lot</th>
                                <th>Material Document</th>
                                <th>Material</th>
                                <th>Description</th>
                                <th>TSAI</th>
                                <th>BRIX</th>
                                <th>Density</th>
                                <th>FS</th>
                                <th>From Stor. Loc</th>
                                <th>Deskripsi Stor. Loc</th>
                                <th>Dest Stor. Loc</th>
								 <th>Deskripsi Stor. Loc</th>
                                <th>Tonase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data2)) {foreach ($data2 as $row) { ?>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><?= $row['plant']; ?></td>
                                    <td class="sorting_1"><?= $row['date']; ?></th>
                                    <td class="sorting_1"><?= $row['inspection_lot']; ?></td>
                                    <td class="sorting_1"><?= $row['material_document']; ?></td>
                                    <td class="sorting_1"><?= $row['material']; ?></td>
                                    <td class="sorting_1"><?= $row['description']; ?></td>
                                    <td class="sorting_1"><?= $row['tsai']; ?></td>
                                    <td class="sorting_1"><?= $row['brix']; ?></td>
                                    <td class="sorting_1"><?= $row['density']; ?></td>
                                    <td class="sorting_1"><?= $row['fs']; ?></td>
                                    <td class="sorting_1"><?= $row['f_sloc']; ?></td>                                    
                                    <td class="sorting_1"><?= $row['description_sloc']; ?></td>
                                    <td class="sorting_1"><?= $row['d_sloc']; ?></td>
									
                                    <td class="sorting_1"><?= $row['desc_sloc']; ?></td>
                                    <td class="sorting_1"><?= $row['tonase']; ?></td>
                                </tr>
                            <?php } } else { ?>
                                <tr role="row" class="odd">
                                    <td class="sorting_1" colspan="14">No data available in table</td>                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div> 
    </div>
</section>
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
