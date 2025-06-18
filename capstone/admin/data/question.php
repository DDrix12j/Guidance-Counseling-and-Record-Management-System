<?php
function getAllQuestions($conn, $category_id) {
    $stmt = $conn->prepare("SELECT * FROM questions WHERE category_id = ?");
    $stmt->execute([$category_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addQuestion($conn, $category_id, $question_text) {
    $stmt = $conn->prepare("INSERT INTO questions (category_id, question_text) VALUES (?, ?)");
    $stmt->execute([$category_id, $question_text]);
}

function updateQuestion($conn, $id, $question_text) {
    $stmt = $conn->prepare("UPDATE questions SET question_text = ? WHERE id = ?");
    $stmt->execute([$question_text, $id]);
}

function deleteQuestion($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->execute([$id]);
}
?>