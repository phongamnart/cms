<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Shared\Html;

include("_check_session.php");
$conDB = new db_conn();

$get_id = $_GET['no'];

function calculateTextWidth($text, $font, $fontSize)
{
    $bbox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = abs($bbox[2] - $bbox[0]);

    return $textWidth;
}

$strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`page_no` FROM `documents_line` 
LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`content_id` ASC";
$objQuery = $conDB->sqlQuery($strSQL);

$strSQL2 = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id'";
$objQuery2 = $conDB->sqlQuery($strSQL2);
while ($objResult = mysqli_fetch_assoc($objQuery2)) {
    $method_statement = $objResult['method_statement'];
    $doc_no = $objResult['doc_no'];
    $convertDate = strtotime($date_prepared);
    $newDate = date("d-m-Y", $convertDate);
    $checkedby = $objResult['checkedby'];
    $createdby = $objResult['createdby'];
    $preparedby = $objResult['preparedby'];

    if ($objResult['date_prepared'] != "") {
        $date_prepared = date("d-m-Y", strtotime($objResult['date_prepared']));
    }
    if ($objResult['date_checked'] != "") {
        $date_checked = date("d-m-Y", strtotime($objResult['date_checked']));
    }
    if ($objResult['date_approved'] != "") {
        $date_approved = date("d-m-Y", strtotime($objResult['date_approved']));
    }

    $timestamp_prepared = strtotime($date_prepared);
    $timestamp_checked = strtotime($date_checked);
    $timestamp_approved = strtotime($date_approved);
    $max_timestamp = max($timestamp_prepared, $timestamp_checked, $timestamp_approved);

    $newDate = date("d-m-Y", $max_timestamp);
}

$strSQL4 = "SELECT `approval`.`name` AS `check_name` FROM `documents` LEFT JOIN `approval` ON `documents`.`checkedby` = `approval`.`mail`
            WHERE `approval`.`mail` = '$checkedby' LIMIT 1";
$objQuery4 = $conDB->sqlQuery($strSQL4);
while ($objResult = mysqli_fetch_assoc($objQuery4)) {
    $check_name = $objResult['check_name'];
}

$strSQL3 = "SELECT * FROM `approval` WHERE `mail` = '$checkedby'";
$objQuery3 = $conDB->sqlQuery($strSQL3);
while ($objResult = mysqli_fetch_assoc($objQuery3)) {
    $approval_name = $objResult['name'];
}

$strSQL_ct = "SELECT COUNT(*) AS count_ct FROM `documents_line` WHERE md5(`doc_id`) = '$get_id' AND `enable` = 1";
$objQuery_ct = $conDB->sqlQuery($strSQL_ct);
while ($objResult_ct = mysqli_fetch_assoc($objQuery_ct)) {
    $count_ct = $objResult_ct['count_ct'];
}

$phpWord = new PhpWord();
$phpWord->getSettings()->setThemeFontLang(new \PhpOffice\PhpWord\Style\Language('th-TH'));

$phpWord->setDefaultFontName('Browallia New');
$phpWord->setDefaultFontSize(15);

//ปก
$coverSection = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(2),
    'marginBottom' => 0,
    'marginLeft' => Converter::cmToTwip(2),
    'marginRight' => Converter::cmToTwip(2),
]);
$header = $coverSection->addHeader();
$tableStyle = array(
    'borderSize' => 6,
    'borderColor' => '000000',
    'cellMargin' => 60,
);
$header->addTable($tableStyle);
$table = $header->addTable($tableStyle);

$cellRowSpan = array('vMerge' => 'restart', 'borderSize' => 6, 'borderColor' => '000000');
$cellRowContinue = array('vMerge' => 'continue', 'borderSize' => 6, 'borderColor' => '000000');
$cellColSpan = array('gridSpan' => 2, 'borderSize' => 6, 'borderColor' => '000000');
$cellStyle = array('valign' => 'center', 'borderSize' => 6, 'borderColor' => '000000');
$cellHCenteredHead = array('alignment' => Jc::LEFT, 'valign' => 'center');
$cellHCentered = array('alignment' => Jc::CENTER);
$headerCellStyle = array('valign' => 'center', 'alignment' => Jc::CENTER, 'borderSize' => 6, 'borderColor' => '000000');

