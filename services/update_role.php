<?php
include("../_check_session.php");
$conDB = new db_conn();

$id = $conDB->sqlEscapestr($_POST['id']);
$role = isset($_POST['role']) ? $_POST['role'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$mail = isset($_POST['mail']) ? $_POST['mail'] : '';
$depart = isset($_POST['depart']) ? $_POST['depart'] : '';
$date = date('Y-m-d');

$strSQL2 = "UPDATE `approval` SET `role` = '$role', `name` = '$name', `mail` = '$mail', `depart` = '$depart' WHERE md5(`id`) = '$id'";
$conDB->sqlQuery($strSQL2);

if ($role == 'Check') {
    $sql = "SELECT * FROM `checker` WHERE `mail` = '$mail'";
    $result = $conDB->sqlQuery($sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($obj = mysqli_fetch_assoc($result)) {
            //nothing
        }
    } else {
        $strSQL3 = "INSERT INTO `checker` (`role`, `name`, `mail`, `depart`, `date`)
        VALUES ('$role', '$name', '$mail', '$depart', '$date')";
        $conDB->sqlQuery($strSQL3);
    }
}

header("Location: ../add_permission.php")
?>