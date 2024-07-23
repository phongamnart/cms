<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();

$noseries = md5(date("Y-m-d H:i:s"));
$date = date("Y-m-d");
$line_id = $_POST['line_id'];
$is_image = $_POST['is_image'];
$doc_id = $_POST['doc_id'];
$createdby = $_SESSION['user_mail'];
$date = date('Y-m-d');


$strSQL2 = "INSERT INTO `documents_line_cont` (`line_id`, `doc_id`, `is_image`, `createdby`, `created`) VALUES ('".$line_id."','".$doc_id."','".$is_image."','".$createdby."','".$date."')";
$conDB->sqlQuery($strSQL2);
$myJSON = json_encode($myObj);
echo $myJSON;
?>