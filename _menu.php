<?php
$mail = $_SESSION['user_mail'];
$notify_group = 0;
$notify_MS = 0;
$current_time = date('Y-m-d');
$sql_approve_download = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result_approve_download = $conDB->sqlQuery($sql_approve_download);
    while ($obj_approve_download = mysqli_fetch_assoc($result_approve_download)) {
        if ($obj_approve_download['role'] == 'ADMIN' || $obj_approve_download['role'] == 'ISO') {
            $strSQL_approve_download = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents`
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_req` = 1 OR `request`.`status_pdf` = 1";
            $notify_approve_download = $conDB->sqlNumrows($strSQL_approve_download);
            $notify_group += $notify_approve_download;
        } else {
            $strSQL_approve_download = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents`
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_req` = 999 OR `request`.`status_pdf` = 999";
            $notify_approve_download = $conDB->sqlNumrows($strSQL_approve_download);
            $notify_group += $notify_approve_download;
        }
    }

    $sql_approve_rev = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result_approve_rev = $conDB->sqlQuery($sql_approve_rev);
    while ($obj_approve_rev = mysqli_fetch_assoc($result_approve_rev)) {
        if ($obj_approve_rev['role'] == 'ADMIN' || $obj_approve_rev['role'] == 'ISO') {
            $strSQL_approve_rev = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents` 
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_rev` = 1 AND `documents`.`enable` = 1";
            $notify_approve_rev = $conDB->sqlNumrows($strSQL_approve_rev);
            $notify_group += $notify_approve_rev;
        } else {
            $strSQL_approve_rev = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents`
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_rev` = 999 AND `documents`.`enable` = 1";
            $notify_approve_rev = $conDB->sqlNumrows($strSQL_approve_rev);
            $notify_group += $notify_approve_rev;
        }
    }

    $sql_approve_create = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result_approve_create = $conDB->sqlQuery($sql_approve_create);
    while ($obj_approve_create = mysqli_fetch_assoc($result_approve_create)) {
        if ($obj_approve_create['role'] == 'Check') {
            $strSQL_approve_create = "SELECT * FROM `documents` WHERE `approved` = 1 AND `checkedby` = '$mail'";
            $notify_approve_create = $conDB->sqlNumrows($strSQL_approve_create);
            $notify_group += $notify_approve_create;
        } elseif ($obj_approve_create['role'] == 'ISO') {
            $strSQL_approve_create = "SELECT * FROM `documents` WHERE `approved` = 2";
            $notify_approve_create = $conDB->sqlNumrows($strSQL_approve_create);
            $notify_group += $notify_approve_create;
        } elseif ($obj_approve_create['role'] == 'QMR') {
            $strSQL_approve_create = "SELECT * FROM `documents` WHERE `approved` = 3";
            $notify_approve_create = $conDB->sqlNumrows($strSQL_approve_create);
            $notify_group += $notify_approve_create;
        } elseif ($obj_approve_create['role'] == 'ADMIN') {
            $strSQL_approve_create = "SELECT * FROM `documents` WHERE `approved` = 1 OR `approved` = 2 OR `approved` = 3";
            $notify_approve_create = $conDB->sqlNumrows($strSQL_approve_create);
            $notify_group += $notify_approve_create;
        } else {
            $strSQL_approve_create = "SELECT * FROM `documents`  WHERE `approved` = 999";
            $notify_approve_create = $conDB->sqlNumrows($strSQL_approve_create);
            $notify_group += $notify_approve_create;
        }
    }

    $sql_approve_del = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result_approve_del = $conDB->sqlQuery($sql_approve_del);
    while ($obj_approve_del = mysqli_fetch_assoc($result_approve_del)) {
        if ($obj_approve_del['role'] == 'ADMIN' || $obj_approve_del['role'] == 'ISO') {
            $strSQL_approve_del = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents`
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_del` = 1";
            $notify_approve_del = $conDB->sqlNumrows($strSQL_approve_del);
            $notify_group += $notify_approve_del;
        } else {
            $strSQL_approve_del = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents`
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_del` = 999";
            $notify_approve_del = $conDB->sqlNumrows($strSQL_approve_del);
            $notify_group += $notify_approve_del;
        }
    }

    $sql_reject = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result_reject = $conDB->sqlQuery($sql_reject);
    while ($obj_reject = mysqli_fetch_assoc($result_reject)) {
        if ($obj_reject['role'] == 'ADMIN') {
            $strSQL_reject = "SELECT * FROM `documents` WHERE `admin` = 1  AND `enable` = 1 AND `approved` = 5";
            $notify_reject = $conDB->sqlNumrows($strSQL_reject);
            $notify_MS += $notify_reject;
        } else {
            $strSQL_reject = "SELECT * FROM `documents` WHERE `createdby` = '$mail' AND `enable` = 1 AND `approved` = 5";
            $notify_reject = $conDB->sqlNumrows($strSQL_reject);
            $notify_MS += $notify_reject;
        }
    }

    $sql_download = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result_download = $conDB->sqlQuery($sql_download);
    while ($obj_download = mysqli_fetch_assoc($result_download)) {
        if ($obj_download['role'] == 'ADMIN') {
            $strSQL_download = "SELECT `documents`.`enable` AS `enable`, `request`.* FROM `documents` LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no`
            WHERE `request`.`admin` = 1 AND `documents`.`enable` = 1 AND ((`request`.`status_req` = 2 AND `request`.`expire` > '$current_time') OR (`request`.`status_pdf` = 2 AND `request`.`expire_pdf` > '$current_time'))";
            $notify_download = $conDB->sqlNumrows($strSQL_download);
            $notify_MS += $notify_download;
        } else {
            $strSQL_download = "SELECT `documents`.`enable` AS `enable`, `request`.* FROM `documents` LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no`
            WHERE `request`.`createdby` = '$mail' AND `documents`.`enable` = 1 AND ((`request`.`status_req` = 2 AND `request`.`expire` > '$current_time') OR (`request`.`status_pdf` = 2 AND `request`.`expire_pdf` > '$current_time'))";
            $notify_download = $conDB->sqlNumrows($strSQL_download);
            $notify_MS += $notify_download;
        }
    }

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/logo.svg" height="50" style="padding:6px 12px 5px 12px;">
    <span class="brand-text font-weight-light"><img src="dist/img/appname.png" width="160"></span>
  </a>


  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item <?php if($ismenu == 0){ echo "active";}?>">
          <a href="dashboard.php" class="nav-link <?php if($current_menu == "dashboard"){ echo "active";}?>">
          <img src="dist/img/icon/home (1).png" width="30" style="margin-right: 5px;"/>
            <p>Home
            </p>
          </a>
        </li>

        <li class="nav-item <?php if($ismenu == 1){ echo "menu-open";}?>">
          <a href="#" class="nav-link <?php if($current_menu == ""){ echo "active";}?>">
          <img src="dist/img/icon/folder.png" width="30" style="margin-right: 5px;"/>
            <p>Method Statement
              <?php if($notify_MS > 0) { ?>
                <span class="right badge badge-danger"><?php echo $notify_MS ?></span> 
              <?php } else { ?>
                <i class="right fas fa-angle-left"></i>
              <?php } ?>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="documents_list.php" class="nav-link <?php if($current_menu == "documents_list"){ echo "active";}?>">
              <img src="dist/img/icon/checklist.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Document List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="documents.php"
                class="nav-link <?php if($current_menu == "documents"){ echo "active";}?>">
                <img src="dist/img/icon/file.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>My Document<?php if($notify_reject > 0){ echo '<span class="right badge badge-danger">'.$notify_reject.'</span>'; }?></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="myrequest.php"
                class="nav-link <?php if($current_menu == "myrequest"){ echo "active";}?>">
                <img src="dist/img/icon/download.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Download<?php if($notify_download > 0){ echo '<span class="right badge badge-danger">'.$notify_download.'</span>'; }?></p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if($ismenu == 2){ echo "menu-open";}?>">
          <a href="#" class="nav-link <?php if($current_menu == ""){ echo "active";}?>">
          <img src="dist/img/icon/approve_menu.png" width="30" style="margin-right: 5px;"/>
            <p>Approvals
              <i class="right fas fa-angle-left"></i>
              <?php if($notify_group > 0){ echo '<span class="right badge badge-danger">'.$notify_group.'</span>'; }?>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="approval_create.php" class="nav-link <?php if($current_menu == "approval_create"){ echo "active";}?>">
                <img src="dist/img/icon/add.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Document<?php if($notify_approve_create > 0){ echo '<span class="right badge badge-danger">'.$notify_approve_create.'</span>'; }?></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="approval_download.php" class="nav-link <?php if($current_menu == "approval_download"){ echo "active";}?>">
                <img src="dist/img/icon/download.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Download<?php if($notify_approve_download > 0){ echo '<span class="right badge badge-danger">'.$notify_approve_download.'</span>'; }?></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="approval_del.php" class="nav-link <?php if($current_menu == "approval_del"){ echo "active";}?>">
                <img src="dist/img/icon/delete_menu.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Delete<?php if($notify_approve_del > 0){ echo '<span class="right badge badge-danger">'.$notify_approve_del.'</span>'; }?></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="approval_revise.php" class="nav-link <?php if($current_menu == "approval_revise"){ echo "active";}?>">
                <img src="dist/img/icon/pen.png" width="25" style="margin: 5px 10px 5px 5px;"/>
                <p>Revise<?php if($notify_approve_rev > 0){ echo '<span class="right badge badge-danger">'.$notify_approve_rev.'</span>'; }?></p>
              </a>
            </li>
          </ul>
        </li>
        <?php
        $sql= "SELECT * FROM `approval` WHERE `mail` = '$mail'";
        $result= $conDB->sqlQuery($sql);
        ?>
        <?php
        while ($objResult = mysqli_fetch_assoc($result)) {
          $role = $objResult['role'];
        }
        if ($role == "ADMIN" || $role == "ISO") { ?>
          <li class="nav-item <?php if($ismenu == 3){ echo "menu-open";}?>">
          <a href="#" class="nav-link">
          <img src="dist/img/icon/iso-symbol.png" width="30" style="margin-right: 5px;"/>
            <p>
              ISO Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="discipline.php" class="nav-link <?php if($current_menu == "discipline"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>Discipline</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <?php
        if ($role == "ADMIN") { ?>
          <li class="nav-item <?php if($ismenu == 4){ echo "menu-open";}?>">
          <a href="#" class="nav-link">
          <img src="dist/img/icon/configuration.png" width="30" style="margin-right: 5px;"/>
            <p>
              Administrator
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="add_permission.php" class="nav-link <?php if($current_menu == "add_permission"){ echo "active";}?>">
                <img src="dist/img/icon/new-moon.png" width="16" style="margin: 5px 10px 5px 5px;"/>
                <p>Add Permission</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>