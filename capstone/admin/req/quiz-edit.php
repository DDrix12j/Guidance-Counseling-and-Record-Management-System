<?php
include "../../DB_connection.php";
include "../../data/quiz.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title) && !empty($description)) {
        updateQuiz($conn, $id, $title, $description);
        header("Location: ../quiz/manage-quiz.php?success=Quiz updated successfully");
        exit;
    } else {
        $error = "All fields are required.";
        header("Location: ../quiz/quiz-edit.php?id=$id&error=$error");
        exit;
    }
}
?>