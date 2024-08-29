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

$strSQL = "SELECT `documents_line`.`id` AS `id`,`contents`.`name`, `documents_line`.`page_no` FROM `documents_line` LEFT JOIN `contents` ON `documents_line`.`content_id` = `contents`.`id` WHERE md5(`doc_id`) = '$get_id' AND `documents_line`.`enable` = 1 ORDER BY `documents_line`.`content_id` ASC";
$objQuery = $conDB->sqlQuery($strSQL);
$htmlContent = '';
$index = 0;
$index_toc = 0;

// $pageNumbers = [];

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
                <b>Title : ' . $method_statement . '</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;font-size: 20px;">
                <b>Page {PAGENO} of {nb}</b>
            </td>
        </tr>
        <tr>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px;">
                <b>Document No. : ' . $doc_no . '</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px;">
                <b>Effective Date : ' . $date . '</b>
            </td>
            <td align="left" style="padding: 5px;border-left: 1px solid #222222;border-top: 1px solid #222222;font-size: 20px;">
                <b>Revision :</b>
            </td>
        </tr>
    </table>
    </div>
');

$tocHtml = '<br>';
$tocHtml .= '<table style="width: 100%; border-collapse: collapse;">';
$tocHtml .= '<thead>';
$tocHtml .= '<tr>';
$tocHtml .= '<th style="border: 1px solid #000; padding: 10px; font-size: 20px; width: 10%;">Category</th>';
$tocHtml .= '<th style="border: 1px solid #000; padding: 10px; font-size: 20px; width: 70%;">Content</th>';
$tocHtml .= '<th style="border: 1px solid #000; padding: 10px; font-size: 20px; width: 10%;">Page</th>';
$tocHtml .= '</tr>';
$tocHtml .= '</thead>';
$tocHtml .= '<tbody>';

while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index_toc++;
    $tocHtml .= '<tr>';
    $tocHtml .= '<td style="border: 1px solid #000; padding: 10px; font-size: 20px; width: 10%; text-align: center;">' . $index_toc . '</td>';
    $tocHtml .= '<td style="border: 1px solid #000; padding: 10px; font-size: 20px; width: 80%;">' . $objResult['name'] . '</td>';
    $tocHtml .= '<td style="border: 1px solid #000; padding: 10px; font-size: 20px; width: 10%; text-align: center;">' . $objResult['page_no'] . '</td>';
    $tocHtml .= '</tr>';
}

$tocHtml .= '</tbody>';
$tocHtml .= '</table>';

$mpdf->AddPage();
$mpdf->WriteHTML($tocHtml);

mysqli_data_seek($objQuery, 0);

while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $index++;
    if (stripos($objResult['name'], 'Appendix') !== false) {
        $htmlContent .= '<div style="page-break-before: always;"></div>';
    }
    $htmlContent .= '<div style="font-size: 20px;"><b>' . $index . ". " . $objResult['name'] . ' </b></div>';
    $strSQL2 = "SELECT * FROM `documents_line_cont` WHERE `line_id` = '" . $objResult['id'] . "' ORDER BY `index_num` ASC";
    $objQuery_line = $conDB->sqlQuery($strSQL2);
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
            $htmlContent .= '<div style="text-align: center;"><img src="' . $imagePath . '" style=" height: 420px;" alt="Image"></div>';
        } elseif ($objResult_content['is_image'] == 2) {
            $imagePath = substr($objResult_content['content'], 3);
            $htmlContent .= '<div style="page-break-after: always;"></div>';
            $htmlContent .= '<div style="text-align: center;"><img src="' . $imagePath . '" style=" height: 950px;" alt="Image"></div>';
        } elseif ($objResult_content['is_image'] == 3) {
            $htmlContent .= '<div style="page-break-after: always;"></div>';
        }
    }
}

$mpdf->AddPage();
$mpdf->WriteHTML($htmlContent);
$mpdf->Output('document.pdf', 'I');
