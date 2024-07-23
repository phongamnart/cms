<?php
include("../_check_session.php");
$conDB = new db_conn();
$myObj = (object)array();
$fromName = 'Construction Method Statement';
 
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: '.$fromName."\r\n";
 
$to = $conDB->sqlEscapestr($_POST['to']);
$subject = $conDB->sqlEscapestr($_POST['subject']);
$htmlContent = stripslashes($_POST['htmlContent']);
 
if(mail($to, $subject, $htmlContent, $headers)){
    $myObj->alert = 'Email has sent successfully.';
}else{
    $myObj->alert = 'Email sending failed.';
}
 
$myJSON = json_encode($myObj);
echo $myJSON;
?>