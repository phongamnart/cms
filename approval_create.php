<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $document  = 2;
    $ismenu = 2;
    $current_menu = "approval_create";
    include_once('_head.php');
    $conDB = new db_conn();
    $documents_start_date = isset($_SESSION['documents_start_date']) ? $_SESSION['documents_start_date'] : '';
    $documents_end_date = isset($_SESSION['documents_end_date']) ? $_SESSION['documents_end_date'] : '';
    $documents_discipline = isset($_SESSION['documents_discipline']) ? $_SESSION['documents_discipline'] : '';
    $documents_work = isset($_SESSION['documents_work']) ? $_SESSION['documents_work'] : '';
    $documents_type = isset($_SESSION['documents_type']) ? $_SESSION['documents_type'] : '';
    $preparedby = $_SESSION['user_name'];
    $mail = $_SESSION['user_mail'];
    if ($documents_start_date == "") {
        $documents_start_date = date("Y-01-01");
    }
    if ($documents_end_date == "") {
        $documents_end_date = date('Y-m-d');
    }
    $strSQLDisc = "SELECT DISTINCT `discipline` FROM `documents` WHERE `preparedby` = '$preparedby'";
    if ($documents_discipline != "") {
        $condition = " AND `discipline` = '" . $documents_discipline . "'";
    } else {
        $condition = "";
    }
    $strSQLWork = "SELECT DISTINCT `work` FROM `documents` WHERE `preparedby` = '$preparedby'" . $condition;
    if ($documents_work != "") {
        $condition2 = " AND `work` = '" . $documents_work . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }
    $strSQLType = "SELECT DISTINCT `type` FROM `documents` WHERE `preparedby` = '$preparedby'" . $condition2;
    if ($documents_type != "") {
        $condition2 .= " AND `type` = '" . $documents_type . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }
    $sql = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result = $conDB->sqlQuery($sql);
    while ($obj = mysqli_fetch_assoc($result)) {
        if ($obj['role'] == 'Check') {
            $strSQL = "SELECT * FROM `documents` WHERE `approved` = 1 AND `checkedby` = '$mail'" . $condition;
            $objQuery = $conDB->sqlQuery($strSQL);
        } elseif ($obj['role'] == 'ISO') {
            $strSQL = "SELECT * FROM `documents` WHERE `approved` = 2" . $condition;
            $objQuery = $conDB->sqlQuery($strSQL);
        } elseif ($obj['role'] == 'QMR') {
            $strSQL = "SELECT * FROM `documents` WHERE `approved` = 3" . $condition;
            $objQuery = $conDB->sqlQuery($strSQL);
        } elseif ($obj['role'] == 'ADMIN') {
            $strSQL = "SELECT * FROM `documents` WHERE `approved` = 1 OR `approved` = 2 OR `approved` = 3" . $condition;
            $objQuery = $conDB->sqlQuery($strSQL);
        } else {
            $strSQL = "SELECT * FROM `documents`  WHERE `approved` = 999" . $condition;
            $objQuery = $conDB->sqlQuery($strSQL);
        }
    }

    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once('_navbar.php'); ?>
        <?php include_once('_menu.php'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Approve for create document</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Discipline <em></em></label>
                                                <select class="custom-select" style="width: 100%;" <?php echo $mode_select; ?> onChange="setFilter('documents_discipline',this.value)">
                                                    <option value="">All</option>
                                                    <?php
                                                    $objQueryDisc = $conDB->sqlQuery($strSQLDisc);
                                                    while ($objResultDisc = mysqli_fetch_assoc($objQueryDisc)) {
                                                        if ($objResultDisc['discipline'] == $documents_discipline) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                        echo "<option value=\"" . $objResultDisc['discipline'] . "\" " . $selected . " >" . $objResultDisc['discipline'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Works <em></em></label>
                                                <select class="custom-select" style="width: 100%;" <?php echo $mode_select; ?> onChange="setFilter('documents_work',this.value)">
                                                    <option value="">All</option>
                                                    <?php
                                                    $objQueryWork = $conDB->sqlQuery($strSQLWork);
                                                    while ($objResultWork = mysqli_fetch_assoc($objQueryWork)) {
                                                        if ($objResultWork['work'] == $documents_work) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                        echo "<option value=\"" . $objResultWork['work'] . "\" " . $selected . " >" . $objResultWork['work'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Type <em></em></label>
                                                <select class="custom-select" style="width: 100%;" <?php echo $mode_select; ?> onChange="setFilter('documents_type',this.value)">
                                                    <option value="">All</option>
                                                    <?php
                                                    $objQueryType = $conDB->sqlQuery($strSQLType);
                                                    while ($objResultType = mysqli_fetch_assoc($objQueryType)) {
                                                        if ($objResultType['type'] == $documents_type) {
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                        echo "<option value=\"" . $objResultType['type'] . "\" " . $selected . " >" . $objResultType['type'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="20">No.<br><em></em></th>
                                                <th width="60">Tools<br><em></em></th>
                                                <th width="80">Discipline​<br><em></em></th>
                                                <th width="90">Document No.​<br><em></em></th>
                                                <th width="300">Document Title<br><em></em></th>
                                                <th width="80">Date<br><em></em></th>
                                                <th width="100">Prepared By<br><em></em></th>
                                                <th width="100">Status<br><em></em></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 1;
                                            while ($objResult = mysqli_fetch_assoc($objQuery)) {
                                            ?>
                                                <tr onDblClick="window.open('documents_pdf.php?no=<?php echo md5($objResult['id']); ?>', '_blank');">
                                                    <td><?php echo $index++; ?></td>
                                                    <td align="center">
                                                        <!-- <img src="dist/img/icon/pdf.png" onClick="window.open('documents_pdf.php?no=<?php echo md5($objResult['id']); ?>', '_blank');" title="Preview" width="35" style="padding: 5px;cursor: pointer;" /> -->
                                                        <img src="dist/img/icon/search.svg" style="padding: 5px;cursor: pointer;" width="35" onclick="window.location.href='preview.php?no=<?php echo md5($objResult['id']); ?>'" title="Approve">
                                                    </td>
                                                    <td><?php echo $objResult['discipline'] ?></td>
                                                    <td><?php echo $objResult['doc_no'] ?></td>
                                                    <td><?php echo $objResult['method_statement'] ?></td>
                                                    <td>
                                                        <?php
                                                        $date = $objResult['date'];
                                                        $convertDate = strtotime($date);
                                                        $newDate = date("d-m-Y", $convertDate);
                                                        echo $newDate;
                                                        ?>
                                                    </td>
                                                    <td><?php echo $objResult['preparedby'] ?></td>
                                                    <td>
                                                        <?php if ($objResult['approved'] == 1) { ?>
                                                            Prepared
                                                        <?php } elseif ($objResult['approved'] == 2) { ?>
                                                            Checked
                                                        <?php } elseif ($objResult['approved'] == 3) { ?>
                                                            ISO Review
                                                        <?php } elseif ($objResult['approved'] == 4) { ?>
                                                            Approved
                                                        <?php } else { ?>
                                                            Not Approved
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include_once('_footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php include_once('_script.php'); ?>
    <script>
        setTimeout(function() {
                $('#datatable').DataTable({
                    "stateSave": true,
                    "paging": true,
                    "responsive": true,
                    "lengthChange": true,
                    "searching": true,
                    "autoWidth": true,
                    "ordering": true,
                    "info": true,
                });
            },
            500);
    </script>

</html>