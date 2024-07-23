<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $document  = 2;
    $ismenu = 1;

    $current_menu = "documents";
    include_once('_head.php');
    $conDB = new db_conn();

    $documents_discipline = isset($_SESSION['documents_discipline']) ? $_SESSION['documents_discipline'] : '';
    $documents_work = isset($_SESSION['documents_work']) ? $_SESSION['documents_work'] : '';
    $documents_type = isset($_SESSION['documents_type']) ? $_SESSION['documents_type'] : '';
    $prepared_by = $_SESSION['user_name'];
    $mail = $_SESSION['user_mail'];

    if ($documents_discipline != "") {
        $condition = " AND `discipline` = '" . $documents_discipline . "'";
    } else {
        $condition = "";
    }
    if ($documents_work != "") {
        $condition2 = " AND `work` = '" . $documents_work . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }
    if ($documents_type != "") {
        $condition2 .= " AND `type` = '" . $documents_type . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }

    $sql = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result = $conDB->sqlQuery($sql);
    while ($obj = mysqli_fetch_assoc($result)) {
        if ($obj['role'] == 'ADMIN') {
            $strSQL = "SELECT * FROM `documents` WHERE `admin` = 1  AND `enable` = 1" . $condition;
            $objQuery = $conDB->sqlQuery($strSQL);
        } else {
            $strSQL = "SELECT * FROM `documents` WHERE `createdby` = '$mail' AND `enable` = 1" . $condition;
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
                            <h1>My Document</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <?php if ($document > 1) { ?>
                    <div>
                        <button type="button" class="btn btn-app flat" onclick="window.location.href='create_document.php'" title="New">
                            <img src="dist/img/icon/add.svg" style="padding:3px;" width="24"><br>
                            New
                        </button>
                    </div>
                <?php } ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Discipline <em></em></label>
                                                <select class="custom-select" onchange="setFilter('documents_discipline',this.value)">
                                                    <option value="" <?php if ($documents_discipline == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    $sql2 = "SELECT DISTINCT `discipline` FROM `documents` WHERE `createdby` = '$mail'";
                                                    $objQueryDisc = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryDisc)) { ?>
                                                        <option value="<?php echo $objResult['discipline']; ?>" <?php if ($documents_discipline == $objResult['discipline']) {
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
                                                <select class="custom-select" onchange="setFilter('documents_work',this.value)">
                                                    <option value="" <?php if ($documents_work == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($documents_discipline != "") {
                                                        $condition2 = " AND `discipline` = '$documents_discipline'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `work` FROM `documents` WHERE `createdby` = '$mail'" . $condition2;
                                                    $objQueryWork = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryWork)) { ?>
                                                        <option value="<?php echo $objResult['work']; ?>" <?php if ($documents_work == $objResult['work']) {
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
                                                <select class="custom-select" onchange="setFilter('documents_type',this.value)">
                                                    <option value="" <?php if ($documents_type == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($documents_work != "") {
                                                        $condition2 = " AND `work` = '$documents_work'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `type` FROM `documents` WHERE `createdby` = '$mail'" . $condition2;
                                                    $objQueryType = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryType)) { ?>
                                                        <option value="<?php echo $objResult['type']; ?>" <?php if ($documents_type == $objResult['type']) {
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
                                                <th width="90">Tools<br><em></em></th>
                                                <th width="80">Discipline​<br><em></em></th>
                                                <th width="90">Document No.​<br><em></em></th>
                                                <th width="300">Document Title<br><em></em></th>
                                                <th width="80">Date<br><em></em></th>
                                                <th width="100">Status<br><em></em></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 1;
                                            while ($objResult = mysqli_fetch_assoc($objQuery)) {
                                            ?>
                                                <tr onDblClick="window.location.href='documents_edit.php?no=<?php echo md5($objResult['id']); ?>'">
                                                    <td><?php echo $index++; ?></td>
                                                    <td align="center">
                                                        <?php if ($objResult['approved'] == 0) { ?>
                                                            <img src="dist/img/icon/search.svg" onclick="window.location.href='view_notapproved.php?no=<?php echo md5($objResult['id']); ?>'" title="Edit" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/edit.svg" onclick="window.location.href='documents_edit.php?no=<?php echo md5($objResult['id']); ?>'" title="Edit" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/delete.png" onclick="setDelete('documents','<?php echo $objResult['id']; ?>','<?php echo $objResult['doc_no']; ?>','documents.php')" title="Delete" width="30" style="padding: 5px;cursor: pointer;" />
                                                        <?php } elseif ($objResult['approved'] == 4) { ?>
                                                            <img src="dist/img/icon/bin.png" onclick="window.location.href='req_delete.php?no=<?php echo md5($objResult['id']); ?>'" width="30" style="padding: 5px;cursor: pointer;" title="Delete" />
                                                        <?php } else { ?>
                                                            <img src="dist/img/icon/delete.png" onclick="setDelete('documents','<?php echo $objResult['id']; ?>','<?php echo $objResult['doc_no']; ?>','documents.php')" title="Delete" width="30" style="padding: 5px;cursor: pointer;" />
                                                        <?php } ?>
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
                                                    <td>
                                                        <?php if ($objResult['approved'] == 0 || $objResult['approved'] == 5) { ?>
                                                            Not Approved
                                                        <?php } elseif ($objResult['approved'] == 1) { ?>
                                                            Prepared
                                                        <?php } elseif ($objResult['approved'] == 2) { ?>
                                                            Checked
                                                        <?php } elseif ($objResult['approved'] == 3) { ?>
                                                            ISO Review
                                                        <?php } elseif ($objResult['approved'] == 4) { ?>
                                                            Approved
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