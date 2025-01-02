<?php
include("_check_session.php");
$conDB = new db_conn();

$get_id = $_GET['no'];

$sql = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id'";
$result = $conDB->sqlQuery($sql);
while ($obj = mysqli_fetch_assoc($result)) {
    $doc_no = $obj['doc_no'];
    $method_statement = $obj['method_statement'];
}

$filePath = __DIR__ . '/upload/files/word/' . $doc_no . '/' . $doc_no . '_' . $method_statement . '.docx'; //path

// echo "Trying to download: " . $filePath . "<br>"; //debug

if (file_exists($filePath)) { //check file
    header('Content-Description: File Transfer'); //set header for file transfer
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //set header for file type
    header('Content-Disposition: attachment; filename="' . $doc_no . '_' . $method_statement . '.docx"'); //set header for file name
    header('Expires: 0'); //set header for not cache
    header('Cache-Control: must-revalidate');
    header('Pragma: public'); // set header for call everytime
    header('Content-Length: ' . filesize($filePath)); // set header for specifies the size of the file

    ob_clean(); //clear obj ก่อนส่งให้บราวเซอร์ download กันข้อมูลอื่นติดไปกับไฟล์
    flush();

    readfile($filePath);
    exit;
} else {
    echo "File not found: " . $filePath;
}
// } else {
//     echo "No file specified.";
// }
