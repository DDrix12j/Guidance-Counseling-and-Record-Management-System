<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (isset($_POST['fname']) &&
            isset($_POST['lname']) &&
            isset($_POST['username']) &&
            isset($_POST['pass']) &&
            isset($_POST['address']) &&
            isset($_POST['employee_number']) &&
            isset($_POST['phone_number']) &&
            isset($_POST['qualification']) &&
            isset($_POST['email_address']) &&
            isset($_POST['classes']) &&
            isset($_POST['date_of_birth']) &&
            isset($_POST['subjects']) &&
            isset($_POST['position'])) { // Include position field

            include '../../DB_connection.php';
            include "../data/teacher.php";

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $uname = $_POST['username'];
            $pass = $_POST['pass'];
            $address = $_POST['address'];
            $employee_number = $_POST['employee_number'];
            $phone_number = $_POST['phone_number'];
            $qualification = $_POST['qualification'];
            $email_address = $_POST['email_address'];
            $gender = $_POST['gender'];
            $date_of_birth = $_POST['date_of_birth'];
            $position = $_POST['position']; // Capture position

            // Process classes and subjects
            $classes = implode(',', $_POST['classes']);
            $subjects = implode(',', $_POST['subjects']);

            $data = 'uname='.$uname.'&fname='.$fname.'&lname='.$lname.'&address='.$address.'&en='.$employee_number.'&pn='.$phone_number.'&qf='.$qualification.'&email='.$email_address;

            if (empty($fname)) {
                $em = "First name is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit;
            } else if (empty($lname)) {
                $em = "Last name is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit;
            } else if (empty($uname)) {
                $em = "Username is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit;
            } else if (!unameIsUnique($uname, $conn)) {
                $em = "Username is taken! Try another";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit;
            } else if (empty($pass)) {
                $em = "Password is required";
                header("Location: ../teacher-add.php?error=$em&$data");
                exit;
            } else {
                // Hash the password
                $pass = password_hash($pass, PASSWORD_DEFAULT);

                // Insert into the database
                $sql = "INSERT INTO teachers (username, password, class, fname, lname, subject, address, employee_number, date_of_birth, phone_number, qualification, gender, email_address, position)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$uname, $pass, $classes, $fname, $lname, $subjects, $address, $employee_number, $date_of_birth, $phone_number, $qualification, $gender, $email_address, $position]);

                $sm = "New teacher registered successfully";
                header("Location: ../teacher-add.php?success=$sm");
                exit;
            }
        } else {
            $em = "An error occurred";
            header("Location: ../teacher-add.php?error=$em");
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
