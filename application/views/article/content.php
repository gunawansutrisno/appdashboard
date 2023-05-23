<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= $title.' > '.$judul->nama ?></h1>
    <?= $breadcrumbs ?>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
       <?php foreach ($menu as $key => $row){
           $count = $this->article_model->getCek($row->id);
           ?>
           <!-- onclick="loadData('<?php echo $base_url; ?>edit/<?=$d->id?>')" -->
        <a href="<?= BASE_URL('article/detail/');?><?= url_title(strtolower($row->nama)) ;?>" title="<?= $count->sum ;?> data dashboard">
        <!-- <a href="#" onclick="loadData('<?php echo $base_url; ?>/<?=$row->id?>')" title="<?= $count->sum ;?> data dashboard"> -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-<?= $row->bg ;?>">
                <span class="info-box-icon"><i class="glyphicon glyphicon-<?= $judul->icon;?>"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= $row->nama;?></span>
                    <span class="info-box-number"><?= $count->sum ;?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $count->sum ;?>%"></div>
                    </div>
                    <span class="progress-description">
                        <!--1 Input data-->
                    </span>
                </div>
            </div>
        </div>
      </a>

       <?php } ?>
    </div>

</section>
<!-- alert -->
<?php
$alert = $this->session->flashdata("alert_pengguna");
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
