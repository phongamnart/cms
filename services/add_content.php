<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();

$noseries = md5(date("Y-m-d H:i:s"));
$date = date("Y-m-d");
$table = $conDB->sqlEscapestr($_POST['table']);
$line_id = $_POST['line_id'];
$is_image = $_POST['is_image'];
$createdby = $_SESSION['user_name'];

$strSQL2 = "INSERT INTO `documents_line_cont` (`line_id`,`is_image`,`createdby`) VALUES ('".$line_id."',".$is_image.",'".$createdby."')";
$conDB->sqlQuery($strSQL2);
$myJSON = json_encode($myObj);
echo $myJSON;
?>