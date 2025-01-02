<?php
require 'vendor/autoload.php';

use Mpdf\Mpdf;

include("_check_session.php");
$conDB = new db_conn();

function calculateTextWidth($text, $font, $fontSize)
{
    $bbox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = abs($bbox[2] - $bbox[0]);

    return $textWidth;
}

$get_id = $_GET['no'];
$date_checked = "";
$date_approved = "";
$sql = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id' LIMIT 1";
$result = $conDB->sqlQuery($sql);
while ($obj = mysqli_fetch_assoc($result)) {
    $doc_id = $obj['id'];
    $doc_no = $obj['doc_no'];
    $discipline = $obj['discipline'];
    $work = $obj['work'];
    $type = $obj['type'];
    $method_statement = $obj['method_statement'];
    $preparedby = $obj['preparedby'];
    $checkedby = $obj['checkedby'];
    $remark = $obj['remark'];
    $approved = $obj['approved'];

    if ($obj['date_prepared'] != "") {
        $date_prepared = date("d-m-Y", strtotime($obj['date_prepared']));
    }
    if ($obj['date_checked'] != "") {
        $date_checked = date("d-m-Y", strtotime($obj['date_checked']));
    }
    if ($obj['date_approved'] != "") {
        $date_approved = date("d-m-Y", strtotime($obj['date_approved']));
    }

    $timestamp_prepared = strtotime($date_prepared);
    $timestamp_checked = strtotime($date_checked);
    $timestamp_approved = strtotime($date_approved);
    $max_timestamp = max($timestamp_prepared, $timestamp_checked, $timestamp_approved);

    $newDate = date("d-m-Y", $max_timestamp);
}

$strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`page_no` FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`content_id` ASC";
$objQuery = $conDB->sqlQuery($strSQL);

$strSQL2 = "SELECT `approval`.`name` AS `check_name` FROM `documents` LEFT JOIN `approval` ON `documents`.`checkedby` = `approval`.`mail`
            WHERE `approval`.`mail` = '$checkedby' LIMIT 1";
$objQuery2 = $conDB->sqlQuery($strSQL2);
while ($objResult = mysqli_fetch_assoc($objQuery2)) {
    $check_name = $objResult['check_name'];
}

$strSQL_ct = "SELECT COUNT(*) AS count_ct FROM `documents_line` WHERE md5(`doc_id`) = '$get_id' AND `enable` = 1";
$objQuery_ct = $conDB->sqlQuery($strSQL_ct);
while ($objResult_ct = mysqli_fetch_assoc($objQuery_ct)) {
    $count_ct = $objResult_ct['count_ct'];
}

$htmlContent = '';
$index = 0;
$index_toc = 0;

$title_length = strlen($method_statement);
$font_size = 56;
$font = __DIR__ . '/fonts/browallia-new.ttf';
$textWidth = calculateTextWidth($method_statement, $font, $font_size);
$marginTop = 35;

if ($textWidth > 4500) {
    $font_size = 42;
    $TocMargin = ($count_ct <= 16 && $count_ct >= 7) ? 20 + (16 - $count_ct) * 30 : 20;
} elseif ($textWidth > 3600) {
    $font_size = 48;
    $TocMargin = ($count_ct <= 16 && $count_ct >= 7) ? 20 + (16 - $count_ct) * 30 : 20;
} elseif ($textWidth > 2800) {
    $font_size = 48;
    $TocMargin = ($count_ct <= 16 && $count_ct >= 7) ? 20 + (16 - $count_ct) * 30 : 20;
} elseif ($textWidth > 1700) {
    $font_size = 48;
    $TocMargin = ($count_ct <= 16 && $count_ct >= 7) ? 80 + (16 - $count_ct) * 30 : 80;
} elseif ($textWidth > 980) {
    $font_size = 50;
    $TocMargin = ($count_ct <= 16 && $count_ct >= 7) ? 140 + (16 - $count_ct) * 30 : 140;
} elseif ($textWidth < 980) {
    $font_size = 50;
    $TocMargin = ($count_ct <= 16 && $count_ct >= 7) ? 140 + (16 - $count_ct) * 30 : 140;
} else {
    $TocMargin = ($count_ct <= 16 && $count_ct >= 7) ? 20 + (16 - $count_ct) * 30 : 20;
}


if ($textWidth > 4500) {
    $marginTop = 50;
} elseif ($textWidth > 3600) {
    $marginTop = 45;
} elseif ($textWidth > 1700) {
    $marginTop = 40;
} elseif ($textWidth > 980) {
    $marginTop = 35;
}


