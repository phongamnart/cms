<?php 
session_start();
include("../config/app.php");
$conDB = new db_conn();
$myObj = (object)array();
$id = "";
$filename = "";
$redirect = "";
$doc_no = "";
$createdby = $_SESSION['user_mail'];
$date = date('Y-m-d');

if(isset($_POST)){
    $id = $conDB->sqlEscapestr($_POST['id']);
    $redirect = $conDB->sqlEscapestr($_POST['redirect']);
    $doc_no = $conDB->sqlEscapestr($_POST['doc_no']);
    $filename = $_FILES['file']['name'];
    $path = "../upload/files/images/" .$doc_no;
    
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    
    if($filename != ''){
        $extension = explode(".",$filename);
        $ext = $extension[count($extension) - 1];
        $newfilename = date('Ymdhis').".".$ext;
        $location = $path."/".$newfilename;
        if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) {
            $str = "UPDATE `documents_line_cont` SET `content` = '$location' WHERE `id` = '$id'";
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