<?php
include("../_check_session.php");
$conDB = new db_conn();

$mail = $_SESSION['user_mail'];
$createdby = $_SESSION['user_name'];
$discipline = isset($_POST['discipline']) ? $_POST['discipline'] : '';
$work = isset($_POST['work']) ? $_POST['work'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$method_statement = isset($_POST['method_statement']) ? $_POST['method_statement'] : '';
$doc_no = isset($_POST['doc_no']) ? $_POST['doc_no'] : '';
$reason = isset($_POST['reason']) ? $_POST['reason'] : '';
$created = date('Y-m-d');

$strSQL2 = "INSERT INTO `delete_logs` (`doc_no`, `discipline`, `work`, `type`, `method_statement`, `createdby`, `mail`, `created`, `reason`)
            VALUES ('$doc_no', '$discipline', '$work', '$type', '$method_statement', '$createdby', '$mail', '$created', '$reason')";
$conDB->sqlQuery($strSQL2);

header("Location: ../documents.php")
?>