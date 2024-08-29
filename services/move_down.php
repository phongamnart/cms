<?php
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();
$id = "";
$line_id = "";
$index_num = "";
$id = $conDB->sqlEscapestr($_POST['id']);
$line_id = $conDB->sqlEscapestr($_POST['line_id']);
$index_num = $conDB->sqlEscapestr($_POST['index_num']);
$next_index = $index_num + 1;

$strSQL = "SELECT * FROM `documents_line_cont` WHERE `index_num` = '$next_index'";
$objQuery = $conDB->sqlQuery($strSQL);
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $id_old = $objResult['id'];
}

$str = "UPDATE `documents_line_cont` SET `index_num` = '$next_index' WHERE `id` = '$id' AND `line_id` = '$line_id'";
$conDB->sqlQuery($str);

$str1 = "UPDATE `documents_line_cont` SET `index_num` = '$index_num' WHERE `id` = '$id_old' AND `line_id` = '$line_id'";
$conDB->sqlQuery($str1);
