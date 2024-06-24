<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();

$name = $conDB->sqlEscapestr($_GET['n']);
$email = $conDB->sqlEscapestr($_GET['e']);
$depart = $conDB->sqlEscapestr($_GET['d']);
$id = $conDB->sqlEscapestr($_GET['i']);

$_SESSION['user_id'] = $id;
$_SESSION['user_mail'] = $email;
$_SESSION['user_name'] = $name;
$_SESSION['user_depart'] = $depart;
echo "<html>
<head>
<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=http://".URL_SERV."\">
</head>
</html>";
?>