<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['teacher_id'])) {

    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/teacher.php"; // Ensure this file is included

        $teacher_id = $_GET['teacher_id'];
        if (removeTeacher($teacher_id, $conn)) {
            header("Location: teacher.php?success=Teacher deleted successfully");
            exit;
        } else {
            header("Location: teacher.php?error=Failed to delete teacher");
            exit;
        }
    } else {
        header("Location: teacher.php");
        exit;
    }
} else {
    header("Location: teacher.php");
    exit;
}
?>