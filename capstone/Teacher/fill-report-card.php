<?php
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_GET['student_id'])) {
    include "../DB_connection.php";
    include "data/student.php";
    include "data/class.php";
    include "data/grade.php";
    include "data/section.php"; // <-- Add this line
    include "data/teacher.php";

    $student_id = $_GET['student_id'];
    $student = getStudentById($student_id, $conn);

    // Fetch class, grade, section, adviser, etc.
    $class = getClassById($student['class_id'], $conn);
    $grade = $class ? getGradeById($class['grade'], $conn) : null;
    $section = $class ? getSectioById($class['section'], $conn) : null;
    $adviser = $student['adviser'];

    // If "Download" button is clicked
    if (isset($_GET['download'])) {
        $spreadsheet = IOFactory::load(__DIR__ . '/DEPED-FORM-138-elem.xls');
        $sheet = $spreadsheet->getActiveSheet();

        // Fill up the template
        $sheet->setCellValue('B2', $student['fname'] . ' ' . $student['lname']); // Name
        $sheet->setCellValue('B3', $student['lrn']); // LRN
        $sheet->setCellValue('B4', $student['gender']); // Sex
        $sheet->setCellValue('B5', $grade['grade_code'].'-'.$grade['grade']); // Grade/Year
        $sheet->setCellValue('B6', $section['section']); // Section
        $sheet->setCellValue('B7', $adviser); // Adviser
        // ...add more as needed

        // Output for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Form138_'.$student['lname'].'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fill Report Card</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Student Report Card (Form 138)</h3>
    <?php if (isset($student)): ?>
        <table class="table">
            <tr><th>Name</th><td><?= htmlspecialchars($student['fname'] . ' ' . $student['lname']) ?></td></tr>
            <tr><th>LRN</th><td><?= htmlspecialchars($student['lrn']) ?></td></tr>
            <tr><th>Gender</th><td><?= htmlspecialchars($student['gender']) ?></td></tr>
            <tr><th>Grade/Year</th><td><?= htmlspecialchars($grade['grade_code'].'-'.$grade['grade']) ?></td></tr>
            <tr><th>Section</th><td><?= htmlspecialchars($section['section']) ?></td></tr>
            <tr><th>Adviser</th><td><?= htmlspecialchars($adviser) ?></td></tr>
        </table>
        <a href="?student_id=<?= urlencode($student_id) ?>&download=1" class="btn btn-success">
            Download Form 138 (Excel)
        </a>
    <?php else: ?>
        <div class="alert alert-danger">Student not found.</div>
    <?php endif; ?>
</div>
</body>
</html>