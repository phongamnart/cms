<?php
include("../_check_session.php");
$conDB = new db_conn();

function generateDocNo($discipline, $conDB)
{
    $prefix = '';
    switch ($discipline) {
        case 'Civil':
            $prefix = 'MS-CE-';
            break;
        case 'Electrical':
            $prefix = 'MS-EE-';
            break;
        case 'Mechanical':
            $prefix = 'MS-ME-';
            break;
    }

    $sql = "SELECT `doc_no` FROM `documents` WHERE `discipline`='$discipline' ORDER BY id DESC LIMIT 1";
    $result = $conDB->sqlQuery($sql);
    $latest_doc_no = mysqli_fetch_assoc($result);

    if ($latest_doc_no) {
        $last_number = (int)substr($latest_doc_no['doc_no'], strlen($prefix));
        $new_number = $last_number + 1;
    } else {
        $new_number = 1;
    }

    return $prefix . str_pad($new_number, 4, '0', STR_PAD_LEFT);
}

$prepared_by = $_SESSION['user_name'];
$discipline = isset($_POST['discipline']) ? $_POST['discipline'] : '';
$doc_no = generateDocNo($discipline, $conDB);
$work = isset($_POST['work']) ? $_POST['work'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$title = isset($_POST['document_title']) ? $_POST['document_title'] : '';
$checked_by = isset($_POST['checked_by']) ? $_POST['checked_by'] : '';
$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
$date = date('Y-m-d');

$strSQL2 = "INSERT INTO `documents` (`doc_no`, `discipline`, `work`, `type`, `method_statement`, `date`, `remark`, `prepared_by`, `checked_by`) 
            VALUES ('$doc_no', '$discipline', '$work', '$type', '$title', '$date', '$remark', '$prepared_by', '$checked_by')";
$conDB->sqlQuery($strSQL2);

header("Location: ../documents.php")
?>