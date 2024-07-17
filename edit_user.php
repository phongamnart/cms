<?php
include("_check_session.php");
session_start();
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
    $get_id = $_GET['no'];
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

    $sql = "SELECT * FROM `approval` WHERE md5(`id`) = '$get_id'";
    $result = $conDB->sqlQuery($sql);
    while ($obj = mysqli_fetch_assoc($result)) {
        $name = $obj['name'];
        $mail = $obj['mail'];
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
                            <h1>Edit User</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div>
                    <form action="services/update_role.php" method="post">
                        <button type="button" class="btn btn-app flat" onClick="window.location.href='add_permission.php'" title="<?php echo BTN_DISCARD; ?>">
                            <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                            <?php echo BTN_DISCARD; ?>
                        </button>
                        <button type="submit" class="btn btn-app flat" title="Save">
                            <img src="dist/img/icon/save.svg" style="padding:3px;" width="24"><br>
                            Save
                        </button>
                        <input type="hidden" name="id" value="<?php echo $get_id; ?>">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="role">Role</label>
                                                        <select name="role" id="role" class="custom-select" style="width: 100%;" onchange="setFilter('role',this.value)">
                                                            <option value="" <?php if ($role == '') {
                                                                                    echo "selected";
                                                                                } ?>>All</option>
                                                            <?php
                                                            $sql2 = "SELECT DISTINCT `role` FROM `approval`";
                                                            $objQuery = $conDB->sqlQuery($sql2);

                                                            while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                                                <option value="<?php echo $objResult['role']; ?>" <?php if ($role == $objResult['role']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>><?php echo $objResult['role']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Name</label>
                                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">mail</label>
                                                        <input type="text" class="form-control" name="mail" id="mail" value="<?php echo $mail ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </form>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include_once('_footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php include_once('_script.php'); ?>

</html>