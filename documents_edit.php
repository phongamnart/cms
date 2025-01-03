<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $documents  = 0;
    $doc_type  = "documents";
    $ismenu = 1;
    $current_menu = "documents";
    $get_id = isset($_GET['no']) ? $_GET['no'] : '';
    $get_mode = isset($_GET['m']) ? $_GET['m'] : '';
    $type_doc = isset($_GET['l']) ? $_GET['l'] : '';
    include_once('_head.php');
    $conDB = new db_conn();
    $from = $_SESSION['user_name'];
    $strSQL = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $doc_id = $objResult['id'];
        $doc_no = $objResult['doc_no'];
        $discipline = $objResult['discipline'];
        $work = $objResult['work'];
        $type = $objResult['type'];
        $method_statement = $objResult['method_statement'];
        $preparedby = $objResult['preparedby'];
        $checkedby = $objResult['checkedby'];
        $remark = $objResult['remark'];
        $approved = $objResult['approved'];
        if ($objResult['date_prepared'] != "") {
            $date_prepared = date("d/m/Y", strtotime($objResult['date_prepared']));
        }
    }
    $strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`page_no` AS `page_no`
    FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` 
    WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`content_id` ASC";
    $objQuery_line = $conDB->sqlQuery($strSQL);
    $check_content = $conDB->sqlNumrows($strSQL);

    $strSQL2 = "SELECT * FROM `approval` WHERE `mail` = '$checkedby'";
    $objQuery2 = $conDB->sqlQuery($strSQL2);
    while ($objResult = mysqli_fetch_assoc($objQuery2)) {
        $approval_name = $objResult['name'];
    }

    $strSQL3 = "SELECT DISTINCT `type_doc` FROM `documents` WHERE `doc_no` = '$doc_no'";
    $objQuery3 = $conDB->sqlQuery($strSQL3);
    $typeDocs = [];
    while ($objResult = mysqli_fetch_assoc($objQuery3)) {
        $typeDocs[] = $objResult['type_doc'];
    }
    $buttonDisabled = (in_array('en', $typeDocs) && in_array('th', $typeDocs)) ? true : false;

    if (md5($doc_no . '1') == $get_mode) {
        $documents  = 2;
    }

    $currentTime = date("Y-m-d");

    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once('_navbar.php'); ?>
        <?php include_once('_menu.php'); ?>
        <?php
        if ($documents > 1) {
            $mode = "";
            $mode_select = "";
        } else {
            $mode = "readonly";
            $mode_select = "disabled";
        }
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Document No. <?php echo $doc_no ?> : Version. <?php if ($type_doc == "en") { ?>
                                    English
                                <?php } else { ?>
                                    Thai
                                <?php } ?></h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <!-- Main content -->
                <div>
                    <!-- menu header -->
                    <button type="button" class="btn btn-app flat" onclick="window.location.href='documents.php'" title="<?php echo BTN_DISCARD; ?>">
                        <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                        <?php echo BTN_DISCARD; ?>
                    </button>
                    <button type="button" class="btn btn-app flat" onclick="window.location.reload()" title="Refresh">
                        <img src="dist/img/icon/renew.svg" style="padding:3px;" width="24"><br>
                        Refresh
                    </button>
                    <button type="button" class="btn btn-app flat" onclick="window.location.href='view_doc.php?no=<?php echo md5($doc_id) . '&l=' . $type_doc; ?>'" title="Preview">
                        <img src="dist/img/icon/preview.png" width="24"><br>
                        Preview
                    </button>
                    <?php if ($mode != "readonly") { ?>
                        <button type="button" class="btn btn-app flat" onclick="addLanguage('<?php echo $doc_no ?>', '<?php echo $type_doc ?>')" title="Add" style="<?php echo $buttonDisabled ? 'opacity: 0.2; cursor: not-allowed;' : ''; ?>"
                        <?php echo $buttonDisabled ? 'disabled' : ''; ?>>
                            <img src="dist/img/icon/add-button.png" width="24"><br>
                            Add
                        </button>
                        <button type="button" class="btn btn-app flat" onclick="window.open('documents_pdf.php?no=<?php echo md5($doc_id); ?>#toolbar=0', '_blank');" title="PDF">
                            <img src="dist/img/icon/pdf.png" width="24"><br>
                            PDF
                        </button>
                        <button type="button" class="btn btn-app flat" onclick="previewWord('<?php echo md5($doc_id); ?>', 'download.php?no=<?php echo md5($doc_id) ?>')" title="Word">
                            <img src="dist/img/icon/doc.png" width="24"><br>
                            Word
                        </button>
                        <?php
                        $sql_check_all = "SELECT COUNT(*) as `total` FROM `documents_line` WHERE md5(`doc_id`) = '$get_id' AND `enable` = 1";
                        $result_check_all = $conDB->sqlQuery($sql_check_all);
                        while ($objResult_check_all = mysqli_fetch_assoc($result_check_all)) {
                            $total = $objResult_check_all['total'];
                        }

                        $sql_check = "SELECT COUNT(*) as `check` FROM `documents_line` WHERE md5(`doc_id`) = '$get_id' AND `checked` = 1 AND `enable` = 1";
                        $result_check = $conDB->sqlQuery($sql_check);
                        while ($objResult_check = mysqli_fetch_assoc($result_check)) {
                            $check = $objResult_check['check'];
                        }

                        $sql_page = "SELECT COUNT(*) AS `count_page` FROM `documents_line` WHERE md5(`doc_id`) = '$get_id' AND `checked` = 1 AND `enable` = 1 AND (`page_no` IS NULL OR `page_no` = '')";
                        $result_page = $conDB->sqlQuery($sql_page);
                        while ($objResult_page = mysqli_fetch_assoc($result_page)) {
                            $page_no = $objResult_page['count_page'];
                        }
                        ?>
                        <?php if ($total == $check && $page_no == 0) { ?>
                            <button type="button" class="btn btn-app flat" onclick="saveWord('<?php echo md5($doc_id); ?>','<?php echo $checkedby; ?>','<?php echo $approval_name; ?>','<?php echo $method_statement; ?>','<?php echo $doc_no; ?>','<?php echo $preparedby; ?>','<?php echo $currentTime; ?>','Create')" title="Send Approve">
                                <img src="dist/img/icon/send.png" width="24"><br>
                                Send Approve
                            </button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-app flat" data-toggle="modal" data-target="#alertCheck" title="Send Approve">
                                <img src="dist/img/icon/send.png" width="24"><br>
                                Send Approve
                            </button>
                        <?php } ?>
                    <?php } ?>
                </div><!-- /menu header -->
                <div class="row" style="padding: 0px 10px;">
                    <!-- General 1 -->
                    <div class="col-md-12">
                        <div class="d-flex justify-content-start">
                            <span style="font-size: 14px" class="text-danger">***ถ้ากรอกข้อมูลครบแล้ว แต่ไม่สามารถส่งขออนุมัติได้ให้กด Refresh***</span>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Title Head</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-12">
                                    <?php
                                    $strSQL_cancel = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id' AND `comment` IS NOT NULL AND `comment` != '' LIMIT 1";
                                    $objQuery_cancel = $conDB->sqlQuery($strSQL_cancel);
                                    while ($objResult_cancel = mysqli_fetch_assoc($objQuery_cancel)) {
                                        if ($objResult_cancel['created_reject'] != "") {
                                            $created_reject = date("d/m/Y", strtotime($objResult_cancel['created_reject']));
                                        }
                                    ?>
                                        <div class="alert alert-warning alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h5><i class="fa fa-exclamation-circle text-warning"></i> Reject by <?php echo $objResult_cancel['rejectby']; ?> at <?php echo $created_reject ?></h5>
                                            Reason : <?php echo $objResult_cancel['comment']; ?><br>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12">
                                    <form method="post" id="documents" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Title <em></em></label>
                                                    <input type="text" class="form-control" name="method_statement" id="method_statement" onchange="dataPost('method_statement', this.value)" value="<?php echo htmlentities($method_statement); ?>" <?php echo $mode; ?> />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Document No. <em></em></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" value="<?php echo $doc_no; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Date <em></em></label>
                                                    <div class="input-group date" id="date" data-target-input="nearest">
                                                        <input type="text" onchange="dataPost('date_prepared', convertDateFormat(this.value))" value="<?php echo $date_prepared; ?>" <?php echo $mode; ?> class="form-control datetimepicker-input" data-target="#date">
                                                        <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Discipline <em></em></label>
                                                    <input type="text" class="form-control" value="<?php echo $discipline ?>" <?php echo $mode; ?> readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="work">Work</label>
                                                    <select name="work" id="work" class="custom-select" style="width: 100%;" <?php if ($mode == 'readonly') { ?> disabled <?php } ?> onchange="handleChange_work(this)">
                                                        <option value="" <?php if ($work == '') {
                                                                                echo "selected";
                                                                            } ?>>Select</option>
                                                        <?php
                                                        if ($discipline != "") {
                                                            $condition2 = " AND `discipline` = '$discipline'";
                                                        }
                                                        $sql2 = "SELECT DISTINCT `work` FROM `type` WHERE `enable` = 1" . $condition2;
                                                        $objQuery = $conDB->sqlQuery($sql2);

                                                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                                            <option value="<?php echo $objResult['work']; ?>" <?php if ($work == $objResult['work']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>><?php echo $objResult['work']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select name="type" id="type" class="custom-select" style="width: 100%;" <?php if ($mode == 'readonly') { ?> disabled <?php } ?> onchange="handleChange_type(this)">
                                                        <option value="" <?php if ($type == '') {
                                                                                echo "selected";
                                                                            } ?>>Select</option>
                                                        <?php
                                                        if ($work != "") {
                                                            $condition2 = " AND `work` = '$work'";
                                                        }
                                                        $sql2 = "SELECT DISTINCT `type` FROM `type` WHERE `enable` = 1" . $condition2;
                                                        $objQuery = $conDB->sqlQuery($sql2);

                                                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                                            <option value="<?php echo $objResult['type']; ?>" <?php if ($type == $objResult['type']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>><?php echo $objResult['type']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Prepared By <em></em></label>
                                                    <input type="text" class="form-control" name="preparedby" value="<?php echo $preparedby; ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label>Remark <em></em></label>
                                                    <textarea class="form-control" rows="5" name="remark" onchange="dataPost('remark', this.value)" <?php echo $mode; ?>><?php echo htmlentities($remark); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="checkedby">Check By</label>
                                                    <select name="checkedby" id="checkedby" class="custom-select" style="width: 100%;" <?php if ($mode == 'readonly') { ?> disabled <?php } ?> onchange="handleChange(this)">
                                                        <option value="" <?php if ($checkedby == '') {
                                                                                echo "selected";
                                                                            } ?>>Select</option>
                                                        <?php
                                                        if ($discipline == "Civil") {
                                                            $condition3 = " WHERE `system` = 'CE' OR `system` = 'ALL'";
                                                        } elseif ($discipline == "Electrical") {
                                                            $condition3 = " WHERE `system` = 'EE' OR `system` = 'ALL'";
                                                        } elseif ($discipline == "Mechanical") {
                                                            $condition3 = " WHERE `system` = 'ME' OR `system` = 'ALL'";
                                                        }

                                                        $sql2 = "SELECT `mail` FROM `checker`" . $condition3;
                                                        $objQuery = $conDB->sqlQuery($sql2);

                                                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                                            <option value="<?php echo $objResult['mail']; ?>" <?php if ($checkedby == $objResult['mail']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>><?php echo $objResult['mail']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Content</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- .card-body -->
                                <div class="row">
                                    <?php if ($mode != "readonly") { ?>
                                        <button type="button" class="btn btn-app flat" title="Add Contents" data-toggle="modal" data-target="#selectcontents">
                                            <img src="dist/img/icon/list.png" width="20"><br>
                                            Add Contents
                                        </button>
                                        <button type="button" class="btn btn-app flat" title="Reload Contents" onclick="reloadContent(<?php echo $doc_id ?>)">
                                            <img src="dist/img/icon/renew.svg" width="20"><br>
                                            Reload Contents
                                        </button>
                                        <div class="col-md-12">
                                            <span class="text-danger" style="font-size: 14px;"> * กด Reload Contents เพื่อแสดงหัวข้อ</span>
                                        </div>
                                    <?php } ?>
                                </div>

                                <table class="table table-bordered" style="font-size: 0.8em;">
                                    <thead>
                                        <tr>
                                            <th width="80">No.<br><em></em></th>
                                            <th width="100">#</th>
                                            <th width="80">Written</th>
                                            <th width="80">Reject</th>
                                            <th>Content<br><em></em></th>
                                            <th width="100">Page No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        while ($objResult = mysqli_fetch_assoc($objQuery_line)) {
                                            $sql = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "'";
                                            $result = $conDB->sqlQuery($sql);
                                            if ($result->num_rows > 0) {
                                                $sql_update = "UPDATE `documents_line` SET `checked` = 1 WHERE `id` = '" . $objResult['id'] . "'";
                                                $conDB->sqlQuery($sql_update);
                                            }

                                            $sql1 = "SELECT * FROM `documents_line` WHERE `id` = '" . $objResult['id'] . "' AND `comment` IS NOT NULL AND `comment` != '' LIMIT 1";
                                            $result1 = $conDB->sqlQuery($sql1);
                                        ?>
                                            <tr>
                                                <td>
                                                    <span><?php echo $index; ?></span>
                                                </td>
                                                <td align="center">
                                                    <?php if ($mode != "readonly") { ?>
                                                        <img src="dist/img/icon/edit.svg" onclick="window.location.href='documents_line_edit.php?no=<?php echo md5($objResult['id']) . '&l=' . $type_doc . '&m=' . md5($doc_no . '1'); ?>'" title="Edit" width="30" style="padding-right: 10px;cursor: pointer;" />
                                                    <?php } else { ?>
                                                        <img src="dist/img/icon/search.svg" onclick="window.location.href='documents_line_edit.php?no=<?php echo md5($objResult['id']); ?>'" title="View" width="30" style="padding-right: 10px;cursor: pointer;" />
                                                    <?php } ?>

                                                </td>
                                                <td align="center">
                                                    <?php if ($result->num_rows > 0) { ?>
                                                        <img src="dist/img/icon/mark.png" width="25">
                                                    <?php } else { ?>
                                                        <img src="dist/img/icon/mark_gray.png" width="25">
                                                    <?php } ?>
                                                </td>
                                                <td align="center">
                                                    <?php if ($result1->num_rows > 0) { ?>
                                                        <img src="dist/img/icon/warning.svg" width="25">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <span><?php echo $objResult['name']; ?></span>
                                                </td>
                                                <td contenteditable="true" style="text-align: center;" onkeypress="return isNumberKey(event);" onblur="updateValue_reload('documents_line', '<?php echo md5($objResult['id']); ?>', 'page_no', this.innerText);" inputmode="numeric">
                                                    <?php echo $objResult['page_no']; ?>
                                                </td>
                                            </tr>
                                        <?php $index++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <div id="selectcontents" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Contents</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    $index = 1;
                                    $strSQL_content = "SELECT * FROM `contents` WHERE `enable` = 1";
                                    $objQuery_content = $conDB->sqlQuery($strSQL_content);
                                    while ($objResult_content = mysqli_fetch_assoc($objQuery_content)) {
                                        $strSQL = "SELECT * FROM `documents_line` WHERE `doc_id` = '" . $doc_id . "' AND `content_id` = '" . $objResult_content['id'] . "' AND `enable` = 1";
                                        $exist = $conDB->sqlNumrows($strSQL);
                                        if ($exist > 0) {
                                            $enable = "1";
                                        } else {
                                            $enable = "0";
                                        }
                                        $checked = $objResult_content['checked']
                                    ?>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $objResult_content['number'] . ". " . $objResult_content['name']; ?> <em></em></label>
                                                <?php if ($checked == 0) { ?>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="enable<?php echo $objResult_content['id'] ?>" onChange="switchChange('<?php echo $doc_id; ?>','<?php echo $type_doc; ?>','<?php echo $objResult_content['id']; ?>',this)" value="<?php echo $enable; ?>" <?php if ($enable == "1") {
                                                                                                                                                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                                                                                                                                                            } ?> <?php echo $mode; ?> />
                                                        <label class="custom-control-label" for="enable<?php echo $objResult_content['id'] ?>"></label>
                                                    </div>
                                                <?php } else { ?>
                                                    <br><small class="badge badge-success">&nbsp;Required&nbsp;</small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php
                                        $index++;
                                    } ?>
                                    <button class="btn btn-primary" onclick="reloadContent('<?php echo $doc_id ?>', '<?php echo $type_doc ?>')">Select</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="alertCheck" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Warning</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                            $sql_warning = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`checked` AS `checked`
                                        FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id`
                                        WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 AND (`documents_line`.`checked` = 0 OR `documents_line`.`page_no` IS NULL 
                                        OR `documents_line`.`page_no` = '') ORDER BY `documents_line`.`content_id` ASC";
                            $objQuery_warning = $conDB->sqlQuery($sql_warning);
                            ?>

                            <div class="card-body">
                                <div class="col-sm-12">
                                    <em>
                                        <p>คุณกรอกเนื้อหาหรือเลขหน้าสารบัญยังไม่ครบทุกหัวข้อ กรุณากรอกให้ครบก่อนส่งขออนุมัติ</p>
                                    </em>
                                    <?php while ($objResult_warning = mysqli_fetch_assoc($objQuery_warning)) { ?>
                                        <p class="text-danger"><?php echo $objResult_warning['name'] ?></p>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="width: 100px; height: 40px">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div id="pageCheck" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Warning</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php
                            $sql_warning = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`page_no` AS `page_no`
                                        FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id`
                                        WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 AND `documents_line`.`page_no` IS NULL OR `page_no` = '' ORDER BY `documents_line`.`content_id` ASC";
                            $objQuery_warning = $conDB->sqlQuery($sql_warning);
                            ?>

                            <div class="card-body">
                                <div class="col-sm-12">
                                    <em>
                                        <p>คุณกรอกเลขหน้าสารบัญยังไม่ครบ กรุณากรอกให้ครบก่อนส่งขออนุมัติ</p>
                                    </em>
                                    <?php while ($objResult_warning = mysqli_fetch_assoc($objQuery_warning)) { ?>
                                        <p class="text-danger"><?php echo $objResult_warning['name'] ?></p>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="width: 100px; height: 40px">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- /General 1 -->
                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content" style="padding-top: 20px;">
                            <center>
                                <p id="callbackMsg"></p>
                            </center>
                        </div>
                    </div>
                </div>
        </div>
        </section>
        <?php include_once('_footer.php'); ?>
    </div>
    <?php include_once('_script.php'); ?>
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function handleChange_check(selectElement) {
            var value = selectElement.value;
            dataPost('checkedby', value);
            setFilter('checkedby', value);
        }

        function handleChange_work(selectElement) {
            var value = selectElement.value;
            dataPost('work', value);
            setFilter('work', value);
        }

        function handleChange_type(selectElement) {
            var value = selectElement.value;
            dataPost('type', value);
            setFilter('type', value);
        }

        function dataPost(field, value) {
            updateValue('documents', '<?php echo $get_id; ?>', field, value);
        }

        <?php if ($mode == "") { ?>
            $('#date').datepicker({
                format: 'dd/mm/yyyy'
            });
        <?php } ?>

        <?php if ($check_content == 0) { ?>
            // A $( document ).ready() block.
            $(document).ready(function() {
                $("#selectcontents").modal('show');
                console.log("ready!");

            });

        <?php } ?>
    </script>

</html>