//header
$table->addRow();
$table->addCell(Converter::cmToTwip(3), $cellRowSpan)->addImage('dist/img/ITE TH logo.png', array('width' => 50, 'alignment' => Jc::CENTER));
$table->addCell(Converter::cmToTwip(13.5), $cellColSpan)->addText('ITALTHAI ENGINEERING CO.,LTD', array('bold' => true, 'size' => 15), $cellHCenteredHead);
$table->addCell(Converter::cmToTwip(4), $cellRowSpan)->addPreserveText('Page {PAGE} of {NUMPAGES}', array('bold' => true, 'size' => 15), $cellHCentered);

$table->addRow();
$table->addCell(null, $cellRowContinue);
$table->addCell(Converter::cmToTwip(7.75), $cellStyle)->addText('Document No. :' . $doc_no, array('bold' => true, 'size' => 15), $cellHCentered);
$table->addCell(Converter::cmToTwip(7.75), $cellStyle)->addText('Effective Date :' . $newDate, array('bold' => true, 'size' => 15), $cellHCentered);
$table->addCell(null, $cellRowContinue);

// $coverSection->addTextBreak(1);

$title_length = strlen($method_statement);
$font_size = 32;
$font = __DIR__ . '/fonts/browallia-new.ttf';
$textWidth = calculateTextWidth($method_statement, $font, $font_size);

if ($textWidth > 2000) {
    $font_size = 28;
}

$coverSection->addText('Method Statement For', array('bold' => true, 'size' => 32), array('alignment' => Jc::CENTER, 'spaceAfter' => 50, 'lineHeight' => 0.8));
$coverSection->addText($method_statement, array('bold' => true, 'size' => $font_size), array('alignment' => Jc::CENTER, 'spaceAfter' => 50, 'lineHeight' => 0.8));
// $coverSection->addText($textWidth, array('bold' => true, 'size' => $font_size), array('alignment' => Jc::CENTER, 'spaceAfter' => 50, 'lineHeight' => 0.8));

// $coverSection->addTextBreak(0);
if ($textWidth > 2000 && $count_ct >= 7 && $count_ct <= 16) {
    $breaks = max(0, 16 - $count_ct - 1);
    $coverSection->addTextBreak($breaks);
} elseif ($textWidth > 1000 && $count_ct >= 7 && $count_ct <= 16) {
    $breaks = max(0, 16 - $count_ct);
    $coverSection->addTextBreak($breaks);
} elseif ($textWidth > 570 && $count_ct >= 7 && $count_ct <= 16) {
    $breaks = max(0, 16 - $count_ct + 1);
    $coverSection->addTextBreak($breaks);
}

// $coverSection->addText($breaks, array('bold' => true, 'size' => $font_size), array('alignment' => Jc::CENTER, 'spaceAfter' => 50, 'lineHeight' => 0.8));

$coverSection->addText('Table of Contents', array('bold' => true, 'size' => 16), array('alignment' => Jc::LEFT));

$table = $coverSection->addTable(array('cellMargin' => 0, 'spaceAfter' => 50));
$index_toc = 0;
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index_toc++;
    $name = htmlspecialchars_decode(strip_tags($objResult['name']));
    $name = str_replace('&nbsp;', ' ', $name);
    $encodedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    $table->addRow();
    $table->addCell(Converter::cmToTwip(6))->addText($index_toc . '.' . $encodedName, array('size' => 15));
    $table->addCell(Converter::cmToTwip(14))->addText(str_repeat('.', 120), array('size' => 10), $cellHCentered);
    $table->addCell(Converter::cmToTwip(1.5))->addText($objResult['page_no'], array('size' => 15), $cellHCentered);
}
$coverSection->addTextBreak(1); //dont delete

