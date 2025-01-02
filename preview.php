<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $documents  = 2;
    $doc_type  = "documents";
    $ismenu = 2;
    $current_menu = "approval_create";
    $get_id = $_GET['no'];
    include_once('_head.php');
    $conDB = new db_conn();
    $mail = $_SESSION['user_mail'];
    $myname = $_SESSION['user_name'];
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
        $createdby = $objResult['createdby'];
        $checkedby = $objResult['checkedby'];
        $remark = $objResult['remark'];
        $approved = $objResult['approved'];
        if ($objResult['date_prepared'] != "") {
            $date_prepared = date("d/m/Y", strtotime($objResult['date_prepared']));
        }
    }
    $strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name` FROM `documents_line`
    LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id`
    LEFT JOIN `documents_line_cont` ON `documents_line`.`id` = `documents_line_cont`.`line_id`
    WHERE md5(`documents_line`.`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 GROUP BY `documents_line`.`id` ORDER BY `documents_line`.`content_id` ASC";
    $objQuery_line = $conDB->sqlQuery($strSQL);

    $sql = "SELECT * FROM `documents_line_cont` WHERE md5(`line_id`) = '$get_id'";
    $result = $conDB->sqlQuery($sql);
    while ($obj = mysqli_fetch_assoc($result)) {
        $line_id = $obj['line_id'];
    }

    $sql1 = "SELECT * FROM `approval` WHERE `role` = 'ISO' LIMIT 1";
    $result1 = $conDB->sqlQuery($sql1);
    while ($obj1 = mysqli_fetch_assoc($result1)) {
        $mail_iso = $obj1['mail'];
        $name_iso = $obj1['name'];
    }

    $sql2 = "SELECT * FROM `approval` WHERE `role` = 'QMR' LIMIT 1";
    $result2 = $conDB->sqlQuery($sql2);
    while ($obj2 = mysqli_fetch_assoc($result2)) {
        $mail_qmr = $obj2['mail'];
        $name_qmr = $obj2['name'];
    }

    $sql3 = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result3 = $conDB->sqlQuery($sql3);
    while ($obj3 = mysqli_fetch_assoc($result3)) {
        $role = $obj3['role'];
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
                        <div class="col-sm-8">
                            <h1><?php echo "Document No. : " . $doc_no; ?></h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <!-- Main content -->
                <div>
                    <!-- menu header -->
                    <button type="button" class="btn btn-app flat" onClick="window.location.href='approval_create.php'" title="<?php echo BTN_DISCARD; ?>">
                        <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                        <?php echo BTN_DISCARD; ?>
                    </button>

                    <!-- <button type="button" class="btn btn-app flat" onClick="window.open('documents_pdf.php?no=<?php echo md5($doc_id); ?>#toolbar=0', '_blank');" title="PDF">
                        <img src="dist/img/icon/pdf.png" width="24"><br>
                        PDF
                    </button> -->

                    <button type="button" class="btn btn-app flat" onclick="window.location.href='view_approve.php?no=<?php echo md5($doc_id); ?>'" title="Preview">
                        <img src="dist/img/icon/preview.png" width="24"><br>
                        Preview
                    </button>
                    <?php if ($role == 'ADMIN' || $role == 'Check') { ?>
                        <button type="button" class="btn btn-app flat"
                            onclick="Approved2('<?php echo md5($doc_id) ?>','<?php echo $approved; ?>','<?php echo $mail_iso; ?>','<?php echo $name_iso; ?>','<?php echo $method_statement; ?>','<?php echo $doc_no; ?>','<?php echo $preparedby; ?>','<?php echo $currentTime; ?>','Create')" title="Approve">
                            <img src="dist/img/icon/approved.svg" width="24"><br>
                            Approve
                        </button>
                    <?php } elseif ($role == 'ADMIN' || $role == 'ISO') { ?>
                        <button type="button" class="btn btn-app flat"
                            onclick="Approved3('<?php echo md5($doc_id) ?>','<?php echo $approved; ?>','<?php echo $mail_qmr; ?>','<?php echo $name_qmr; ?>','<?php echo $method_statement; ?>','<?php echo $doc_no; ?>','<?php echo $preparedby; ?>','<?php echo $currentTime; ?>','Create')" title="Approve">
                            <img src="dist/img/icon/approved.svg" width="24"><br>
                            Approve
                        </button>
                    <?php } elseif ($role == 'ADMIN' || $role == 'QMR') { ?>
                        <button type="button" class="btn btn-app flat" onclick="Approved('<?php echo md5($doc_id); ?>','<?php echo $approved; ?>','<?php echo $doc_no; ?>','<?php echo $currentTime; ?>')" title="Approve">
                            <img src="dist/img/icon/approved.svg" width="24"><br>
                            Approve
                        </button>
                    <?php } ?>
                    <button type="button" class="btn btn-app flat"
                        onclick="Reject('<?php echo md5($doc_id); ?>','<?php echo $myname ?>','<?php echo $createdby ?>','<?php echo $preparedby ?>','<?php echo $method_statement ?>','<?php echo $doc_no ?>','<?php echo $preparedby ?>','<?php echo $currentTime ?>','Create')"
                        title="Reject">
                        <img src="dist/img/icon/error.svg" width="24"><br>
                        Reject
                    </button>
                </div><!-- /menu header -->
                <div class="row" style="padding: 0px 10px;">
                    <!-- General 1 -->
                    <div class="col-md-12">
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
                                    <form method="post" id="documents" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Title <em></em></label>
                                                    <input type="text" class="form-control" name="method_statement" onchange="dataPost('method_statement', this.value)" value="<?php echo htmlentities($method_statement); ?>" <?php echo $mode; ?> disabled />
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
                                                        <input type="text" onchange="dataPost('date_prepared', convertDateFormat(this.value))" value="<?php echo $date_prepared; ?>" <?php echo $mode; ?> class="form-control datetimepicker-input" data-target="#date" disabled>
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
                                                    <input type="text" class="form-control" value="<?php echo $discipline ?>" <?php echo $mode; ?> disabled />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Work <em></em></label>
                                                    <input type="text" class="form-control" value="<?php echo $work ?>" <?php echo $mode; ?> disabled />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Type <em></em></label>
                                                    <input type="text" class="form-control" value="<?php echo $type ?>" <?php echo $mode; ?> disabled />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Prepared By <em></em></label>
                                                    <input type="text" class="form-control" name="preparedby" value="<?php echo $preparedby; ?>" <?php echo $mode; ?> disabled />
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label>Remark <em></em></label>
                                                    <textarea class="form-control" rows="5" name="remark" onchange="dataPost('remark', this.value)" <?php echo $mode; ?> disabled><?php echo htmlentities($remark); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="checkedby">Check By</label>
                                                    <input type="text" class="form-control" name="checkedby" value="<?php echo $checkedby; ?>" <?php echo $mode; ?> disabled />
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
                                <table id="lineItem" class="table table-bordered" style="font-size: 0.8em;">
                                    <thead>
                                        <tr>
                                            <th width="30">No.<br><em></em></th>
                                            <?php if ($mode != "readonly") { ?>
                                                <th width="100">#</th>
                                            <?php } ?>
                                            <th>Description<br><em></em></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        while ($objResult = mysqli_fetch_assoc($objQuery_line)) {
                                        ?>
                                            <tr>
                                                <td align="center">
                                                    <span><?php echo $index; ?></span>
                                                </td>
                                                <?php if ($mode != "readonly") { ?>
                                                    <td align="center">
                                                        <img src="dist/img/icon/search.svg" onclick="window.location.href='reason_reject.php?no=<?php echo md5($objResult['id']); ?>'" title="View" width="40" style="padding-right: 10px;cursor: pointer;" />
                                                    </td>
                                                <?php } ?>
                                                <td>
                                                    <span><?php echo $objResult['name']; ?></span>
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
                                                        <input type="checkbox" class="custom-control-input" id="enable<?php echo $objResult_content['id'] ?>" onChange="switchChange('<?php echo $doc_id; ?>','<?php echo $objResult_content['id']; ?>',this)" value="<?php echo $enable; ?>" <?php if ($enable == "1") {
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        function dataPost(field, value) {
            updateValue('documents', '<?php echo $get_id; ?>', field, value);
        }

        function dataPost2(id, field, value) {
            updateAmount('documents_line', id, field, value);
        }
        <?php if ($mode == "") { ?>
            $('#date').datepicker({
                format: 'dd/mm/yyyy'
            });
            $('#duedate').datepicker({
                format: 'dd/mm/yyyy'
            });
            $('#po_date').datepicker({
                format: 'dd/mm/yyyy'
            });
            $('#shipdate').datepicker({
                format: 'dd/mm/yyyy'
            });
        <?php } ?>
    </script>

</html>