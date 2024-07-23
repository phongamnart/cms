<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $document  = 2;
    $ismenu = 2;
    $current_menu = "approval_del";
    include_once('_head.php');
    $conDB = new db_conn();

    $approve_req_discipline = isset($_SESSION['approve_req_discipline']) ? $_SESSION['approve_req_discipline'] : '';
    $approve_req_work = isset($_SESSION['approve_req_work']) ? $_SESSION['approve_req_work'] : '';
    $approve_req_type = isset($_SESSION['approve_req_type']) ? $_SESSION['approve_req_type'] : '';
    $prepared_by = $_SESSION['user_name'];
    $mail = $_SESSION['user_mail'];

    if ($approve_req_discipline != "") {
        $condition = " AND `discipline` = '" . $approve_req_discipline . "'";
    } else {
        $condition = "";
    }
    if ($approve_req_work != "") {
        $condition = " AND `work` = '" . $approve_req_work . "'";
        $condition .= $condition;
    } else {
        $condition .= "";
    }
    if ($approve_req_type != "") {
        $condition .= " AND `type` = '" . $approve_req_type . "'";
        $condition .= $condition;
    } else {
        $condition .= "";
    }

    $sql = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result = $conDB->sqlQuery($sql);
    while ($obj = mysqli_fetch_assoc($result)) {
        if ($obj['role'] == 'ADMIN' || $obj['role'] == 'ISO') {
            $strSQL = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents`
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_del` = 1" . $condition;
            $objQuery = $conDB->sqlQuery($strSQL);
        } else {
            $strSQL = "SELECT `documents`.*, `request`.*, `documents`.`id` AS `id`, `request`.`id` AS `reqID` FROM `documents`
            LEFT JOIN `request` ON `documents`.`doc_no` = `request`.`doc_no` WHERE `request`.`status_del` = 999" . $condition;
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
                            <h1>Approve for delete document</h1>
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
                                                <select class="custom-select" onchange="setFilter('approve_req_discipline',this.value)">
                                                    <option value="" <?php if ($approve_req_discipline == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    $sql2 = "SELECT DISTINCT `discipline` FROM `documents` WHERE `approved` = 4";
                                                    $objQueryDisc = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryDisc)) { ?>
                                                        <option value="<?php echo $objResult['discipline']; ?>" <?php if ($approve_req_discipline == $objResult['discipline']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>>
                                                            <?php echo $objResult['discipline']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Works <em></em></label>
                                                <select class="custom-select" onchange="setFilter('approve_req_work',this.value)">
                                                    <option value="" <?php if ($approve_req_work == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($approve_req_discipline != "") {
                                                        $condition2 = " AND `discipline` = '$approve_req_discipline'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `work` FROM `documents` WHERE `approved` = 4" . $condition2;
                                                    $objQueryWork = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryWork)) { ?>
                                                        <option value="<?php echo $objResult['work']; ?>" <?php if ($approve_req_work == $objResult['work']) {
                                                                                                                echo "selected";
                                                                                                            } ?>>
                                                            <?php echo $objResult['work']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Type <em></em></label>
                                                <select class="custom-select" onchange="setFilter('approve_req_type',this.value)">
                                                    <option value="" <?php if ($approve_req_type == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($approve_req_work != "") {
                                                        $condition2 = " AND `work` = '$approve_req_work'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `type` FROM `documents` WHERE `approved` = 4" . $condition2;
                                                    $objQueryType = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryType)) { ?>
                                                        <option value="<?php echo $objResult['type']; ?>" <?php if ($approve_req_type == $objResult['type']) {
                                                                                                                echo "selected";
                                                                                                            } ?>>
                                                            <?php echo $objResult['type']; ?>
                                                        </option>
                                                    <?php } ?>
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
                                                <th width="150">Prepared By<br><em></em></th>
                                                <th width="80">Status<br><em></em></th>
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
                                                        <img src="dist/img/icon/search.svg" style="padding: 5px;cursor: pointer;" width="35" onclick="window.location.href='detail_del.php?no=<?php echo md5($objResult['id']); ?>'" title="Approve<?php echo $objResult['id']; ?>">
                                                    </td>
                                                    <td><?php echo $objResult['discipline'] ?></td>
                                                    <td><?php echo $objResult['doc_no'] ?></td>
                                                    <td><?php echo $objResult['method_statement'] ?></td>
                                                    <td>
                                                        <?php
                                                        $date = $objResult['date_delete'];
                                                        $convertDate = strtotime($date);
                                                        $newDate = date("d-m-Y", $convertDate);
                                                        echo $newDate;
                                                        ?>
                                                    </td>
                                                    <td><?php echo $objResult['createdby'] ?></td>
                                                    <td>
                                                        <?php if ($objResult['status_del'] == 1) { ?>
                                                            Wait Approve
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