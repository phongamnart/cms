<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $document  = 2;
    $ismenu = 3;
    $current_menu = "discipline";
    include_once('_head.php');
    $conDB = new db_conn();
    $mail = $_SESSION['user_mail'];
    $list_discipline = isset($_SESSION['list_discipline']) ? $_SESSION['list_discipline'] : '';
    $list_work = isset($_SESSION['list_work']) ? $_SESSION['list_work'] : '';
    $list_type = isset($_SESSION['list_type']) ? $_SESSION['list_type'] : '';

    if ($list_discipline != "") {
        $condition = " AND `discipline` = '" . $list_discipline . "'";
    } else {
        $condition = "";
    }
    if ($list_work != "") {
        $condition2 = " AND `work` = '" . $list_work . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }
    if ($list_type != "") {
        $condition2 .= " AND `type` = '" . $list_type . "'";
        $condition .= $condition2;
    } else {
        $condition .= "";
    }

    $sql = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result = $conDB->sqlQuery($sql);
    if ($result) {
        $objQuery = $result;
    } else {
        echo "Denied Permission";
        exit;
    }

    if ($objQuery && mysqli_num_rows($objQuery) > 0) {
        while ($obj = mysqli_fetch_assoc($result)) {
            if ($obj['role'] == 'ADMIN' || $obj['role'] == 'ISO') {
                $strSQL = "SELECT * FROM `type` WHERE `enable` = 1" . $condition;
                $objQuery = $conDB->sqlQuery($strSQL);
            }
        }
    } else {
        echo "No records found.";
        exit;
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
                            <h1>Discipline List</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div>
                    <button type="button" class="btn btn-app flat" onclick="window.location.href='add_discipline.php'" title="New">
                        <img src="dist/img/icon/add.svg" style="padding:3px;" width="24"><br>
                        New
                    </button>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Discipline <em></em></label>
                                                <select class="custom-select" onchange="setFilter('list_discipline',this.value)">
                                                    <option value="" <?php if ($list_discipline == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    $sql2 = "SELECT DISTINCT `discipline` FROM `type` WHERE `enable` = 1";
                                                    $objQueryDisc = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryDisc)) { ?>
                                                        <option value="<?php echo $objResult['discipline']; ?>" <?php if ($list_discipline == $objResult['discipline']) {
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
                                                <select class="custom-select" onchange="setFilter('list_work',this.value)">
                                                    <option value="" <?php if ($list_work == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($list_discipline != "") {
                                                        $condition2 = " AND `discipline` = '$list_discipline'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `work` FROM `type` WHERE `enable` = 1" . $condition2;
                                                    $objQueryWork = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryWork)) { ?>
                                                        <option value="<?php echo $objResult['work']; ?>" <?php if ($list_work == $objResult['work']) {
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
                                                <select class="custom-select" onchange="setFilter('list_type',this.value)">
                                                    <option value="" <?php if ($list_type == '') {
                                                                            echo "selected";
                                                                        } ?>>All</option>
                                                    <?php
                                                    if ($list_work != "") {
                                                        $condition2 = " AND `work` = '$list_work'";
                                                    }
                                                    $sql2 = "SELECT DISTINCT `type` FROM `type` WHERE `enable` = 1" . $condition2;
                                                    $objQueryType = $conDB->sqlQuery($sql2);

                                                    while ($objResult = mysqli_fetch_assoc($objQueryType)) { ?>
                                                        <option value="<?php echo $objResult['type']; ?>" <?php if ($list_type == $objResult['type']) {
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
                                                <th width="30">No.<br><em></em></th>
                                                <th width="30">Tools<br><em></em></th>
                                                <th width="80">Discipline<br><em></em></th>
                                                <th width="80">Work<br><em></em></th>
                                                <th width="80">Type<br><em></em></th>
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
                                                        <img src="dist/img/icon/edit.svg" onclick="window.location.href='edit_discipline.php?no=<?php echo md5($objResult['id']) ?>'" title="Edit" width="30" style="padding: 5px;cursor: pointer;"/>
                                                        <img src="dist/img/icon/delete.png" onclick="delete_discipline('type', '<?php echo md5($objResult['id']) ?>', '<?php echo $objResult['type'] ?>', '')" title="Delete" width="30" style="padding: 5px;cursor: pointer;"/>
                                                    </td>
                                                    <td><?php echo $objResult['discipline'] ?></td>
                                                    <td><?php echo $objResult['work'] ?></td>
                                                    <td><?php echo $objResult['type'] ?></td>
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