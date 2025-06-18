<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../../DB_connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $grade_level = $_POST['grade_level'];
        $gender = $_POST['gender'];
        $section = $_POST['section'];
        $adviser = $_POST['adviser'];
        $schedule = $_POST['schedule'];
        $status = $_POST['status'];

        $sql = "INSERT INTO counseling_records (first_name, last_name, grade_level, gender, section, adviser, schedule, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$first_name, $last_name, $grade_level, $gender, $section, $adviser, $schedule, $status]);

        header("Location: ../counseling.php?success=Record added successfully");
        exit;
    } else {
        header("Location: ../counseling.php?error=Invalid request");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>