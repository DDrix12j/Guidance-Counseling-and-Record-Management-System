<?php
include "../../DB_connection.php";
include "../../data/suggestion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $suggestion_text = $_POST['suggestion_text'];

    if (!empty($id) && !empty($suggestion_text)) {
        updateSuggestion($conn, $id, $suggestion_text);
        header("Location: ../quiz/suggestion-manage.php?success=Suggestion updated successfully");
        exit;
    } else {
        $error = "All fields are required.";
        header("Location: ../quiz/suggestion-edit.php?id=$id&error=$error");
        exit;
    }
}
?>