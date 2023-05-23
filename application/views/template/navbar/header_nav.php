<header class="main-header">
    <a href="#" class="logo"><img src="<?= ASSETS_URL ?>img/lgo_heads_molindo.svg" width="120" /> </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <?php $data = $this->session->userdata('user_level'); if($data == 1){?>
        <div class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="glyphicon glyphicon-triangle-left"> </span>
            <!--</body>-->
        </div>
        <?php } ?>
        <a href="#" class="sidebar-toggle" >
            <!--<span class="glyphicon glyphicon-time"></span>-->
                <?php
            $day = date('D', strtotime(date('Y-m-d')));
            $dayList = array(
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            );
            ?>
            <?= $dayList[$day]; ?>, <script type='text/javascript'>

    var months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'August', 'Sept', 'Oct', 'Nov', 'Des'];
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth();
    var yy = date.getYear();
    var year = (yy < 1000) ? yy + 1900 : yy;
    document.write(day + " " + months[month] + " " + year);

            </script>   
            <span id="clock"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= ASSETS_URL ?>img/user2-160x160.jpg" class="user-image" alt="User Image"/> 
                        <span class="hidden-xs"><?= $fullname ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: initial;">
                            <img src="<?= ASSETS_URL ?>img/user2-160x160.jpg" class="img-circle" alt="User Image" /> 
                            <p><?= $fullname ?></p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= $link_edit_profil ?>" class="btn btn-default btn-flat">Edit Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= $link_logout ?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>