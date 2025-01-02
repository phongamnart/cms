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
                            <h1>Add User</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div>
                    <form action="services/form_add_user.php" method="post">
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
                                                        <select name="role" id="role" class="custom-select" style="width: 100%;">
                                                            <option value="ADMIN">ADMIN</option>
                                                            <option value="QMR">QMR</option>
                                                            <option value="ISO">ISO</option>
                                                            <option value="Check">Check</option>
                                                            <option value="Prepared">Prepared</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Depart</label>
                                                        <input type="text" class="form-control" name="depart" id="depart" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="system">System</label>
                                                        <select name="system" id="system" class="custom-select" style="width: 100%;">
                                                            <option value="CE">CE</option>
                                                            <option value="EE">EE</option>
                                                            <option value="ME">ME</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Name</label>
                                                        <input type="text" class="form-control" name="name" id="name" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="text" class="form-control" name="mail" id="mail" />
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