$table = $coverSection->addTable($tableStyle);
$table->addRow(Converter::cmToTwip(0.6));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText('Prepared', array('bold' => true, 'size' => 15), array_merge($cellHCentered, ['spaceAfter' => 0]));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText('Checked', array('bold' => true, 'size' => 15), array_merge($cellHCentered, ['spaceAfter' => 0]));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText('Approved', array('bold' => true, 'size' => 15), array_merge($cellHCentered, ['spaceAfter' => 0]));

$table->addRow(Converter::cmToTwip(0.6));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText($preparedby, array('size' => 12), array_merge($cellHCentered, ['spaceAfter' => 0]));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText($check_name, array('size' => 12), array_merge($cellHCentered, ['spaceAfter' => 0]));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText('CHAIYOD WONGWAITAYAKORNKUL', array('size' => 12), array_merge($cellHCentered, ['spaceAfter' => 0]));

$table->addRow(Converter::cmToTwip(0.6));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText('Date: ' . $date_prepared, array('size' => 12), array_merge($cellHCentered, ['spaceAfter' => 0]));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText('Date: ' . $date_checked, array('size' => 12), array_merge($cellHCentered, ['spaceAfter' => 0]));
$table->addCell(Converter::cmToTwip(7), $cellColSpan)->addText('Date: ' . $date_approved, array('size' => 12), array_merge($cellHCentered, ['spaceAfter' => 0]));


$coverSection->addPageBreak();
$section = $phpWord->addSection([
    'marginTop' => Converter::cmToTwip(2),
    'marginBottom' => Converter::cmToTwip(2),
    'marginLeft' => Converter::cmToTwip(2),
    'marginRight' => Converter::cmToTwip(2),
]);

$header = $section->addHeader();
$tableStyle = array(
    'borderSize' => 6,
    'borderColor' => '000000',
    'cellMargin' => 60
);
$header->addTable($tableStyle);
$table = $header->addTable($tableStyle);

$cellRowSpan = array('vMerge' => 'restart', 'borderSize' => 6, 'borderColor' => '000000');
$cellRowContinue = array('vMerge' => 'continue', 'borderSize' => 6, 'borderColor' => '000000');
$cellColSpan = array('gridSpan' => 2, 'borderSize' => 6, 'borderColor' => '000000');
$cellStyle = array('valign' => 'center', 'borderSize' => 6, 'borderColor' => '000000');
$cellHCenteredHead = array('alignment' => Jc::LEFT, 'valign' => 'center');
$cellHCentered = array('alignment' => Jc::CENTER);
$headerCellStyle = array('valign' => 'center', 'alignment' => Jc::CENTER, 'borderSize' => 6, 'borderColor' => '000000');

//header
$table->addRow();
$table->addCell(Converter::cmToTwip(3), $cellRowSpan)->addImage('dist/img/ITE TH logo.png', array('width' => 50, 'alignment' => Jc::CENTER));
$table->addCell(Converter::cmToTwip(13.5), $cellColSpan)->addText('Title : ' . $method_statement, array('bold' => true, 'size' => 15), $cellHCenteredHead);
$table->addCell(Converter::cmToTwip(4), $cellRowSpan)->addPreserveText('Page {PAGE} of {NUMPAGES}', array('bold' => true, 'size' => 15), $cellHCentered);

$table->addRow();
$table->addCell(null, $cellRowContinue);
$table->addCell(Converter::cmToTwip(7.75), $cellStyle)->addText('Document No. :' . $doc_no, array('bold' => true, 'size' => 15), $cellHCentered);
$table->addCell(Converter::cmToTwip(7.75), $cellStyle)->addText('Effective Date :' . $newDate, array('bold' => true, 'size' => 15), $cellHCentered);
$table->addCell(null, $cellRowContinue);

// $section->addTextBreak(1);

