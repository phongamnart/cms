<?php
include("../_check_session.php");
$conDB = new db_conn();

$discipline = isset($_POST['discipline']) ? $_POST['discipline'] : '';
$work = isset($_POST['work']) ? $_POST['work'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';

$strSQL2 = "INSERT INTO `type` (`discipline`, `work`, `type`) VALUES ('$discipline', '$work', '$type')";
$conDB->sqlQuery($strSQL2);


header("Location: ../discipline.php")
?>