<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MOLINDO INCORPORATED | Log In</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?= ASSETS_URL ?>img/favicon.png" rel="shortcut icon" type="image/x-icon" width="16" height="16" />
        <link href="<?= ASSETS_URL ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= ASSETS_URL ?>dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .login-page {
            /*background: url("<?= ASSETS_URL ?>img/molindo.jpg") no-repeat center center fixed;*/
            background-size: cover;	
            }
            body {
  overflow: hidden;
}


/* Preloader */

#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #fff;
  /* change if the mask should have another color then white */
  z-index: 99;
  /* makes sure it stays on top */
}

#status {
  width: 200px;
  height: 200px;
  position: absolute;
  left: 50%;
  /* centers the loading animation horizontally one the screen */
  top: 50%;
  /* centers the loading animation vertically one the screen */
  background-image: url(https://raw.githubusercontent.com/niklausgerber/PreLoadMe/master/img/status.gif);
  /* path to your loading animation */
  background-repeat: no-repeat;
  background-position: center;
  margin: -100px 0 0 -100px;
  /* is width and height divided by two */
}
        </style>
    </head>
    <body class="hold-transition login-page">
        <div id="preloader">
  <div id="status">&nbsp;</div>
</div>
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b class="text-danger">LOGIN SISTEM</b></a>
               
            </div>
            <div class="login-box-body">
			<div class="text-center" style="padding: 0 0 10px;">
                            Sign in to start your session
                    <!--<img src="<?= ASSETS_URL ?>img/logo-heads_mri.svg" width="100" />-->
                </div>
                <form action="#" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="email" placeholder="Username "/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">  
                            <button type="submit" name="submit" class="btn btn-success btn-block btn-flat pull-right"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> &nbsp;&nbsp;Sign In</button>
                        </div>
                    </div>
                </form>
                <div class="social-auth-links text-center">
                    <p>- OR -</p>                    
                </div>
                <a href="<?= BASE_URL; ?>forgot/">I forgot my password</a>
            </div>
            <div class="login-logo">
               <h5>Report Dashboard PT. Molindo Raya Industrial </br>Version 2.0.3</h5>
            </div>
             
        </div>
        <?php
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
                            <button type="submit" class="btn btn-outline" data-dismiss="modal">OK</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        <?php endif; ?>

        <!-- jQuery 2.1.3 -->
        <script src="<?= ASSETS_URL ?>plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?= ASSETS_URL ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= ASSETS_URL ?>js/form/login.js"></script>
    </body>
</html>