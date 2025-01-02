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

    if (isset($_GET['documents_list_discipline'])) {
        $_SESSION['documents_list_discipline'] = $_GET['documents_list_discipline'];
    }

    $documents_list_discipline = isset($_SESSION['documents_list_discipline']) ? $_SESSION['documents_list_discipline'] : '';
    $documents_list_work = isset($_SESSION['documents_list_work']) ? $_SESSION['documents_list_work'] : '';
    $documents_list_type = isset($_SESSION['documents_list_type']) ? $_SESSION['documents_list_type'] : '';

    if ($documents_list_discipline != "") {
        $condition = " AND `discipline` = '" . $documents_list_discipline . "'";
    } else {
        $condition = "";
    }
    if ($documents_list_work != "") {
        $condition = " AND `work` = '" . $documents_list_work . "'";
        $condition .= $condition;
    } else {
        $condition .= "";
    }
    if ($documents_list_type != "") {
        $condition .= " AND `type` = '" . $documents_list_type . "'";
        $condition .= $condition;
    } else {
        $condition .= "";
    }

    $strSQL = "SELECT * FROM `documents` WHERE `approved` = 4 AND `enable` = 1" . $condition;
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
                            <h1>Document List</h1>
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
                                                <select class="custom-select" onchange="setFilter('documents_list_discipline',this.value)">
                                                    <option value="" <?php if ($documents_list_discipline == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    $sql2 = "SELECT DISTINCT `discipline` FROM `documents` WHERE `approved` = 4";
                                                    $objQueryDisc = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryDisc)) { ?>
                                                        <option value="<?php echo $objResult['discipline']; ?>" <?php if ($documents_list_discipline == $objResult['discipline']) {
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
                                                <select class="custom-select" onchange="setFilter('documents_list_work',this.value)">
                                                    <option value="" <?php if ($documents_list_work == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($documents_list_discipline != "") {
                                                        $condition2 = " AND `discipline` = '$documents_list_discipline'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `work` FROM `documents` WHERE `approved` = 4" . $condition2;
                                                    $objQueryWork = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryWork)) { ?>
                                                        <option value="<?php echo $objResult['work']; ?>" <?php if ($documents_list_work == $objResult['work']) {
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
                                                <select class="custom-select" onchange="setFilter('documents_list_type',this.value)">
                                                    <option value="" <?php if ($documents_list_type == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($documents_list_work != "") {
                                                        $condition2 = " AND `work` = '$documents_list_work'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `type` FROM `documents` WHERE `approved` = 4" . $condition2;
                                                    $objQueryType = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryType)) { ?>
                                                        <option value="<?php echo $objResult['type']; ?>" <?php if ($documents_list_type == $objResult['type']) {
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
                                                <th width="50">No.<br><em></em></th>
                                                <th width="150">Tools<br><em></em></th>
                                                <th width="80">Discipline​<br><em></em></th>
                                                <th width="120">Document No.​<br><em></em></th>
                                                <th width="500">Document Title<br><em></em></th>
                                                <th width="370">Change/Modify<br><em></em></th>
                                                <th width="80">Date<br><em></em></th>
                                                <th width="370">Prepared By<br><em></em></th>
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
                                                        <img src="dist/img/icon/search.svg" onclick="window.location.href='view_doc_list.php?no=<?php echo md5($objResult['id']); ?>'" title="Preview" width="35" style="padding: 5px;cursor: pointer;" />
                                                        <img src="dist/img/icon/download.png" onclick="window.location.href='req_download.php?no=<?php echo md5($objResult['id']) ?>'" title="Download Word" width="30" style="padding: 2px;cursor: pointer;" />&nbsp;
                                                        <img src="dist/img/icon/pdf.png" onclick="window.location.href='req_pdf.php?no=<?php echo md5($objResult['id']) ?>'" title="PDF" width="30" style="padding: 2px;cursor: pointer;" />
                                                        <img src="dist/img/icon/revision.png" onclick="window.location.href='req_revise.php?no=<?php echo md5($objResult['id']); ?>'" title="Revise" width="40" style="padding: 5px;cursor: pointer;" />
                                                    </td>
                                                    <td><?php echo $objResult['discipline'] ?></td>
                                                    <td><?php echo $objResult['doc_no'] ?></td>
                                                    <td><?php echo $objResult['method_statement'] ?></td>
                                                    <td><?php echo $objResult['remark'] ?></td>
                                                    <td>
                                                        <?php
                                                        $date_approved = $objResult['date_approved'];
                                                        $convertDate = strtotime($date_approved);
                                                        $newDate = date("d-m-Y", $convertDate);
                                                        echo $newDate;
                                                        ?>
                                                    </td>
                                                    <td><?php echo $objResult['preparedby'] ?></td>
                                                </tr>
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
                });
            },
            500);
    </script>

</html>