<?php
include "../../DB_connection.php";
include "../../data/quiz.php";

if (isset($_GET['id'])) {
    deleteQuiz($conn, $_GET['id']);
    header("Location: manage-quiz.php?success=Quiz deleted successfully");
    exit;
} else {
    header("Location: manage-quiz.php?error=Quiz ID is required");
    exit;
}
?>