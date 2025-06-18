<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../../DB_connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $record_id = $_POST['record_id'];
        $details = $_POST['details'];

        // Validate inputs
        if (empty($record_id) || empty($details)) {
            header("Location: ../counseling-archive.php?error=All fields are required");
            exit;
        }

        // Update the record with additional details
        $sql = "UPDATE counseling_records SET additional_details = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$details, $record_id]);

        header("Location: ../counseling-archive.php?success=Details added successfully");
        exit;
    } else {
        header("Location: ../counseling-archive.php?error=Invalid request");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>