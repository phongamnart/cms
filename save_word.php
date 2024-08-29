<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;

include("_check_session.php");
$conDB = new db_conn();

$get_id = $_GET['no'];

$strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`page_no` FROM `documents_line` 
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
$phpWord->getSettings()->setThemeFontLang(new \PhpOffice\PhpWord\Style\Language('th-TH'));

$phpWord->setDefaultFontName('Browallia New');
$phpWord->setDefaultFontSize(15);

$section = $phpWord->addSection();

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
$table->addCell(Converter::cmToTwip(2), $cellRowSpan)->addImage('dist/img/ITE TH logo.png', array('width' => 50));
$table->addCell(Converter::cmToTwip(10), $cellColSpan)->addText('Title : ' . $method_statement, array('bold' => true, 'size' => 15), $cellHCentered);
$table->addCell(Converter::cmToTwip(4), $cellStyle)->addPreserveText('Page {PAGE} of {NUMPAGES}', array('bold' => true, 'size' => 15), $cellHCentered);

$table->addRow();
$table->addCell(null, $cellRowContinue);
$table->addCell(Converter::cmToTwip(5), $cellStyle)->addText('Document No. :' . $doc_no, array('bold' => true, 'size' => 15), $cellHCentered);
$table->addCell(Converter::cmToTwip(5), $cellStyle)->addText('Effective Date :' . $newDate, array('bold' => true, 'size' => 15), $cellHCentered);
$table->addCell(Converter::cmToTwip(4), $cellStyle)->addText('Revision :', array('bold' => true, 'size' => 15), $cellHCentered);

$header->addTextBreak(1);

$tocStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80);
$table = $section->addTable($tocStyle);

$headerCellStyle = array('valign' => 'center', 'alignment' => Jc::CENTER, 'borderSize' => 6, 'borderColor' => '000000');
$cellStyle = array('valign' => 'center', 'borderSize' => 6, 'borderColor' => '000000');
$cellHCentered = array('alignment' => Jc::CENTER);

// Header Row
$table->addRow();
$table->addCell(Converter::cmToTwip(2), $headerCellStyle)->addText('Category', array('bold' => true, 'size' => 12), $cellHCentered);
$table->addCell(Converter::cmToTwip(16), $headerCellStyle)->addText('Content', array('bold' => true, 'size' => 12), $cellHCentered);
$table->addCell(Converter::cmToTwip(2), $headerCellStyle)->addText('Page', array('bold' => true, 'size' => 12), $cellHCentered);

$index = 0;
$index_toc = 0;
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index_toc++;
    $name = htmlspecialchars_decode(strip_tags($objResult['name']));
    $name = str_replace('&nbsp;', ' ', $name);
    $encodedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    $table->addRow();
    $table->addCell(Converter::cmToTwip(2), $cellStyle)->addText($index_toc, array('size' => 12), $cellHCentered);
    $table->addCell(Converter::cmToTwip(16), $cellStyle)->addText($encodedName, array('size' => 12));
    $table->addCell(Converter::cmToTwip(2), $cellStyle)->addText($index_toc, array('size' => 12), $cellHCentered);
}
$section->addPageBreak();

$objQuery = $conDB->sqlQuery($strSQL);
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index++;
    $name = htmlspecialchars_decode(strip_tags($objResult['name']));
    $name = str_replace('&nbsp;', ' ', $name);
    $encodedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    if (stripos($name, 'Appendix') !== false) {
        $section->addPageBreak();
    }

    $section->addText($index . ". " . $encodedName, array('bold' => true, 'size' => 15), array('spaceAfter' => 0));

    $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "' ORDER BY `index_num` ASC";
    $objQuery_line = $conDB->sqlQuery($strSQL2);

    while ($objResult_line = mysqli_fetch_assoc($objQuery_line)) {
        if ($objResult_line['is_image'] == 0) {
            $htmlContent = $objResult_line['content'];
            parseHtmlToWord($phpWord, $section, $htmlContent);
        } elseif ($objResult_line['is_image'] == 1) {
            $imagePath = substr($objResult_line['content'], 3);
            $section->addImage($imagePath, array('width' => 420, 'alignment' => Jc::CENTER));
        } elseif ($objResult_line['is_image'] == 2) {
            $imagePath = substr($objResult_line['content'], 3);
            $section->addPageBreak();
            if (file_exists($imagePath)) {
                $imageInfo = getimagesize($imagePath);
                if ($imageInfo !== false) {
                    $width = $imageInfo[0];
                    $height = $imageInfo[1];
                    if ($width > 500) {
                        $section->addImage($imagePath, array('width' => 500, 'alignment' => Jc::CENTER));
                    } else {
                        $section->addImage($imagePath, array('height' => 950, 'alignment' => Jc::CENTER));
                    }
                }
            }
        } elseif ($objResult_line['is_image'] == 3) {
            $section->addPageBreak();
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

function parseHtmlToWord($phpWord, $section, $htmlContent)
{
    if (empty($htmlContent)) {
        $section->addText('', array('name' => 'Browallia New', 'size' => 15));
        return;
    }
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    foreach ($dom->getElementsByTagName('table') as $tableElement) {
        $tableStyle = array(
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50
        );
        $table = $section->addTable($tableStyle);
        foreach ($tableElement->getElementsByTagName('tr') as $row) {
            $tableRow = $table->addRow();
            foreach ($row->getElementsByTagName('td') as $cell) {
                $text = htmlspecialchars($cell->nodeValue);
                $cellWidth = Converter::cmToTwip(6);
                $cellStyle = array(
                    'valign' => 'center',
                    'borderSize' => 6,
                    'borderColor' => '000000',
                    'width' => $cellWidth,
                );
                $tableRow->addCell($cellWidth, $cellStyle)->addText($text, array('name' => 'Browallia New', 'size' => 15));
            }
        }
    }

    foreach ($dom->getElementsByTagName('p') as $paragraph) {
        $textrun = $section->addTextRun();
        foreach ($paragraph->childNodes as $node) {
            $text = htmlspecialchars($node->nodeValue);
            if ($node->nodeType === XML_TEXT_NODE) {
                $style = array('name' => 'Browallia New', 'size' => 15);
                $textrun->addText($text, $style);
            } elseif ($node->nodeName === 'span') {
                $style = array('name' => 'Browallia New', 'size' => 15);
                if ($node->hasAttribute('style')) {
                    if (strpos($node->getAttribute('style'), 'font-weight:bold') !== false) {
                        $style['bold'] = true;
                    }
                }
                $textrun->addText($text, $style);
            } elseif ($node->nodeName === 'strong') {

                $style = array('name' => 'Browallia New', 'size' => 15, 'bold' => true);
                $textrun->addText($text, $style);
            }
        }
    }
}
