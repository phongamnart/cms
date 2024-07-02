<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $document  = 2;
    $ismenu = 1;
    $condition2 = "";
    $current_menu = "documents_list";
    include_once('_head.php');
    $conDB = new db_conn();
    $documents_list_start_date = isset($_SESSION['documents_list_start_date']) ? $_SESSION['documents_list_start_date'] : '';
    $documents_list_end_date = isset($_SESSION['documents_list_end_date']) ? $_SESSION['documents_list_end_date'] : '';
    $documents_list_discipline = isset($_SESSION['documents_list_discipline']) ? $_SESSION['documents_list_discipline'] : '';
    $documents_list_work = isset($_SESSION['documents_list_work']) ? $_SESSION['documents_list_work'] : '';
    $documents_list_type = isset($_SESSION['documents_list_type']) ? $_SESSION['documents_list_type'] : '';
    if ($documents_list_start_date == "") {
        $documents_list_start_date = date("Y-01-01");
    }
    if ($documents_list_end_date == "") {
        $documents_list_end_date = date('Y-m-d');
    }
    $strSQLDisc = "SELECT DISTINCT `discipline` FROM `documents` WHERE `approved` = 1";
    if ($documents_list_discipline != "") {
        $condition = " AND `discipline` = '" . $documents_list_discipline . "'";
    } else {
        $condition = "";
    }
    $strSQLWork = "SELECT DISTINCT `work` FROM `documents` WHERE `approved` = 1" . $condition;
    if ($documents_list_work != "") {
        $condition2 = " AND `work` = '" . $documents_list_work . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }
    $strSQLType = "SELECT DISTINCT `type` FROM `documents` WHERE `approved` = 1" . $condition2;
    if ($documents_list_type != "") {
        $condition2 .= " AND `type` = '" . $documents_list_type . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }
    echo $strSQL = "SELECT * FROM `documents` WHERE `approved` = 4";
    $objQuery = $conDB->sqlQuery($strSQL);

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
                            <h1>Method Statement List</h1>
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
                                                <select class="custom-select" style="width: 100%;" <?php echo $mode_select; ?> onChange="setFilter('documents_list_discipline',this.value)">
                                                    <option value="">All</option>
                                                    <?php
                                                    $objQueryDisc = $conDB->sqlQuery($strSQLDisc);
                                                    while ($objResultDisc = mysqli_fetch_assoc($objQueryDisc)) {
                                                        if ($objResultDisc['discipline'] == $documents_list_discipline) {
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
                                                <select class="custom-select" style="width: 100%;" <?php echo $mode_select; ?> onChange="setFilter('documents_list_work',this.value)">
                                                    <option value="">All</option>
                                                    <?php
                                                    $objQueryWork = $conDB->sqlQuery($strSQLWork);
                                                    while ($objResultWork = mysqli_fetch_assoc($objQueryWork)) {
                                                        if ($objResultWork['work'] == $documents_list_work) {
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
                                                <select class="custom-select" style="width: 100%;" <?php echo $mode_select; ?> onChange="setFilter('documents_list_type',this.value)">
                                                    <option value="">All</option>
                                                    <?php
                                                    $objQueryType = $conDB->sqlQuery($strSQLType);
                                                    while ($objResultType = mysqli_fetch_assoc($objQueryType)) {
                                                        if ($objResultType['type'] == $documents_list_type) {
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
                                                <th width="30">No.<br><em></em></th>
                                                <th width="60">Tools<br><em></em></th>
                                                <th width="80">Discipline​<br><em></em></th>
                                                <th width="90">Document No.​<br><em></em></th>
                                                <th width="300">Document Title<br><em></em></th>
                                                <th width="80">Date<br><em></em></th>
                                                <th width="150">Prepared By<br><em></em></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 1;
                                            while ($objResult = mysqli_fetch_assoc($objQuery)) {
                                            ?>
                                                <tr onDblClick="window.location.href='documents_list_edit.php?no=<?php echo md5($objResult['id']); ?>'">
                                                    <td><?php echo $index++; ?></td>
                                                    <td align="center">
                                                        <img src="dist/img/icon/download.png" onclick="window.location.href='request_edit.php?no=<?php echo md5($objResult['id']) ?>'" title="Download Pdf" width="30" style="padding: 2px;cursor: pointer;" />&nbsp;
                                                        <img src="dist/img/icon/pdf.png" onclick="window.open('documents_pdf.php?no=<?php echo md5($objResult['id']) ?>', '_blank');" title="Download Pdf" width="30" style="padding: 2px;cursor: pointer;" />
                                                    </td>
                                                    <td><?php echo $objResult['discipline'] ?></td>
                                                    <td><?php echo $objResult['doc_no'] ?></td>
                                                    <td><?php echo $objResult['method_statement'] ?></td>
                                                    <td><?php echo $objResult['date'] ?></td>
                                                    <td><?php echo $objResult['prepared_by'] ?></td>
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