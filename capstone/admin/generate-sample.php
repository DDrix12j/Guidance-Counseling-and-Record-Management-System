<?php
require 'vendor/autoload.php'; // Corrected path to autoload.php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add header row
$sheet->setCellValue('A1', 'LRN');
$sheet->setCellValue('B1', 'First Name');
$sheet->setCellValue('C1', 'Last Name');
$sheet->setCellValue('D1', 'Guardian');
$sheet->setCellValue('E1', 'Address');
$sheet->setCellValue('F1', 'Birthday');
$sheet->setCellValue('G1', 'Birthplace');
$sheet->setCellValue('H1', 'Gender');
$sheet->setCellValue('I1', 'Grade');
$sheet->setCellValue('J1', 'Class ID'); // <-- changed from Section to Class ID
$sheet->setCellValue('K1', 'Adviser');

// Add sample data
$data = [
    ['123456789', 'John', 'Doe', 'Jane Doe', '123 Main St', '2005-01-01', 'City A', 'Male', 'JH-7', 'JH-10 MAAPOY', 'Mr. Smith'], // '1' is a sample class_id
    ['987654321', 'Mary', 'Jane', 'Peter Parker', '456 Elm St', '2006-02-15', 'City B', 'Female', 'JH-7 ROSAS', '2', 'Ms. Johnson'],
    ['112233445', 'Harry', 'Potter', 'Lily Potter', '4 Privet Drive', '2004-07-31', 'City C', 'Male', 'SHS-RIZAL', '3', 'Mr. Dumbledore'],
];

$row = 2; // Start from the second row
foreach ($data as $student) {
    $sheet->fromArray($student, null, "A$row");
    $row++;
}

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="sample_students.xlsx"');
header('Cache-Control: max-age=0');

// Save the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>