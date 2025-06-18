<?php
session_start();
require '../../vendor/autoload.php'; // Ensure PhpSpreadsheet is loaded
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (isset($_FILES['teacher_file']) && $_FILES['teacher_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['teacher_file']['tmp_name'];
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Skip the header row
            unset($rows[0]);

            include '../../DB_connection.php';

            foreach ($rows as $row) {
                $fname = $row[0];
                $lname = $row[1];
                $uname = $row[2];
                $email = $row[3];
                $phone_number = $row[4];
                $position = $row[5];
                $address = $row[6];
                $employee_number = $row[7];
                $date_of_birth = $row[8];
                $qualification = $row[9];
                $gender = $row[10];
                $subject = $row[11]; // Comma-separated subject IDs
                $classes = $row[12];  // Comma-separated class IDs

                // Validate required fields
                if (empty($fname) || empty($lname) || empty($uname) || empty($email)) {
                    $error_message = "Error: Missing required fields in the uploaded file. Please ensure all rows have First Name, Last Name, Username, and Email.";
                    header("Location: ../teacher-upload.php?error=" . urlencode($error_message));
                    exit;
                }

                // Insert into the database
                $sql = "INSERT INTO teachers (fname, lname, username, email_address, phone_number, position, address, employee_number, date_of_birth, qualification, gender, subject, class)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$fname, $lname, $uname, $email, $phone_number, $position, $address, $employee_number, $date_of_birth, $qualification, $gender, $subject, $classes]);
            }

            header("Location: ../teacher-upload.php?success=Teachers uploaded successfully");
            exit;
        } else {
            header("Location: ../teacher-upload.php?error=Error uploading file");
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