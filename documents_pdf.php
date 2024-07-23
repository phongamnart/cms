<?php
require 'vendor/autoload.php';

use Mpdf\Mpdf;

include("_check_session.php");
$conDB = new db_conn();

$get_id = $_GET['no'];

$strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name` FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`content_id` ASC";
$objQuery = $conDB->sqlQuery($strSQL);
$htmlContent = '';
$index = 0;
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index++;
    $htmlContent .= '<div style="font-size: 20px;"><b>' . $index . ". " . $objResult['name'] . '</b></div>';
    $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "'";
    $objQuery_line = $conDB->sqlQuery($strSQL2);
    while ($objResult_content = mysqli_fetch_assoc($objQuery_line)) {
        if ($objResult_content['is_image'] == 0) {
            $encodedText = html_entity_decode($objResult_content['content']);
            $htmlContent .= '<div>' . $encodedText . '</div>';
        } elseif ($objResult_content['is_image'] == 1) {
            $imagePath = substr($objResult_content['content'], 3);
            $htmlContent .= '<div style="text-align: center;"><img src="' . $imagePath . '" style=" height: 200px;" alt="Image"></div>';
        } elseif ($objResult_content['is_image'] == 2) {
            $imagePath = substr($objResult_content['content'], 3);
            $htmlContent .= '<div style="text-align: center;"><img src="' . $imagePath . '" style=" height: 700px;" alt="Image"></div>';
        }
    }
}

$currentTime = date("YmdHis");
$randomNum = uniqid();

$mpdf = new Mpdf([
    'fontDir' => __DIR__ . '/fonts/',
    'fontdata' => [
        "thsarabunnew" => [
            'R' => "THSarabunNew.ttf",
            'I' => "THSarabunNew Italic.ttf",
            'B' => "THSarabunNew Bold.ttf",
            'BI' => "THSarabunNew BoldItalic.ttf",
        ],
    ],
    'default_font' => 'thsarabunnew',
    'margin_top' => 30
]);
$mpdf->SetHTMLHeader('
    <div>
    <table style="width: 100%";>
        <tr>
            <th rowspan="2" style="border: 1px solid black">
                <img src="dist/img/logo.svg" alt="logo" width="50">
            </th>
            <th colspan="2" style="border: 1px solid black">
                Title :
            </th>
            <th style="border: 1px solid black">
                Page {PAGENO} of {nb}
            </th>
        </tr>
        <tr>
            <th style="border: 1px solid black">
                Document No. : <span class="underline"></span>
            </th>
            <th style="border: 1px solid black">
                Effective Date : <span class="underline"></span>
            </th>
            <th style="border: 1px solid black">
                Revision : <span class="underline"></span>
            </th>
        </tr>
    </table>
    </div>
');
$mpdf->WriteHTML($htmlContent);
$mpdf->Output('document.pdf', 'I');
