<?php
// filepath: d:\aaaa\htdocs\capstonework\capstone\admin\req\question-delete.php
include "../../DB_connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the question
    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: ../question-manage.php?success=Question deleted successfully");
    exit;
} else {
    header("Location: ../question-manage.php?error=Question ID is required");
    exit;
}
?>