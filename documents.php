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
                        <button type="button" class="btn btn-app flat" onclick="window.location.href='create_document.php'" title="New Document">
                            <img src="dist/img/icon/add.svg" style="padding:3px;" width="24"><br>
                            New
                        </button>
                        <button type="button" class="btn btn-app flat" onclick="window.location.href='request.php'" title="History">
                            <img src="dist/img/icon/refresh.png" style="padding:3px;" width="24"><br>
                            History
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
                                                <label>Work <em></em></label>
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
                                                <th width="200">Tools<br><em></em></th>
                                                <th width="80">Discipline​<br><em></em></th>
                                                <th width="120">Document No.​<br><em></em></th>
                                                <th width="80">Language​<br><em></em></th>
                                                <th width="500">Document Title<br><em></em></th>
                                                <th width="80">Date<br><em></em></th>
                                                <th width="200">Status<br><em></em></th>
                                                <th width="300">Waiting for<br><em></em></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 1;
                                            while ($objResult = mysqli_fetch_assoc($objQuery)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $index++; ?></td>
                                                    <td align="center">
                                                        <?php if ($objResult['approved'] == 0 || $objResult['approved'] == 5) { ?>
                                                            <img src="dist/img/icon/search.svg" onclick="window.location.href='documents_edit.php?no=<?php echo md5($objResult['id']); ?>'" title="View" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/edit.svg" onclick="window.location.href='documents_edit.php?no=<?php echo md5($objResult['id']) . '&l=' . $objResult['type_doc'] . '&m=' . md5($objResult['doc_no'] . '1'); ?>'" title="Edit" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/doc.png" onclick="previewWord('<?php echo md5($objResult['id']); ?>', 'download.php?no=<?php echo md5($objResult['id']) ?>')" title="Download Word" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/pdf.png" onclick="window.open('documents_pdf.php?no=<?php echo md5($objResult['id']); ?>#toolbar=0', '_blank');" title="PDF" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/delete.png" onclick="setDelete('documents','<?php echo $objResult['id']; ?>','<?php echo $objResult['doc_no']; ?>','documents.php')" title="Delete" width="30" style="padding: 5px;cursor: pointer;" />
                                                        <?php } elseif ($objResult['approved'] == 4) { ?>
                                                            <img src="dist/img/icon/search.svg" onclick="window.location.href='documents_edit.php?no=<?php echo md5($objResult['id']); ?>'" title="View" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/edit.svg" onclick="" title="Not allow edit" width="30" style="padding: 5px;cursor: not-allowed;opacity: 0.2;" />
                                                            <img src="dist/img/icon/doc.png" onclick="" title="Download Word" width="30" style="padding: 5px;cursor: not-allowed; opacity: 0.2;" />
                                                            <img src="dist/img/icon/pdf.png" onclick="" title="PDF" width="30" style="padding: 5px;cursor: not-allowed; opacity: 0.2;" />
                                                            <img src="dist/img/icon/delete.png" onclick="window.location.href='req_delete.php?no=<?php echo md5($objResult['id']); ?>'" title="Request Delete" width="30" style="padding: 5px;cursor: pointer;" />
                                                        <?php } else { ?>
                                                            <img src="dist/img/icon/search.svg" onclick="window.location.href='documents_edit.php?no=<?php echo md5($objResult['id']); ?>'" title="View" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/edit.svg" onclick="" title="Not allow edit" width="30" style="padding: 5px;cursor: not-allowed;opacity:0.2;" />
                                                            <img src="dist/img/icon/doc.png" onclick="previewWord('<?php echo md5($objResult['id']); ?>', 'download.php?no=<?php echo md5($objResult['id']) ?>')" title="Download Word" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/pdf.png" onclick="window.open('documents_pdf.php?no=<?php echo md5($objResult['id']); ?>#toolbar=0', '_blank');" title="PDF" width="30" style="padding: 5px;cursor: pointer;" />
                                                            <img src="dist/img/icon/delete.png" onclick="" title="Not allow delete" width="30" style="padding: 5px;cursor: not-allowed;opacity:0.2;" />
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $objResult['discipline'] ?></td>
                                                    <td><?php echo $objResult['doc_no'] ?></td>
                                                    <td><?php if ($objResult['type_doc'] == "en") { ?>
                                                            English
                                                        <?php } elseif ($objResult['type_doc'] == "th") { ?>
                                                            Thai
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $objResult['method_statement'] ?></td>
                                                    <td>
                                                        <?php
                                                        $date_prepared = $objResult['date_prepared'];
                                                        $date_checked = $objResult['date_checked'];
                                                        $date_approved = $objResult['date_approved'];

                                                        $timestamp_prepared = strtotime($date_prepared);
                                                        $timestamp_checked = strtotime($date_checked);
                                                        $timestamp_approved = strtotime($date_approved);
                                                        $max_timestamp = max($timestamp_prepared, $timestamp_checked, $timestamp_approved);

                                                        $newDate = date("d-m-Y", $max_timestamp);
                                                        echo $newDate;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($objResult['approved'] == 0) {
                                                            $class = 'class="text-info"' ?>
                                                            <span <?php echo $class ?>>Draft</span>
                                                        <?php } elseif ($objResult['approved'] == 1) {
                                                            $class = 'class="text-primary"' ?>
                                                            <span <?php echo $class ?>>Pending Check</span>
                                                        <?php } elseif ($objResult['approved'] == 2) {
                                                            $class = 'class="text-primary"' ?>
                                                            <span <?php echo $class ?>>Pending ISO</span>
                                                        <?php } elseif ($objResult['approved'] == 3) {
                                                            $class = 'class="text-primary"' ?>
                                                            <span <?php echo $class ?>>Pending QMR</span>
                                                        <?php } elseif ($objResult['approved'] == 4) {
                                                            $class = 'class="text-success"' ?>
                                                            <span <?php echo $class ?>>Approved</span>
                                                        <?php } elseif ($objResult['approved'] == 5) {
                                                            $class = 'class="text-warning"' ?>
                                                            <span <?php echo $class ?>>Reject</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($objResult['approved'] == 0 || $objResult['approved'] == 5) { ?>

                                                        <?php } elseif ($objResult['approved'] == 1) { ?>
                                                            <?php
                                                            $strSQL2 = "SELECT * FROM `approval` WHERE `mail` = '" . $objResult['checkedby'] . "'";
                                                            $objQuery2 = $conDB->sqlQuery($strSQL2);
                                                            while ($objResult2 = mysqli_fetch_assoc($objQuery2)) {
                                                                $name_check = $objResult2['name'];
                                                            }
                                                            ?>
                                                            <?php echo $name_check ?>
                                                        <?php } elseif ($objResult['approved'] == 2) { ?>
                                                            <?php
                                                            $strSQL3 = "SELECT * FROM `approval` WHERE `role` = 'ISO'";
                                                            $objQuery3 = $conDB->sqlQuery($strSQL3);
                                                            while ($objResult3 = mysqli_fetch_assoc($objQuery3)) {
                                                                $name_iso = $objResult3['name'];
                                                            }
                                                            ?>
                                                            <?php echo $name_iso ?>
                                                        <?php } elseif ($objResult['approved'] == 3) { ?>
                                                            <?php
                                                            $strSQL4 = "SELECT * FROM `approval` WHERE `role` = 'QMR'";
                                                            $objQuery4 = $conDB->sqlQuery($strSQL4);
                                                            while ($objResult4 = mysqli_fetch_assoc($objQuery4)) {
                                                                $name_qmr = $objResult4['name'];
                                                            }
                                                            ?>
                                                            <?php echo $name_qmr ?>
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
                    "scrollX": true,
                    // "fixedColumns": {
                    //     left: 3
                    // }
                });
            },
            500);
    </script>

</html>