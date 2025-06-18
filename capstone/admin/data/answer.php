<?php
function getAllAnswers($conn, $question_id) {
    $stmt = $conn->prepare("SELECT * FROM answers WHERE question_id = ?");
    $stmt->execute([$question_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addAnswer($conn, $question_id, $answer_text, $weight) {
    $stmt = $conn->prepare("INSERT INTO answers (question_id, answer_text, weight) VALUES (?, ?, ?)");
    $stmt->execute([$question_id, $answer_text, $weight]);
}

function updateAnswer($conn, $id, $answer_text, $weight) {
    $stmt = $conn->prepare("UPDATE answers SET answer_text = ?, weight = ? WHERE id = ?");
    $stmt->execute([$answer_text, $weight, $id]);
}

function deleteAnswer($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM answers WHERE id = ?");
    $stmt->execute([$id]);
}
?>