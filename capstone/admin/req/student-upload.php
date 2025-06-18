<?php
session_start();
require '../../vendor/autoload.php'; // Ensure this is correct
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (isset($_FILES['student_file'])) {
            include '../../DB_connection.php';

            $file = $_FILES['student_file'];
            $fileTmpName = $file['tmp_name'];
            $fileError = $file['error'];

            if ($fileError === 0) {
                $spreadsheet = IOFactory::load($fileTmpName);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                // Skip the header row and process the data
                foreach ($rows as $index => $row) {
                    if ($index === 0) continue; // Skip header row

                    // Map the columns to the database fields
                    $lrn = !empty($row[0]) ? $row[0] : null;
                    $fname = !empty($row[1]) ? $row[1] : null;
                    $lname = !empty($row[2]) ? $row[2] : null;
                    $guardian = !empty($row[3]) ? $row[3] : null;
                    $address = !empty($row[4]) ? $row[4] : null;
                    $birthday = !empty($row[5]) ? $row[5] : null;
                    $birthplace = !empty($row[6]) ? $row[6] : null;
                    $gender = !empty($row[7]) ? $row[7] : null;
                    $grade = !empty($row[8]) ? $row[8] : null;
                    $class_id = !empty($row[9]) ? $row[9] : null; // <-- changed from section to class_id
                    $adviser = !empty($row[10]) ? $row[10] : null;

                    // Insert into the database
                    $sql = "INSERT INTO students (lrn, fname, lname, guardian, address, birthday, birthplace, gender, grade, class_id, adviser)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$lrn, $fname, $lname, $guardian, $address, $birthday, $birthplace, $gender, $grade, $class_id, $adviser]);
                }

                header("Location: ../student-upload.php?success=Students uploaded successfully");
                exit;
            } else {
                header("Location: ../student-upload.php?error=Error uploading file");
                exit;
            }
        } else {
            header("Location: ../student-upload.php?error=No file uploaded");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>