//content
$objQuery = $conDB->sqlQuery($strSQL);
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index++;
    $name = htmlspecialchars_decode(strip_tags($objResult['name']));
    $name = str_replace('&nbsp;', ' ', $name);
    $encodedName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    if (stripos($name, 'Appendix') !== false) {
        $section->addPageBreak();
        // $section->addTextBreak(1);
    }

    $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "' AND md5(`doc_id`) = '$get_id' ORDER BY `index_num` ASC";
    $objQuery_page_break = $conDB->sqlQuery($strSQL2);
    while ($objResult_page_break = mysqli_fetch_assoc($objQuery_page_break)) {
        $is_image = $objResult_page_break['is_image'];
    }

    // if($is_image == 2){
    //     $section->addPageBreak();
    // }

    $section->addText($index . ". " . $encodedName, array('bold' => true, 'size' => 15), array('spaceAfter' => 0));

    $strSQL3 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "' AND md5(`doc_id`) = '$get_id' ORDER BY `index_num` ASC";
    $objQuery_line = $conDB->sqlQuery($strSQL3);

    while ($objResult_line = mysqli_fetch_assoc($objQuery_line)) {
        if ($objResult_line['is_image'] == 0) {
            $htmlContent = $objResult_line['content'];
            Html::addHtml($section, $htmlContent, false, false);
            // parseHtmlToWord($phpWord, $section, $htmlContent);
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
                        $section->addImage($imagePath, array('width' => 500, 'height' => 650, 'alignment' => Jc::CENTER));
                    } else {
                        $section->addImage($imagePath, array('height' => 650, 'alignment' => Jc::CENTER));
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
$doc_file =  $upload_path . '/' . $doc_no . '_' . $method_statement . '.docx';
$phpWord->save($doc_file);

header("Location: documents.php");

// function parseHtmlToWord($phpWord, $section, $htmlContent)
// {
//     if (empty($htmlContent)) {
//         $section->addText('', array('name' => 'Browallia New', 'size' => 15));
//         return;
//     }
//     $dom = new DOMDocument();
//     @$dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

//     foreach ($dom->getElementsByTagName('table') as $tableElement) {
//         $tableStyle = array(
//             'borderSize' => 6,
//             'borderColor' => '000000',
//             'cellMargin' => 50
//         );
//         $table = $section->addTable($tableStyle);
//         foreach ($tableElement->getElementsByTagName('tr') as $row) {
//             $tableRow = $table->addRow();
//             foreach ($row->getElementsByTagName('td') as $cell) {
//                 $text = htmlspecialchars($cell->nodeValue);
//                 $cellWidth = Converter::cmToTwip(6);
//                 $cellStyle = array(
//                     'valign' => 'center',
//                     'borderSize' => 6,
//                     'borderColor' => '000000',
//                     'width' => $cellWidth,
//                 );
//                 $tableRow->addCell($cellWidth, $cellStyle)->addText($text, array('name' => 'Browallia New', 'size' => 15));
//             }
//         }
//     }

//     foreach ($dom->getElementsByTagName('p') as $paragraph) {
//         $textrun = $section->addTextRun();
//         foreach ($paragraph->childNodes as $node) {
//             $text = htmlspecialchars($node->nodeValue);
//             if ($node->nodeType === XML_TEXT_NODE) {
//                 $style = array('name' => 'Browallia New', 'size' => 15);
//                 $textrun->addText($text, $style);
//             } elseif ($node->nodeName === 'span') {
//                 $style = array('name' => 'Browallia New', 'size' => 15);
//                 if ($node->hasAttribute('style')) {
//                     if (strpos($node->getAttribute('style'), 'font-weight:bold') !== false) {
//                         $style['bold'] = true;
//                     }
//                 }
//                 $textrun->addText($text, $style);
//             } elseif ($node->nodeName === 'strong') {

//                 $style = array('name' => 'Browallia New', 'size' => 15, 'bold' => true);
//                 $textrun->addText($text, $style);
//             }
//         }
//     }
// }
