<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

include("_check_session.php");
$conDB = new db_conn();

$get_id = $_GET['no'];

$strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name` FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`id` ASC";
$objQuery = $conDB->sqlQuery($strSQL);

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
$cellHCentered = array('alignment' => Jc::CENTER);

$table->addRow();
$table->addCell(Converter::cmToTwip(2), $cellRowSpan)->addImage('dist/img/icon/doc.png', array('width' => 50));
$table->addCell(Converter::cmToTwip(10), $cellColSpan)->addText('Title : Method Statement for HDPE Drainage Pipe Installation', array('bold' => true), $cellHCentered);
$table->addCell(Converter::cmToTwip(4), $cellStyle)->addPreserveText('Page {PAGE} of {NUMPAGES}', array(), $cellHCentered);

$table->addRow();
$table->addCell(null, $cellRowContinue);
$table->addCell(Converter::cmToTwip(5), $cellStyle)->addText('Document No. :', null, $cellHCentered);
$table->addCell(Converter::cmToTwip(5), $cellStyle)->addText('Effective Date :', null, $cellHCentered);
$table->addCell(Converter::cmToTwip(4), $cellStyle)->addText('Revision :', null, $cellHCentered);

$section->addTextBreak(1);

while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $name = htmlspecialchars_decode(strip_tags($objResult['name']));
    $name = str_replace('&nbsp;', ' ', $name);
    $encodedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $section->addText($objResult['id'] . ". " . $encodedName, array('bold' => true, 'size' => 10));

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
        }
    }
}

$currentTime = date("YmdHis");
$randomNum = uniqid();
$doc_file = 'test_upload/word/' . $currentTime . '_' . $randomNum . '.docx';
$phpWord->save($doc_file);

echo "<script>alert('Files saved successfully as " . basename($doc_file) . "'); window.close();</script>";
