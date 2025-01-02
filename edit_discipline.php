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
    $get_id = $_GET['no'];

    $strSQL = "SELECT * FROM `type` WHERE md5(`id`) = '$get_id' AND `enable` = 1";
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $discipline = $objResult['discipline'];
        $work = $objResult['work'];
        $type = $objResult['type'];
        $id = $objResult['id'];
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
                            <h1>Edit Discipline</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div>
                    <form action="services/update_discipline.php" method="post">
                        <button type="button" class="btn btn-app flat" onClick="window.location.href='discipline.php'" title="<?php echo BTN_DISCARD; ?>">
                            <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                            <?php echo BTN_DISCARD; ?>
                        </button>
                        <button type="submit" class="btn btn-app flat" title="Save">
                            <img src="dist/img/icon/save.svg" style="padding:3px;" width="24"><br>
                            Save
                        </button>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Discipline</label>
                                                        <input type="text" class="form-control" name="discipline" id="discipline" value="<?php echo $discipline ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Work</label>
                                                        <input type="text" class="form-control" name="work" id="work" value="<?php echo $work ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Type</label>
                                                        <input type="text" class="form-control" name="type_discipline" id="type_discipline" value="<?php echo $type ?>" />
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