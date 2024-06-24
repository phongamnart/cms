<?php
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();

$redirect = "";
$doc_id = $conDB->sqlEscapestr($_POST['doc_id']);
$doc_id = isset($doc_id) ? $doc_id : '';

$createdby = $_SESSION['user_name'];

$strSQL_content = "SELECT * FROM `contents` WHERE `enable` = 1 AND `checked` = 1";
$objQuery_content = $conDB->sqlQuery($strSQL_content);

while ($objResult_content = mysqli_fetch_assoc($objQuery_content)) {
    $content_id = $objResult_content['id'];
    $strSQL = "SELECT * FROM `documents_line` WHERE `doc_id` = '" . $doc_id . "' AND `content_id` = '" . $content_id . "' AND `enable` = 1";
    $exist = $conDB->sqlNumrows($strSQL);
    
    if ($exist == 0) {
        $str = "INSERT INTO `documents_line` (`doc_id`, `content_id`, `index_num`, `createdby`, `created`, `enable`) VALUES ('$doc_id', '$content_id', '$content_id', '$createdby', NOW(), '1');";
        $conDB->sqlQuery($str);
    }
}

$myObj->redirect = $strSQL;
$myJSON = json_encode($myObj);
echo $myJSON;
