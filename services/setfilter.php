<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$param = $conDB->sqlEscapestr($_POST['param']);
$value = $conDB->sqlEscapestr($_POST['value']);
$_SESSION[$param] = $value;
?>