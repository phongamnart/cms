<?php
include("../_check_session.php");
$conDB = new db_conn();

$mail = $_SESSION['user_mail'];
$name = $_SESSION['user_name'];
$doc_no ="";
$request ="";
$doc_no = $conDB->sqlEscapestr($_POST['doc_no']);
$request = $conDB->sqlEscapestr($_POST['request']);
$date = date('Y-m-d');

$strSQL2 = "INSERT INTO `request` (`doc_no`, `name`, `createdby`, `date_delete`, `status_del`, `req_delete`, `type_request`)
            VALUES ('$doc_no', '$name', '$mail', '$date', 1, '$request', 'Delete')";
$conDB->sqlQuery($strSQL2);

?>