<?php 
session_start();
include("config/app.php");
$conDB = new db_conn();

$_SESSION['user_id'] = '';
$_SESSION['user_mail'] = 'phongamnart@italthaiengineering.com';
$_SESSION['user_name'] = 'Phongamnart';
$_SESSION['user_depart'] = 'ITDP';
$_SESSION['user_language'] = 'en';
echo "<html>
<head>
<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=http://".URL_SERV."\">
</head>
</html>";
?>