$mpdf = new Mpdf([
    'fontDir' => __DIR__ . '/fonts/',
    'fontdata' => [
        "browallianew" => [
            'R' => "browallia-new.ttf",
            'I' => "browallia-new-italic.ttf",
            'B' => "browallia-new-bold.ttf",
        ],
    ],
    'default_font' => 'browallianew',
    'margin_top' => 30
]);

$watermarkText = 'Document No: ' . $doc_no . ' : ' . $method_statement;

$mpdf->SetWatermarkText($watermarkText);
$mpdf->showWatermarkText = true;
$mpdf->watermarkTextAlpha = 0.1;

// $mpdf->SetWatermarkImage('dist/img/ITE TH logo.png', 0.2, '', [100, 100]);
// $mpdf->showWatermarkImage = true;

//header หน้าแรก
$mpdf->SetHTMLHeader('
    <div>
    <table style="width: 100%;border: 1px solid #222222;"  border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td rowspan="2" style="padding: 5px;" align="center">
                <img src="dist/img/logo.svg" alt="logo" width="50">
            </td>
            <td colspan="2" align="left" style="padding: 5px;border-left: 1px solid #222222;font-size: 20px;width: 70%; white-space: nowrap;">
                <b>ITALTHAI ENGINEERING CO.,LTD</b>
            </td>
            <td rowspan="2" style="padding: 5px;border-left: 1px solid #222222;font-size: 20px; text-align: center; width: 20%;" valign="middle">
                <b>Page {PAGENO} of {nb}</b>
            </td>
        </tr>
        <tr>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px; width: 35%;">
                <b>Document No. : ' . $doc_no . '</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px; width: 35%;">
                <b>Effective Date : ' . $newDate . '</b>
            </td>
        </tr>
    </table>
    </div>
');

$tocHtml = '<br>';
$tocHtml .= '<div style="text-align: center; font-size: 56px;line-height: 1.0;">';
$tocHtml .= '<b>Method Statement For</b><br>';
$tocHtml .= '<b style="font-size:' . $font_size . 'px;">' . $method_statement . '</b><br>';
// $tocHtml .= '<b style="font-size:48px;">' . $textWidth . '</b><br>';
$tocHtml .= '</div>';

$tocHtml .= '<br>';
$tocHtml .= '<div style="margin-top: ' . $TocMargin . ';">';
// $tocHtml .= '<div style="margin-top: 140px;">';
$tocHtml .= '<b style="font-size: 24px;">Table of Contents</b>';
$tocHtml .= '<table style="width: 100%; font-size: 20px;">';

while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index_toc++;
    $tocHtml .= '<tr>';
    $tocHtml .= '<td style="width: 30%;">' . $index_toc . '. ' . $objResult['name'] . '</td>';
    $tocHtml .= '<td>' . str_repeat('.', 120) . '</td>';
    $tocHtml .= '<td style="text-align: right;">' . $objResult['page_no'] . '</td>';
    $tocHtml .= '</tr>';
}

$tocHtml .= '</table>';
$tocHtml .= '</div>';

$tocHtml .= '<div style="position: absolute; bottom: 30; width: 86%;">';
$tocHtml .= '<table style="width: 100%;border: 1px solid #222222; font-size: 18px;" border="0" cellpadding="0" cellspacing="0">';
$tocHtml .= '<tr>';
$tocHtml .= '<th style="border-right: 1px solid #222222;padding: 5px;">Prepared</th>';
$tocHtml .= '<th style="border-right: 1px solid #222222;padding: 5px;">Checked</th>';
$tocHtml .= '<th>Approved</th>';
$tocHtml .= '</tr>';
$tocHtml .= '<tr>';
$tocHtml .= '<td align="center" style="border-right: 1px solid #222222;border-top: 1px solid #222222;padding: 5px;">' . $preparedby . '</td>';
$tocHtml .= '<td align="center" style="border-right: 1px solid #222222;border-top: 1px solid #222222;padding: 5px;">' . $check_name . '</td>';
$tocHtml .= '<td align="center" style="border-top: 1px solid #222222;padding: 5px;">CHAIYOD WONGWAITAYAKORNKUL</td>';
$tocHtml .= '</tr>';
$tocHtml .= '<tr>';
$tocHtml .= '<td align="center" style="border-right: 1px solid #222222;border-top: 1px solid #222222;padding: 5px;">Date: ' . $date_prepared . '</td>';
$tocHtml .= '<td align="center" style="border-right: 1px solid #222222;border-top: 1px solid #222222;padding: 5px;">Date: ' . $date_checked . '</td>';
$tocHtml .= '<td align="center" style="border-top: 1px solid #222222;padding: 5px;">Date: ' . $date_approved . '</td>';
$tocHtml .= '</tr>';
$tocHtml .= '</table>';
$tocHtml .= '</div>';

