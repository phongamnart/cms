<?php
session_start();
include("../config/app.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conDB = new db_conn();
$id = "";
$id = $conDB->sqlEscapestr($_POST['id']);

$mail = $_SESSION['user_mail'];

$strSQL = "SELECT COUNT(*) as count FROM `documents_line_cont` WHERE `createdby` = '$mail' AND `approved` != 2";
$result2 = $conDB->sqlQuery($strSQL);
$row = mysqli_fetch_assoc($result2);

$response = new stdClass();

if ($row['count'] == 0) {
    $response->approved = true;
} else {
    $response->approved = false;
}

echo json_encode($response);
?>
