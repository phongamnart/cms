<?php
require 'vendor/autoload.php';

use Mpdf\Mpdf;

include("_check_session.php");
$conDB = new db_conn();

$line_id = $_GET['line_id'];

$sql1 = "SELECT * FROM `documents_line_cont` WHERE md5(`line_id`) = '$line_id'";
$result = $conDB->sqlQuery($sql1);
$contents = [];
while ($objResult = mysqli_fetch_assoc($result)) {
    $contents[] = [
        'content' => $objResult['content'],
        'is_image' => $objResult['is_image']
    ];
}
$htmlContent = '';

foreach ($contents as $index => $content) {
    if ($content['is_image'] == 0) {
        $plainTextContent = htmlspecialchars_decode(strip_tags($content['content'])); // Decode HTML to text
        $plainTextContent = str_replace('&nbsp;', ' ', $plainTextContent); // Replace &nbsp; with space
        $encodedText = htmlspecialchars($plainTextContent, ENT_QUOTES, 'UTF-8'); // Encode special characters
        $htmlContent .= '<p>' . $encodedText . '</p>';
    } elseif ($content['is_image'] == 1) {
        $imagePath = substr($content['content'], 3);
        $htmlContent .= '<div style="text-align: center;"><img src="' . $imagePath . '" style="width: 200px; height: 200px;" alt="Image"></div>';
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
    'default_font' => 'thsarabunnew'
]);
$mpdf->WriteHTML($htmlContent);
// $pdf_file = 'test_upload/pdf/' . $currentTime . '_' . $randomNum . '.pdf';
$mpdf->Output('document.pdf', 'I');
?>