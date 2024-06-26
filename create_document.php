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
    $discipline = isset($_SESSION['discipline']) ? $_SESSION['discipline'] : '';
    $work = isset($_SESSION['work']) ? $_SESSION['work'] : '';
    $type = isset($_SESSION['type']) ? $_SESSION['type'] : '';
    $prepared_by = $_SESSION['user_name'];
    $mail = $_SESSION['user_mail'];
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
                            <h1>Create Document</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div>
                    <form action="services/create.php" method="post">
                        <button type="button" class="btn btn-app flat" onClick="window.location.href='documents.php'" title="<?php echo BTN_DISCARD; ?>">
                            <img src="dist/img/icon/multiply.svg" style="padding:3px;" width="24"><br>
                            <?php echo BTN_DISCARD; ?>
                        </button>
                        <button type="submit" class="btn btn-app flat" title="Save">
                            <img src="dist/img/icon/save.svg" style="padding:3px;" width="24"><br>
                            Save
                        </button>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="discipline">Discipline</label>
                                                        <select name="discipline" id="discipline" class="custom-select" style="width: 100%;" onchange="setFilter('discipline',this.value)">
                                                            <option value="" <?php if ($discipline == '') {
                                                                                    echo "selected";
                                                                                } ?>>All</option>
                                                            <?php
                                                            $sql2 = "SELECT DISTINCT `discipline` FROM `type`";
                                                            $objQuery = $conDB->sqlQuery($sql2);

                                                            while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                                                <option value="<?php echo $objResult['discipline']; ?>" <?php if ($discipline == $objResult['discipline']) {
                                                                                                                            echo "selected";
                                                                                                                        } ?>><?php echo $objResult['discipline']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="work">Works</label>
                                                        <select name="work" id="work" class="custom-select" style="width: 100%;" onchange="setFilter('work',this.value)">
                                                            <option value="" <?php if ($work == '') {
                                                                                    echo "selected";
                                                                                } ?>>All</option>
                                                            <?php
                                                            if ($discipline != "") {
                                                                $condition2 = " AND `discipline` = '$discipline'";
                                                            }
                                                            $sql2 = "SELECT DISTINCT `work` FROM `type` WHERE `enable` = 1" . $condition2;
                                                            $objQuery = $conDB->sqlQuery($sql2);

                                                            while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                                                <option value="<?php echo $objResult['work']; ?>" <?php if ($work == $objResult['work']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>><?php echo $objResult['work']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="type">Type</label>
                                                        <select name="type" id="type" class="custom-select" style="width: 100%;" onchange="setFilter('type',this.value)">
                                                            <option value="" <?php if ($type == '') {
                                                                                    echo "selected";
                                                                                } ?>>All</option>
                                                            <?php
                                                            if ($work != "") {
                                                                $condition2 = " AND `work` = '$work'";
                                                            }
                                                            $sql2 = "SELECT DISTINCT `type` FROM `type` WHERE `enable` = 1" . $condition2;
                                                            $objQuery = $conDB->sqlQuery($sql2);

                                                            while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                                                                <option value="<?php echo $objResult['type']; ?>" <?php if ($type == $objResult['type']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>><?php echo $objResult['type']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label for="">Document Title</label>
                                                        <input type="text" class="form-control" name="document_title" id="document_title" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Prepare By</label>
                                                        <input type="text" class="form-control" name="prepared_by" id="prepared_by" value="<?php echo $prepared_by ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Create By</label>
                                                        <input type="text" class="form-control" name="created_by" id="created_by" value="<?php echo $mail; ?>" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="">Check By</label>
                                                        <input type="text" class="form-control" name="checked_by" id="checked_by" required />
                                                    </div>
                                                </div>
                                                <?php
                                                $sql = "SELECT * FROM approvals_template WHERE `role` = 'QMR'";
                                                $result = $conDB->sqlQuery($sql);
                                                while ($obj = mysqli_fetch_assoc($result)) { ?>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="">Approve By</label>
                                                            <input type="text" class="form-control" name="approved" id="approved" value="<?php echo $obj['name']; ?>" disabled />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="">Remark</label>
                                                    <textarea name="remark" id="remark" class="form-control" rows="3"></textarea>
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