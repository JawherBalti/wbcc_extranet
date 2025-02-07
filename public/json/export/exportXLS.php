<?php


require '../../excelSheet/vendor/autoload.php';
require_once "../../../app/config/config.php";
require_once "../../../app/libraries/Utils.php";
require_once "../../../app/libraries/Database.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$htmlTable = $_POST['htmlTable'];
$fileNameExport = $_POST['fileName'];
// Fonction pour exporter une table HTML en fichier Excel
// function exportTableToExcel($htmlTable, $fileName)
// {
//     // Créer un nouvel objet Spreadsheet
//     $spreadsheet = new Spreadsheet();
//     $sheet = $spreadsheet->getActiveSheet();

//     // Charger la table HTML
//     $dom = new DOMDocument();
//     @$dom->loadHTML($htmlTable);

//     $rows = $dom->getElementsByTagName('tr');
//     $rowIndex = 1;
//     $colIndex = 1;
//     foreach ($rows as $key => $row) {
//         if ($key == 0) {
//             $cols = $row->getElementsByTagName('th');
//             // Gérer les en-têtes de colonne
//             if ($cols->length > 0) {
//                 $code = 65;

//                 foreach ($cols as $col) {
//                     $sheet->setCellValue(chr($code) . "$colIndex", iconv('UTF-8', 'windows-1252', $col->nodeValue));
//                     $code++;
//                 }
//             }
//         } else {
//             // Gérer les données des cellules
//             $cols = $row->getElementsByTagName('td');
//             $code = 65;
//             $colIndex++;

//             foreach ($cols as $col) {
//                 $sheet->setCellValue(chr($code) . "$colIndex", is_numeric($col->nodeValue) == 1 ? $col->nodeValue :  iconv('UTF-8', "ISO-8859-1//IGNORE", $col->nodeValue));
//                 $code++;
//             }
//         }
//         $rowIndex++;
//     }

//     // Écrire le fichier Excel
//     $writer = new Xlsx($spreadsheet);
//     $writer->save($fileName);

//     echo json_encode($fileName);
// }

function exportTableToExcel($htmlTable, $fileName)
{
    $uploadDir = '../../../public/documents/personnel/pointage/export/'; //  Goes up one directory and then into "exports".  Adjust as needed.

    // Create the directory if it doesn't exist.  This is crucial!
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // The 'true' makes it recursive.  Adjust permissions if needed.
    }

    $fullPath = $uploadDir . $fileName . ".xlsx"; // Add file extension

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $dom = new DOMDocument();
    @$dom->loadHTML($htmlTable);

    $rows = $dom->getElementsByTagName('tr');
    $colIndex = 1;
    foreach ($rows as $key => $row) {
        if ($key == 0) {
            $cols = $row->getElementsByTagName('th');
            // Gérer les en-têtes de colonne
            if ($cols->length > 0) {
                $code = 65;
                foreach ($cols as $col) {
                    $value = $col->nodeValue;
                    $convertedValue = mb_convert_encoding($value, 'Windows-1252', 'UTF-8'); // Convert safely
                    $sheet->setCellValue(chr($code) . "$colIndex", $convertedValue);
                    $code++;
                }
            }
        } else {
            // Gérer les données des cellules
            $cols = $row->getElementsByTagName('td');
            $code = 65;
            $colIndex++;
            foreach ($cols as $col) {
                $value = $col->nodeValue;
                $convertedValue = mb_convert_encoding($value, 'Windows-1252', 'UTF-8'); // Convert safely
                $sheet->setCellValue(chr($code) . "$colIndex", $convertedValue);
                $code++;
            }
        }
    }

    // Écrire le fichier Excel
    $writer = new Xlsx($spreadsheet);
    $writer->save($fullPath);  // Use the full path here

    echo json_encode($fullPath); // Return the full path.  This is important for your JS to work properly.
}

// Appeler la fonction d'exportation
exportTableToExcel($htmlTable, $fileNameExport . date('dmYhis') . '.xlsx');
