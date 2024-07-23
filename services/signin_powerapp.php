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
$_SESSION['user_language'] = 'en';
$date = date('d-m-Y');

$sql = "SELECT * FROM `approval` WHERE `mail` = '$email'";
$result = $conDB->sqlQuery($sql);

if($result && mysqli_num_rows($result) > 0){
    while ($obj = mysqli_fetch_assoc($result)) {
    //nothing
    }
} else {
    $strSQL3 = "INSERT INTO `approval` (`role`, `name`, `mail`, `depart`, `date`)
    VALUES ('Prepared', '$name', '$email', '$depart', '$date')";
    $conDB->sqlQuery($strSQL3);
}

echo "<html>
<head>
<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=http://".URL_SERV."\">
</head>
</html>";
?>