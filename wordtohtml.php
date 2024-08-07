<?php
include("_check_session.php");
$conDB = new db_conn();

require 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Text;

include_once('_head.php');

$get_id = $_GET['no'];
$sql = "SELECT * FROM `documents` WHERE md5(`id`) = '$get_id'";
$objQuery = $conDB->sqlQuery($sql);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $path = $objResult['importfile'];
    }

$filePath = substr($path, 3);

$phpWord = IOFactory::load($filePath);

$htmlContent = '';

foreach ($phpWord->getSections() as $section) {
    foreach ($section->getElements() as $element) {
        if ($element instanceof TextRun) {
            foreach ($element->getElements() as $text) {
                if ($text instanceof Text) {
                    $content = $text->getText();
                    $style = $text->getFontStyle();
                    
                    if ($style->isBold()) {
                        $content = "<strong>$content</strong>";
                    }
                    if ($style->isItalic()) {
                        $content = "<em>$content</em>";
                    }
                    if ($style->getUnderline() != 'none') {
                        $content = "<u>$content</u>";
                    }
                    
                    $htmlContent .= $content;
                }
            }
            $htmlContent .= '<br>';
        }
    }
}

echo '<div style="padding: 20px;">' . $htmlContent . '</div>';

?>
