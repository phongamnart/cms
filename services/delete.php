<?php
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();

// $id = "";
// $table = "";
// $redirect = "";
$id = $conDB->sqlEscapestr($_POST['id']);
$id = isset($id) ? $id : '';
$table = $conDB->sqlEscapestr($_POST['table']);
$table = isset($table) ? $table : '';
$redirect = $conDB->sqlEscapestr($_POST['redirect']);
$redirect = isset($redirect) ? $redirect : '';


if ($table == 'documents_line_cont') {
    $strSQL = "SELECT * FROM `documents_line_cont` WHERE `id` = '" . $id . "'";
    $objQuery = $conDB->sqlQuery($strSQL);

    while ($objResultCon = mysqli_fetch_assoc($objQuery)) {
        if ($objResultCon['is_image'] == 1) {
            $content = $objResultCon['content'];
            if (file_exists($content)) {
                unlink($content);
            }
        }
    }
}
$strSQL = "DELETE FROM `" . $table . "` WHERE `id` = '" . $id . "' LIMIT 1";
$conDB->sqlQuery($strSQL);
// $strSQL = "DELETE FROM `" . $table . "_line` WHERE `doc_id` = '" . $id . "' LIMIT 1";
// $conDB->sqlQuery($strSQL);
$myObj->redirect = $redirect;
$myJSON = json_encode($myObj);
echo $myJSON;
