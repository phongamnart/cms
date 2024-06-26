<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php  
$document  = 2;
$ismenu = 0;
$current_menu = "dashboard";
include_once('_head.php'); 
$conDB = new db_conn();
?>
<style>
.bg-warning {
  background-color: #ffc10763 !important;
}
.bg-info {
  background-color: #17a2b83b !important;
}
.info-box{
    cursor: pointer;
}
</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once('_navbar.php');?>
        <?php include_once('_menu.php');?>
        <div class="content-wrapper" style="background-image: url('dist/img/bg.png');
        background-repeat: no-repeat;
        background-size: cover;">
            <section class="content">
                <div class="container-fluid">
                    <h1>&nbsp;</h1>
                    <div class="col-sm-8  col-12">
                    <div class="row">
                        <div class="col-sm-4 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning" style="padding: 20px; width:100px;"><img src="dist/img/icon/folder.png" width="100"/></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">METHOD STATEMENT LIST</span>
                                    <span class="info-box-number">1,410</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info "style="padding: 20px; width:100px;"><img src="dist/img/icon/civil.png" width="100"/></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">CIVIL LIST</span>
                                    <span class="info-box-number">410</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info "style="padding: 20px; width:100px;"><img src="dist/img/icon/electrical.png" width="100"/></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">ELECTRICAL LIST</span>
                                    <span class="info-box-number">13,648</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info "style="padding: 20px; width:100px;"><img src="dist/img/icon/mechanical.png" width="100"/></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">MECHANICAL LIST</span>
                                    <span class="info-box-number">93,139</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    </div>
                </div>
            </section>
        </div>
        <?php  include_once('_footer.php'); ?>
    </div>
    <?php  include_once('_script.php'); ?>

</html>