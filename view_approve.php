<?php
include("_check_session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once('_head.php');
    $conDB = new db_conn();

    $ismenu = 2;
    $current_menu = "approval_create";
    $index = 0;
    $get_id = isset($_GET['no']) ? $_GET['no'] : '';

    $strSQL = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $doc_id = $objResult['id'];
        $method_statement = $objResult['method_statement'];
        $doc_no = $objResult['doc_no'];
    }

    $strSQL1 = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`page_no` FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`content_id` ASC";
    $objQuery1 = $conDB->sqlQuery($strSQL1);

    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once('_navbar.php'); ?>
        <?php include_once('_menu.php'); ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo "Document No. : " . $doc_no; ?></h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <!-- Main content -->
                <div>
                    <!-- menu header -->
                    <button type="button" class="btn btn-app flat" onclick="window.location.href='preview.php?no=<?php echo md5($doc_id); ?>'" title="<?php echo BTN_DISCARD; ?>">
                        <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                        <?php echo BTN_DISCARD; ?>
                    </button>

                    <button type="button" class="btn btn-app flat" onclick="window.location.reload()" title="Refresh">
                        <img src="dist/img/icon/renew.svg" style="padding:3px;" width="24"><br>
                        Refresh
                    </button>
                </div><!-- /menu header -->
                <div class="row" style="padding: 0px 10px;">
                    <!-- General 1 -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Preview</h3>
                            </div>
                            <div class="card-body row" style="position: relative; overflow: hidden;">
                                <!-- ลายน้ำ -->
                                <div style="
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    z-index: 9999;
                                    pointer-events: none;
                                    display: flex;
                                    flex-direction: column; /* วางข้อความเรียงกันเป็นแนวตั้ง */
                                    justify-content: center;
                                    align-items: center;
                                    opacity: 0.1;
                                    font-size: 36px;
                                    color: #000;
                                    overflow: hidden;
                                    white-space: nowrap;">
                                    <!-- ลูปข้อความลายน้ำ -->
                                    <?php for ($i = 0; $i < 100; $i++) { ?>
                                        <div style="margin: 100px; transform: rotate(-30deg);"><?php echo $doc_no ?> : <?php echo $method_statement ?></div>
                                    <?php } ?>
                                </div>


                                <!-- เนื้อหา -->
                                <div style="position: relative; z-index: 1; width: 100%;">
                                    <?php while ($objResult = mysqli_fetch_assoc($objQuery1)) {
                                        $index++;
                                        $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "' AND `doc_id` = '$doc_id' ORDER BY `index_num` ASC";
                                        $objQuery_line = $conDB->sqlQuery($strSQL2);
                                    ?>
                                        <div class="col-md-12" style="font-size: 16px;">
                                            <b><?php echo $index ?>. <?php echo $objResult['name'] ?></b><br>
                                            <?php while ($objResult_content = mysqli_fetch_assoc($objQuery_line)) {
                                                if ($objResult_content['is_image'] == 0) { ?>
                                                    <p><?php echo $objResult_content['content'] ?></p>
                                                <?php } elseif ($objResult_content['is_image'] == 1) { ?>
                                                    <?php $imagePath =  substr($objResult_content['content'], 3); ?>
                                                    <div style="text-align: center;">
                                                        <img src="<?php echo $imagePath; ?>" alt="Image" style="height:300px;">
                                                    </div>
                                                <?php } elseif ($objResult_content['is_image'] == 2) { ?>
                                                    <?php $imagePath =  substr($objResult_content['content'], 3); ?>
                                                    <div style="text-align: center;">
                                                        <img src="<?php echo $imagePath; ?>" alt="Image" style="height:800px;">
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include_once('_footer.php'); ?>
    </div>
    <?php include_once('_script.php'); ?>

</body>

</html>