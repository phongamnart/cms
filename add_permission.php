<?php
include("_check_session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $document  = 2;
    $ismenu = 3;
    $current_menu = "add_permission";
    include_once('_head.php');
    $conDB = new db_conn();
    $mail = $_SESSION['user_mail'];

    $sql = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
    $result = $conDB->sqlQuery($sql);
    while ($obj = mysqli_fetch_assoc($result)) {
        if($obj['role'] == 'ADMIN') {
            $strSQL = "SELECT * FROM `approval`";
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
                            <h1>Method Statement List <?php echo $role?></h1>
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
                                    <table id="datatable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="30">No.<br><em></em></th>
                                                <th width="60">Tools<br><em></em></th>
                                                <th width="80">Role<br><em></em></th>
                                                <th width="150">Name​<br><em></em></th>
                                                <th width="200">Mail<br><em></em></th>
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
                                                        <img src="dist/img/icon/edit.svg" onclick="window.location.href='edit_user.php?no=<?php echo md5($objResult['id']); ?>'" title="Edit" width="30" style="padding: 5px;cursor: pointer;" />
                                                    </td>
                                                    <td><?php echo $objResult['role'] ?></td>
                                                    <td><?php echo $objResult['name'] ?></td>
                                                    <td><?php echo $objResult['mail'] ?></td>
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