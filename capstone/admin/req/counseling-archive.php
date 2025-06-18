<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../../DB_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE counseling_records SET is_archived = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        header("Location: ../counseling.php?success=Record archived successfully");
        exit;
    } else {
        header("Location: ../counseling.php?error=Invalid record ID");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>