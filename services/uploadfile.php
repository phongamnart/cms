<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();
$doc_id = "";
$filename = "";
$type = "";
$redirect = "";
$createdby = $_SESSION['user_name'];

if(isset($_POST)){
    $doc_id = $conDB->sqlEscapestr($_POST['doc_id']);
    $type = $conDB->sqlEscapestr($_POST['type']);
    $redirect = $conDB->sqlEscapestr($_POST['redirect']);
    $filename = $_FILES['file']['name'];
    $path = "../upload/files/" .$doc_id. "/";
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if($filename != ''){
        $extension = explode(".",$filename);
        $ext = $extension[count($extension) - 1];
        $newfilename = date('Ymdhis').".".$ext;
        $location = $path."/".$newfilename;
        if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) { 
            $str = "INSERT INTO `documents_line_cont` (`line_id`,`is_image`, `content`, `createdby`) VALUES ('".$doc_id."', 1, '".$location."', '".$createdby."')";
            $conDB->sqlQuery($str);
        }
    }
    if($redirect != ""){
        $myObj->context  = $redirect;
    }
}
$myJSON = json_encode($myObj);
echo $myJSON;
?>