$mpdf->AddPage();
$mpdf->WriteHTML($tocHtml);

$mpdf->SetMargins(10, 35, $marginTop);

// header หน้าอื่นๆ
$mpdf->SetHTMLHeader('
    <div>
    <table style="width: 100%;border: 1px solid #222222;"  border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td rowspan="2" style="padding: 5px;" align="center">
                <img src="dist/img/logo.svg" alt="logo" width="50">
            </td>
            <td colspan="2" align="left" style="padding: 5px;border-left: 1px solid #222222;font-size: 20px;width: 70%; white-space: nowrap; ">
                <b>Title: ' . $method_statement . '</b>
            </td>
            <td rowspan="2" style="padding: 5px;border-left: 1px solid #222222;font-size: 20px; text-align: center; width: 20%;" valign="middle">
                <b>Page {PAGENO} of {nb}</b>
            </td>
        </tr>
        <tr>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px; width: 35%;">
                <b>Document No. : ' . $doc_no . '</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px; width: 35%;">
                <b>Effective Date : ' . $newDate . '</b>
            </td>
        </tr>
    </table>
    </div>
');


mysqli_data_seek($objQuery, 0);

while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index++;
    if (stripos($objResult['name'], 'Appendix') !== false) {
        $htmlContent .= '<div style="page-break-before: always;"></div>';
    }

    $strSQL3 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "' AND `doc_id` = '$doc_id' ORDER BY `index_num` ASC";
    $objQuery_page_break = $conDB->sqlQuery($strSQL3);
    while ($objResult_page_break = mysqli_fetch_assoc($objQuery_page_break)) {
        $is_image = $objResult_page_break['is_image'];
    }

    $strSQL5 = "SELECT * FROM `documents_line_cont` WHERE `line_id` < '" . $objResult['id'] . "' AND `doc_id` = '$doc_id' ORDER BY `id` DESC LIMIT 1";
    $objQuery_prev = $conDB->sqlQuery($strSQL5);
    while ($objResult_prev = mysqli_fetch_assoc($objQuery_prev)) {
        $is_image_prev = $objResult_prev['is_image'];
    }

    if ($is_image == 2 || $is_image_prev == 2) {
        $htmlContent .= '<div style="page-break-after: always;"></div>';
    }

    $htmlContent .= '<div style="font-size: 20px;"><b>' . $index . ". " . $objResult['name'] . ' </b></div>';
    $strSQL4 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "' AND `doc_id` = '$doc_id' ORDER BY `index_num` ASC";
    $objQuery_line = $conDB->sqlQuery($strSQL4);
    while ($objResult_content = mysqli_fetch_assoc($objQuery_line)) {
        if ($objResult_content['is_image'] == 0) {
            $encodedText = htmlspecialchars($objResult_content['content']);
            $encodedText = html_entity_decode($encodedText);
            $htmlContent .= '<style>
                                table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                }
                                th, td {
                                    border: 1px solid #000;
                                    padding: 5px;
                                }
                            </style>';
            $htmlContent .= '<div style="font-size: 20px;">' . $encodedText . '</div>';
        } elseif ($objResult_content['is_image'] == 1) {
            $imagePath = substr($objResult_content['content'], 3);
            $htmlContent .= '<div style="text-align: center;"><br><img src="' . $imagePath . '" style=" height: 420px;" alt="Image"></div>';
        } elseif ($objResult_content['is_image'] == 2) {
            $imagePath = substr($objResult_content['content'], 3);
            $htmlContent .= '<div style="text-align: center;"><br><img src="' . $imagePath . '" style=" height: 850px;" alt="Image"></div>';
            // $htmlContent .= '<div style="page-break-after: always;"></div>';
        } elseif ($objResult_content['is_image'] == 3) {
            $htmlContent .= '<div style="page-break-after: always;"></div>';
        }
    }
}

$mpdf->AddPage();
$mpdf->WriteHTML($htmlContent);
$mpdf->Output('document.pdf', 'I');
?>