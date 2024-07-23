<?php
include("../_check_session.php");
$conDB = new db_conn();

$mail = $_SESSION['user_mail'];
$preparedby = $_SESSION['user_name'];
$doc_no ="";
$request ="";
$doc_no = $conDB->sqlEscapestr($_POST['doc_no']);
$request = $conDB->sqlEscapestr($_POST['request']);
$date = date('Y-m-d');

$strSQL2 = "INSERT INTO `request` (`doc_no`, `createdby`, `date_req`, `status_req`, `request`, `type_request`)
            VALUES ('$doc_no', '$mail', '$date', 1, '$request', 'Download')";
$conDB->sqlQuery($strSQL2);

?>