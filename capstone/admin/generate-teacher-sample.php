<?php
require 'vendor/autoload.php'; // Ensure PhpSpreadsheet is loaded
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection
include '../DB_connection.php';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add header row
$sheet->setCellValue('A1', 'First Name');
$sheet->setCellValue('B1', 'Last Name');
$sheet->setCellValue('C1', 'Username');
$sheet->setCellValue('D1', 'Email');
$sheet->setCellValue('E1', 'Phone Number');
$sheet->setCellValue('F1', 'Position');
$sheet->setCellValue('G1', 'Address');
$sheet->setCellValue('H1', 'Employee Number');
$sheet->setCellValue('I1', 'Date of Birth');
$sheet->setCellValue('J1', 'Qualification');
$sheet->setCellValue('K1', 'Gender');
$sheet->setCellValue('L1', 'Subject (IDs)'); // Include subject IDs
$sheet->setCellValue('M1', 'Class (IDs)');

// Fetch existing subjects from the database
$sql = "SELECT subject_id, subject FROM subjects";
$stmt = $conn->prepare($sql);
$stmt->execute();
$subjects = $stmt->fetchAll();

// Add a note about available subjects
$sheet->setCellValue('A3', 'Available Subjects:');
$row = 4; // Start listing subjects from row 4
foreach ($subjects as $subject) {
    $sheet->setCellValue("A$row", $subject['subject_id'] . ' - ' . $subject['subject']);
    $row++;
}

// Add sample data
$row += 2; // Leave a gap after the subjects list
$sheet->setCellValue("A$row", 'Sample Data:');
$row++;
$data = [
    ['John', 'Doe', 'johndoe', 'john.doe@example.com', '1234567890', 'Math Teacher', '123 Main St', 'EMP001', '1990-01-01', 'BSc', 'Male', '1,2', '101,102'],
    ['Jane', 'Smith', 'janesmith', 'jane.smith@example.com', '0987654321', 'Science Teacher', '456 Elm St', 'EMP002', '1992-02-02', 'MSc', 'Female', '3,4', '103,104'],
];
foreach ($data as $teacher) {
    $sheet->fromArray($teacher, null, "A$row");
    $row++;
}

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="sample_teachers.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

