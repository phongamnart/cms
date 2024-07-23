<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();
$table ="";
$field ="";
$value ="";
$table = $conDB->sqlEscapestr($_POST['table']);
$field = $conDB->sqlEscapestr($_POST['field']);
$value = $conDB->sqlEscapestr($_POST['value']);

$str = "INSERT INTO `".$table."` (`".$field."`) VALUES ('".$value."')";
$conDB->sqlQuery($str);
$myObj->alerts = $str;

$myJSON = json_encode($myObj);
echo $myJSON;
?>