<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();
$id ="";
$table ="";
$field ="";
$value ="";
$id = $conDB->sqlEscapestr($_POST['id']);
$table = $conDB->sqlEscapestr($_POST['table']);
$field = $conDB->sqlEscapestr($_POST['field']);
$value = $conDB->sqlEscapestr($_POST['value']);
$str = "UPDATE `".$table."` SET `".$field."` = '".$value."' WHERE md5(`line_id`) = '".$id."'";
$conDB->sqlQuery($str);
$myObj->alerts = $str;

$myJSON = json_encode($myObj);
echo $myJSON;
?>