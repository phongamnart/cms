<?php
require 'vendor/autoload.php';

use Mpdf\Mpdf;

include("_check_session.php");
$conDB = new db_conn();

$get_id = $_GET['no'];
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
    if ($obj['date'] != "") {
        $date = date("d/m/Y", strtotime($obj['date']));
    }
}

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
            $encodedText = htmlspecialchars($objResult_content['content']);
            $encodedText = html_entity_decode($encodedText);
            $htmlContent .= '<div style="font-size: 20px;">' . $encodedText . '</div>';
        } elseif ($objResult_content['is_image'] == 1) {
            $imagePath = substr($objResult_content['content'], 3);
            $htmlContent .= '<div style="text-align: center;"><img src="' . $imagePath . '" style=" height: 420px;" alt="Image"></div>';
        } elseif ($objResult_content['is_image'] == 2) {
            $imagePath = substr($objResult_content['content'], 3);
            $htmlContent .= '<div style="text-align: center;"><img src="' . $imagePath . '" style=" height: 650px;" alt="Image"></div>';
            $htmlContent .= '<div style="page-break-after: always;"></div>';
        }
    }
}

$currentTime = date("YmdHis");
$randomNum = uniqid();

$mpdf = new Mpdf([
    'fontDir' => __DIR__ . '/fonts/',
    'fontdata' => [
        "browallianew" => [
            'R' => "browa.ttf",
            'I' => "BROWAI.TTF",
            'B' => "BROWAB.TTF",
            'BI' => "BROWAZ.TTF",
        ],
    ],
    'default_font' => 'browallianew',
    'margin_top' => 30
]);

$mpdf->SetHTMLHeader('
    <div>
    <table style="width: 100%;border: 1px solid #222222;"  border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td rowspan="2" style="padding: 5px;" align="center">
                <img src="dist/img/logo.svg" alt="logo" width="50">
            </td>
            <td colspan="2" align="left" style="padding: 5px;border-left: 1px solid #222222;font-size: 20px;">
                <b>Title : '.$method_statement.'</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;font-size: 20px;">
                <b>Page {PAGENO} of {nb}</b>
            </td>
        </tr>
        <tr>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px;">
                <b>Document No. : '.$doc_no.'</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px;">
                <b>Effective Date : '.$date.'</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px;">
                <b>Revision :</b>
            </td>
        </tr>
    </table>
    </div>
');

// $revisionTable = '
// <h2>Revision History</h2>
// <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
//     <tr style="background-color: #f2f2f2;">
//         <th style="border: 1px solid black; padding: 5px;">Rev.</th>
//         <th style="border: 1px solid black; padding: 5px;">'.$date.'</th>
//         <th style="border: 1px solid black; padding: 5px;">Revision Details</th>
//         <th style="border: 1px solid black; padding: 5px;">Prepared</th>
//         <th style="border: 1px solid black; padding: 5px;">Checked</th>
//         <th style="border: 1px solid black; padding: 5px;">Approved</th>
//     </tr>
//     <tr>
//         <td style="border: 1px solid black; padding: 5px;">0</td>
//         <td style="border: 1px solid black; padding: 5px;">29-03-2024</td>
//         <td style="border: 1px solid black; padding: 5px;">First Issuing</td>
//         <td style="border: 1px solid black; padding: 5px;">KITTIPONG</td>
//         <td style="border: 1px solid black; padding: 5px;">KITTIPONG</td>
//         <td style="border: 1px solid black; padding: 5px;">CHAIYOD</td>
//     </tr>
// </table>
// ';

// $mpdf->WriteHTML($revisionTable);
// $mpdf->AddPage();

$mpdf->WriteHTML($htmlContent);
$mpdf->Output('document.pdf', 'I');
?>
