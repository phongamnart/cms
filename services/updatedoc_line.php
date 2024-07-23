<?php
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();

$redirect = "";
$doc_id = $conDB->sqlEscapestr($_POST['doc_id']);
$doc_id = isset($doc_id) ? $doc_id : '';
$content_id = $conDB->sqlEscapestr($_POST['content_id']);
$content_id = isset($content_id) ? $content_id : '';
$value = $conDB->sqlEscapestr($_POST['value']);
$value = isset($value) ? $value : '';
$createdby = $_SESSION['user_name'];
$mail = $_SESSION['user_mail'];
$date = date('Y-m-d');


$strSQL = "SELECT * FROM `documents_line` WHERE `doc_id` = '" . $doc_id . "' AND `content_id` = '" . $content_id . "'";
$exist = $conDB->sqlNumrows($strSQL);
if ($exist == 0) {
    $str = "INSERT INTO `documents_line` (`doc_id`, `content_id`, `index_num`, `createdby`, `created`, `enable`) VALUES ('$doc_id', '$content_id', '$content_id', '$mail', '$date', '1');";
    $conDB->sqlQuery($str);
} else {
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResultCon = mysqli_fetch_assoc($objQuery)) {
        $str = "UPDATE `documents_line` SET `enable` = '" . $value . "' WHERE `id` = '" . $objResultCon['id'] . "'";
        $conDB->sqlQuery($str);
    }
}

$myObj->redirect = $str;
$myJSON = json_encode($myObj);
echo $myJSON;
