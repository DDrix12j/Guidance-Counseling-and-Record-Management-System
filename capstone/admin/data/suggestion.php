<?php
function getAllSuggestions($conn, $category_id) {
    $stmt = $conn->prepare("SELECT * FROM career_suggestions WHERE category_id = ?");
    $stmt->execute([$category_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addSuggestion($conn, $category_id, $suggestion_text) {
    $stmt = $conn->prepare("INSERT INTO career_suggestions (category_id, suggestion_text) VALUES (?, ?)");
    $stmt->execute([$category_id, $suggestion_text]);
}

function updateSuggestion($conn, $id, $suggestion_text) {
    $stmt = $conn->prepare("UPDATE career_suggestions SET suggestion_text = ? WHERE id = ?");
    $stmt->execute([$suggestion_text, $id]);
}

function deleteSuggestion($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM career_suggestions WHERE id = ?");
    $stmt->execute([$id]);
}
?>