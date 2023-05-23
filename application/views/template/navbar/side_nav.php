<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= ASSETS_URL ?>img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $fullname?></p>
          <a href="#"><span class="glyphicon glyphicon-ok-sign text-lime"></span> <?= $level?> online</a>
        </div>
      </div>
    <ul class="sidebar-menu">
      <li class="header">MAIN MENU</li>
      <?php
      foreach($sidebar_nav as $index  => $val):
      ?>
      <?php if(isset($val['sub_menu']) && ($val['sub_menu']=="")): ?>
      <li id="menu_<?=$index?>"><a href="<?=$val['main_url']?>"><span class="<?=$val['class']?>"></span> <?=$val['desc']?></a></li>
      <?php
      else :
      ?>
      <li class="treeview" id="menu_<?=$index?>">
        <a href="#">
          <span class="<?=$val['class']?>"></span>  <?=$val['desc']?>
        </a>
        <ul class="treeview-menu">
          <?php
            if(isset($submenu_side[$val["sub_menu"]])) :
            $subMenu = $submenu_side[$val["sub_menu"]];
            foreach($subMenu as $indexSub => $row) :
          ?>
          <li id="menu_<?=$indexSub?>"><a href="<?=$val['main_url'].$row["url"]?>"><span class="<?=$row["class"]?>"></span> <?=$row["desc"]?></a></li>
          <?php
        endforeach;
        endif;
        ?>
        </ul>
      </li>
      <?php
      endif; ?>
      <?php
      endforeach;
      ?>
    </ul>
     <!--Sidebar user panel--> 
    <div class="user-panel">
    </div>
  </section>
  <!-- /.sidebar -->
</aside>