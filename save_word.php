<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

include("_check_session.php");
$conDB = new db_conn();

$get_id = $_GET['no'];

$strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name` FROM `documents_line` 
LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`id` ASC";
$objQuery = $conDB->sqlQuery($strSQL);

$strSQL2 = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id'";
$objQuery2 = $conDB->sqlQuery($strSQL2);
while ($objResult = mysqli_fetch_assoc($objQuery2)) {
    $method_statement = $objResult['method_statement'];
    $doc_no = $objResult['doc_no'];
    $date = $objResult['date'];
    $convertDate = strtotime($date);
    $newDate = date("d-m-Y", $convertDate);
    $checkedby = $objResult['checkedby'];
    $createdby = $objResult['createdby'];
}

$strSQL3 = "SELECT * FROM `approval` WHERE `mail` = '$checkedby'";
$objQuery3 = $conDB->sqlQuery($strSQL3);
while ($objResult = mysqli_fetch_assoc($objQuery3)) {
    $approval_name = $objResult['name'];
}

$phpWord = new PhpWord();
$section = $phpWord->addSection();

$phpWord->addFontStyle('myBrowalliaStyle', array('name' => 'Browallia New', 'size' => 14));

$header = $section->addHeader();
$tableStyle = array(
    'borderSize' => 6,
    'borderColor' => '000000',
    'cellMargin' => 80
);
$header->addTable($tableStyle);
$table = $header->addTable($tableStyle);

$cellRowSpan = array('vMerge' => 'restart', 'borderSize' => 6, 'borderColor' => '000000');
$cellRowContinue = array('vMerge' => 'continue', 'borderSize' => 6, 'borderColor' => '000000');
$cellColSpan = array('gridSpan' => 2, 'borderSize' => 6, 'borderColor' => '000000');
$cellStyle = array('valign' => 'center', 'borderSize' => 6, 'borderColor' => '000000');
$cellHCentered = array('alignment' => Jc::LEFT);

$table->addRow();
$table->addCell(Converter::cmToTwip(2), $cellRowSpan)->addImage('dist/img/icon/doc.png', array('width' => 50));
$table->addCell(Converter::cmToTwip(10), $cellColSpan)->addText('Title : ' . $method_statement, array('bold' => true), $cellHCentered);
$table->addCell(Converter::cmToTwip(4), $cellStyle)->addPreserveText('Page {PAGE} of {NUMPAGES}', array(), $cellHCentered);

$table->addRow();
$table->addCell(null, $cellRowContinue);
$table->addCell(Converter::cmToTwip(5), $cellStyle)->addText('Document No. :' . $doc_no, null, $cellHCentered);
$table->addCell(Converter::cmToTwip(5), $cellStyle)->addText('Effective Date :' . $newDate, null, $cellHCentered);
$table->addCell(Converter::cmToTwip(4), $cellStyle)->addText('Revision :', null, $cellHCentered);

$section->addTextBreak(1);
$index = 0;
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index++;
    $name = htmlspecialchars_decode(strip_tags($objResult['name']));
    $name = str_replace('&nbsp;', ' ', $name);
    $encodedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $section->addText($index . ". " . $encodedName, array('bold' => true, 'size' => 10));

    $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "'";
    $objQuery_line = $conDB->sqlQuery($strSQL2);

    while ($objResult_line = mysqli_fetch_assoc($objQuery_line)) {
        if ($objResult_line['is_image'] == 0) {
            $plainTextContent = htmlspecialchars_decode(strip_tags($objResult_line['content']));
            $plainTextContent = str_replace('&nbsp;', ' ', $plainTextContent);
            $encodedText = htmlspecialchars($plainTextContent, ENT_QUOTES, 'UTF-8');
            $section->addText($encodedText);
        } elseif ($objResult_line['is_image'] == 1) {
            $imagePath = substr($objResult_line['content'], 3);
            $section->addImage($imagePath, array('height' => 200, 'alignment' => Jc::CENTER));
        } elseif ($objResult_line['is_image'] == 2) {
            $imagePath = substr($objResult_line['content'], 3);
            $section->addImage($imagePath, array('height' => 700, 'alignment' => Jc::CENTER));
        }
    }
}

$upload_path = "upload/files/word/" . $doc_no;

if (!file_exists($upload_path)) {
    mkdir($upload_path, 0777, true);
}

$randomNum = uniqid();
$doc_file =  $upload_path . '/' . $doc_no . '.docx';
$phpWord->save($doc_file);

header("Location: documents.php");

?>
