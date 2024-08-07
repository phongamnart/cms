<?php 
session_start();
include("config/app.php");
$conDB = new db_conn();

$_SESSION['user_id'] = '';
$_SESSION['user_mail'] = 'phongamnart@italthaiengineering.com';
$_SESSION['user_name'] = 'PHONGAMNART KEAWPANYA';

// $_SESSION['user_mail'] = 'test@mail.com';
// $_SESSION['user_name'] = 'Test';

// $_SESSION['user_mail'] = 'cms@mail.com';
// $_SESSION['user_name'] = 'CMS';

// $_SESSION['user_mail'] = 'check@mail.com';
// $_SESSION['user_name'] = 'Check';

// $_SESSION['user_mail'] = 'iso@mail.com';
// $_SESSION['user_name'] = 'ISO';

// $_SESSION['user_mail'] = 'qmr@mail.com';
// $_SESSION['user_name'] = 'QMR';

// $_SESSION['user_mail'] = 'admin@mail.com';
// $_SESSION['user_name'] = 'ADMIN';

$_SESSION['user_depart'] = 'ITDP';
$_SESSION['user_language'] = 'en';
$mail = $_SESSION['user_mail'];
$name = $_SESSION['user_name'];
$date = date('Y-m-d');

$sql = "SELECT * FROM `approval` WHERE `mail` = '$mail'";
$result = $conDB->sqlQuery($sql);

if($result && mysqli_num_rows($result) > 0){
    while ($obj = mysqli_fetch_assoc($result)) {
    //nothing
    }
} else {
    $strSQL3 = "INSERT INTO `approval` (`role`, `name`, `mail`, `date`)
    VALUES ('Prepared', '$name', '$mail', '$date')";
    $conDB->sqlQuery($strSQL3);
}

echo "<html>
<head>
<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=http://".URL_SERV."\">
</head>
</html>";
?>