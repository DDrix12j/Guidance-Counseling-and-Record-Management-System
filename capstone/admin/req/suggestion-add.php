<?php
include "../../DB_connection.php";
include "../../data/suggestion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $suggestion_text = $_POST['suggestion_text'];

    if (!empty($category_id) && !empty($suggestion_text)) {
        addSuggestion($conn, $category_id, $suggestion_text);
        header("Location: ../quiz/suggestion-manage.php?success=Suggestion added successfully");
        exit;
    } else {
        $error = "All fields are required.";
        header("Location: ../quiz/suggestion-add.php?error=$error");
        exit;
    }
}
?>