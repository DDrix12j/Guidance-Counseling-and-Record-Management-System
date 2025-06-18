<?php
// filepath: d:\aaaa\htdocs\capstonework\capstone\admin\req\question-add.php
include "../../DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $question_text = $_POST['question_text'];

    if (!empty($category_id) && !empty($question_text)) {
        $stmt = $conn->prepare("INSERT INTO questions (category_id, question_text) VALUES (?, ?)");
        $stmt->execute([$category_id, $question_text]);
        header("Location: ../question-manage.php?category_id=$category_id&success=Question added successfully");
        exit;
    } else {
        $error = "Question text is required.";
        header("Location: ../question-add.php?category_id=$category_id&error=$error");
        exit;
    }
}
?>