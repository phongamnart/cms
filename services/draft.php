<?php
include("../_check_session.php");
$conDB = new db_conn();

$mail = $_SESSION['user_mail'];
$preparedby = $_SESSION['user_name'];
$doc_id = "";
$doc_id = $conDB->sqlEscapestr($_POST['doc_id']);
$id = "";
$id = $conDB->sqlEscapestr($_POST['id']);
$date = date('Y-m-d');

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

    $sql = "SELECT `doc_no` FROM `documents` WHERE `discipline`='$discipline' ORDER BY `id` DESC LIMIT 1";
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

$strSQL = "SELECT * FROM `request` WHERE md5(`request`.`id`) = '$id'";
$objQuery = $conDB->sqlQuery($strSQL);
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $name = $objResult['name'];
    $mail_req = $objResult['createdby'];
    $status_rev = $objResult['status_rev'];
}

//draft documents
$strSQL1 = "SELECT * FROM `documents` WHERE md5(`documents`.`id`) = '$doc_id'";
$objQuery = $conDB->sqlQuery($strSQL1);
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $discipline = $objResult['discipline'];
    $doc_no = generateDocNo($discipline, $conDB);
    $work = $objResult['work'];
    $type = $objResult['type'];
    $method_statement = $objResult['method_statement'];
    $remark = $objResult['remark'];
    $createdby = $objResult['createdby'];
    $checkedby = $objResult['checkedby'];
}

$strSQL2 = "INSERT INTO `documents` (`doc_no`, `discipline`, `work`, `type`, `method_statement`, `date`, `remark`, `preparedby`, `createdby`, `checkedby`, `approved`)
            VALUES ('$doc_no', '$discipline', '$work', '$type', '$method_statement', '$date', '$remark', '$name', '$mail_req', '$checkedby', 0)";
$conDB->sqlQuery($strSQL2);

//draft documents_line
$strSQL3 = "SELECT * FROM `documents` ORDER BY `id` DESC LIMIT 1";
$objQuery3 = $conDB->sqlQuery($strSQL3);
while ($objResult = mysqli_fetch_assoc($objQuery3)) {
    $last_doc_id = $objResult['id'];
}

$strSQL4 = "SELECT * FROM `documents_line` WHERE md5(`doc_id`) = '$doc_id'";
$objQuery4 = $conDB->sqlQuery($strSQL4);

while ($objResult = mysqli_fetch_assoc($objQuery4)) {
    $doc_id_line = $objResult['doc_id'];
    $content_id = $objResult['content_id'];
    $index_num = $objResult['index_num'];
    $createdby_line = $objResult['createdby'];
    $created = $objResult['created'];

    $strSQL6 = "INSERT INTO `documents_line` (`doc_id`, `content_id`, `index_num`, `createdby`, `created`, `enable`)
            VALUES ('$last_doc_id', '$content_id', '$index_num', '$mail_req', '$date', 1)";
    $conDB->sqlQuery($strSQL6);
}

//draft documents_line_cont

$strSQL7 = "SELECT `documents_line_cont`.*, `documents_line`.`content_id` FROM `documents_line_cont`
LEFT JOIN `documents_line` ON `documents_line`.`id` = `documents_line_cont`.`line_id` WHERE md5(`documents_line_cont`.`doc_id`) = '$doc_id'";
$objQuery7 = $conDB->sqlQuery($strSQL7);

while ($objResult = mysqli_fetch_assoc($objQuery7)) {
    $strSQL8 = "SELECT * FROM `documents_line` WHERE `content_id` = '" .$objResult['content_id']. "' AND `doc_id` = $last_doc_id";
    $objQuery8 = $conDB->sqlQuery($strSQL8);
    while ($objResult2 = mysqli_fetch_assoc($objQuery8)) {
        $line_id = $objResult2['id'];
    }
    $doc_id = $objResult['doc_id'];
    $is_image = $objResult['is_image'];
    $content = $objResult['content'];
    $createdby_cont = $objResult['createdby'];
    $created = $objResult['created'];
    $comment = $objResult['comment'];

    $strSQL9 = "INSERT INTO `documents_line_cont` (`line_id`, `doc_id`, `is_image`, `content`, `createdby`, `created`, `comment`, `enable`)
            VALUES ('$line_id', '$last_doc_id', '$is_image', '$content', '$mail_req', '$date', '$comment', 1)";
    $conDB->sqlQuery($strSQL9);
}
