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
    $get_id = $_GET['no'];
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
        $remark = $objResult['remark'];
        $approved = $objResult['approved'];
        $checkedby = $objResult['checkedby'];
        if ($objResult['date_prepared'] != "") {
            $date_prepared = date("d/m/Y", strtotime($objResult['date_prepared']));
        }
    }
    $strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name` FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`content_id` ASC";
    $objQuery_line = $conDB->sqlQuery($strSQL);

    $sql = "SELECT * FROM `documents_line_cont` WHERE md5(`line_id`) = '$get_id'";
    $objQuery_cont = $conDB->sqlQuery($sql);
    while ($objResult = mysqli_fetch_assoc($objQuery_cont)) {
        $line_id = $objResult['line_id'];
    }

    $sql2 = "SELECT * FROM `request` WHERE md5(`id`) = '$get_id'";
    $objQuery_req = $conDB->sqlQuery($sql2);
    while ($objResult = mysqli_fetch_assoc($objQuery_req)) {
        $request = $objResult['request'];
    }

    $sql3 = "SELECT * FROM `approval` WHERE `role` = 'ISO' LIMIT 1";
    $objQuery3 = $conDB->sqlQuery($sql3);
    while ($objResult = mysqli_fetch_assoc($objQuery3)) {
        $approval_name = $objResult['name'];
        $approval_mail = $objResult['mail'];
    }
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
                            <h1><?php echo "Request Delete Document No. : " . $doc_no; ?></h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <!-- Main content -->
                <div>
                    <!-- menu header -->
                    <button type="button" class="btn btn-app flat" onClick="window.location.href='documents.php'" title="<?php echo BTN_DISCARD; ?>">
                        <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                        <?php echo BTN_DISCARD; ?>
                    </button>
                    <button type="button" class="btn btn-app flat"
                        onclick="sendDelete('<?php echo md5($doc_id) ?>','<?php echo $approval_mail ?>','<?php echo $approval_name ?>','<?php echo $method_statement ?>','<?php echo $doc_no ?>','<?php echo $preparedby ?>','<?php echo $date_prepared ?>','Delete')" title="Send Request">
                        <img src="dist/img/icon/forward.png" width="24"><br>
                        Send Request
                    </button>
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
                                                    <input type="text" class="form-control" name="method_statement" onchange="dataPost('method_statement', this.value)" value="<?php echo htmlentities($method_statement); ?>" <?php echo $mode; ?> readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Document No. <em></em></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="doc_no" value="<?php echo $doc_no; ?>" readonly>
                                                        <?php if ($mode != "readonly") { ?>
                                                            <span class="input-group-append">
                                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#noselectModal"><i class="fas fa-search"></i></button>
                                                            </span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Date <em></em></label>
                                                    <div class="input-group date" id="date" data-target-input="nearest">
                                                        <input type="text" onchange="dataPost('date_prepared', convertDateFormat(this.value))" value="<?php echo $date_prepared; ?>" <?php echo $mode; ?> class="form-control datetimepicker-input" data-target="#date" readonly>
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
                                                    <input type="text" class="form-control" name="discipline" value="<?php echo $discipline ?>" <?php echo $mode; ?> />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Work <em></em></label>
                                                    <input type="text" class="form-control" name="work" value="<?php echo $work ?>" <?php echo $mode; ?> />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Type <em></em></label>
                                                    <input type="text" class="form-control" name="type" value="<?php echo $type ?>" <?php echo $mode; ?> />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Prepared By <em></em></label>
                                                    <input type="text" class="form-control" name="preparedby" value="<?php echo $preparedby; ?>" <?php echo $mode; ?> <?php echo $mode; ?> />
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label>Reason<em></em></label>
                                                    <textarea class="form-control" rows="5" name="request" id="request" required></textarea>
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
                    </div>
                </div>
        </div>
        </section>
        <?php include_once('_footer.php'); ?>
    </div>
    <?php include_once('_script.php'); ?>
    <script>
        function checkRequestField() {
            var requestField = document.getElementById('request');
            var sendRequestButton = document.querySelector('button[onclick^="sendDelete"]');

            if (requestField.value.trim() === '') {
                sendRequestButton.disabled = true;
            } else {
                sendRequestButton.disabled = false;
            }
        }

        document.getElementById('request').addEventListener('input', checkRequestField);

        checkRequestField();

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