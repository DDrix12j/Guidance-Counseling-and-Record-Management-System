<?php
function getAllQuizzes($conn) {
    $stmt = $conn->prepare("SELECT * FROM quizzes WHERE is_active = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addQuiz($conn, $title, $description) {
    $stmt = $conn->prepare("INSERT INTO quizzes (title, description) VALUES (?, ?)");
    $stmt->execute([$title, $description]);
}

function updateQuiz($conn, $id, $title, $description) {
    $stmt = $conn->prepare("UPDATE quizzes SET title = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $description, $id]);
}

function deleteQuiz($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->execute([$id]);
}
?>