<?php 
session_start();
isset( $_SESSION['user_name'] ) ? $user_name = $_SESSION['user_name'] : $user_name = "";

if($user_name == ""){
    header( "location:logout.php" );
    exit(0);
}
include("config/app.php");
include("config/content.php");

$current_page = "";
$current_menu = "";
$ismenu = "";
$status = "";
$condition2 = "";
$enable = "";
?>