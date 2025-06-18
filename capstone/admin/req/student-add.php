<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (
            isset($_POST['fname']) &&
            isset($_POST['lname']) &&
            isset($_POST['lrn']) &&
            isset($_POST['guardian']) &&
            isset($_POST['address']) &&
            isset($_POST['birthday']) &&
            isset($_POST['birthplace']) &&
            isset($_POST['gender']) &&
            isset($_POST['grade']) &&
            isset($_POST['section']) &&
            isset($_POST['adviser']) &&
            isset($_POST['class_id'])
        ) {
            include '../../DB_connection.php';

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $lrn = $_POST['lrn'];
            $guardian = $_POST['guardian'];
            $address = $_POST['address'];
            $birthday = $_POST['birthday'];
            $birthplace = $_POST['birthplace'];
            $gender = $_POST['gender'];
            $grade = $_POST['grade'];
            $section = $_POST['section'];
            $adviser = $_POST['adviser'];
            $class_id = $_POST['class_id'];

            // Basic validation
            if (empty($fname) || empty($lname) || empty($lrn) || empty($guardian) || empty($address) || empty($birthday) || empty($birthplace) || empty($gender) || empty($grade) || empty($section) || empty($adviser)) {
                $em = "All fields are required";
                header("Location: ../student-add.php?error=$em");
                exit;
            }

            $sql = "INSERT INTO students (fname, lname, lrn, guardian, address, birthday, birthplace, gender, grade, section, adviser, class_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fname, $lname, $lrn, $guardian, $address, $birthday, $birthplace, $gender, $grade, $section, $adviser, $class_id]);

            $sm = "New student registered successfully";
            header("Location: ../student-add.php?success=$sm");
            exit;
        } else {
            $em = "An error occurred";
            header("Location: ../student-add.php?error=$em");
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
