<?php
include "../../DB_connection.php";
include "../../data/quiz.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        addQuiz($conn, $title, $description);
        header("Location: ../quiz/manage-quiz.php?success=Quiz added successfully");
        exit;
    } else {
        $error = "All fields are required.";
        header("Location: ../quiz/quiz-add.php?error=$error");
        exit;
    }
}
?>