<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../../DB_connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $record_id = $_POST['record_id'];

        // Validate input
        if (empty($record_id) || !is_numeric($record_id)) {
            header("Location: ../counseling-archive.php?error=Invalid record ID");
            exit;
        }

        // Check if the record exists
        $checkSql = "SELECT id FROM counseling_records WHERE id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->execute([$record_id]);

        if ($checkStmt->rowCount() === 0) {
            header("Location: ../counseling-archive.php?error=Record not found");
            exit;
        }

        // Restore the record
        $sql = "UPDATE counseling_records SET is_archived = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$record_id]);

        header("Location: ../counseling-archive.php?success=Record restored successfully");
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