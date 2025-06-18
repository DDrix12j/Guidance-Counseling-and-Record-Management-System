<?php
session_start();
if (isset($_SESSION['admin_id']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM quiz_categories WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: quiz-manage.php?success=Category deleted successfully");
        exit;
    } else {
        header("Location: quiz-manage.php?error=Category ID is required");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>