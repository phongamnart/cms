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

        .info-box {
            cursor: pointer;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once('_navbar.php'); ?>
        <?php include_once('_menu.php'); ?>
        <div class="content-wrapper" style="background-image: url('dist/img/bg.png');
        background-repeat: no-repeat;
        background-size: cover;">
            <section class="content">
                <div class="container-fluid">
                    <h1>&nbsp;</h1>
                    <div class="col-sm-8  col-12">
                        <div class="row">
                            <div class="col-sm-4 col-12">
                                <div class="info-box" onclick="window.location.href='documents_list.php?documents_list_discipline=Civil'">
                                    <span class="info-box-icon bg-info " style="padding: 20px; width:100px;"><img src="dist/img/icon/civil.png" width="100" /></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">CIVIL</span>
                                        <?php
                                        $strSQL = "SELECT COUNT(*) as civil FROM `documents` WHERE `approved` = 4 AND `discipline` = 'Civil'";
                                        $objQuery = $conDB->sqlQuery($strSQL);
                                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                            <span class="info-box-number"><?php echo $objResult['civil']?></span>
                                        <?php } ?>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 col-12">
                                <div class="info-box" onclick="window.location.href='documents_list.php?documents_list_discipline=Electrical'">
                                    <span class="info-box-icon bg-info " style="padding: 20px; width:100px;"><img src="dist/img/icon/electrical.png" width="100" /></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">ELECTRICAL</span>
                                        <?php
                                        $strSQL = "SELECT COUNT(*) as electrical FROM `documents` WHERE `approved` = 4 AND `discipline` = 'Electrical'";
                                        $objQuery = $conDB->sqlQuery($strSQL);
                                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                            <span class="info-box-number"><?php echo $objResult['electrical']?></span>
                                        <?php } ?>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 col-12">
                                <div class="info-box" onclick="window.location.href='documents_list.php?documents_list_discipline=Mechanical'">
                                    <span class="info-box-icon bg-info " style="padding: 20px; width:100px;"><img src="dist/img/icon/mechanical.png" width="100" /></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">MECHANICAL</span>
                                        <?php
                                        $strSQL = "SELECT COUNT(*) as mechanical FROM `documents` WHERE `approved` = 4 AND `discipline` = 'Mechanical'";
                                        $objQuery = $conDB->sqlQuery($strSQL);
                                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                            <span class="info-box-number"><?php echo $objResult['mechanical']?></span>
                                        <?php } ?>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 col-12">
                                <div class="info-box" onclick="window.location.href='documents_list.php?documents_list_discipline='" style="cursor: pointer;">
                                    <span class="info-box-icon bg-warning" style="padding: 20px; width:100px;"><img src="dist/img/icon/folder.png" width="100" /></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">ALL</span>
                                        <?php
                                        $strSQL = "SELECT COUNT(*) as all_rows FROM `documents` WHERE `approved` = 4";
                                        $objQuery = $conDB->sqlQuery($strSQL);
                                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                            <span class="info-box-number"><?php echo $objResult['all_rows']?></span>
                                        <?php } ?>
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
        <?php include_once('_footer.php'); ?>
    </div>
    <?php include_once('_script.php'); ?>

</html>