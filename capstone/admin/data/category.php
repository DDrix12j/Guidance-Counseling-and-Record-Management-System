<?php
function getAllCategories($conn) {
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addCategory($conn, $quiz_id, $name, $description) {
    $stmt = $conn->prepare("INSERT INTO categories (quiz_id, name, description) VALUES (?, ?, ?)");
    $stmt->execute([$quiz_id, $name, $description]);
}

function updateCategory($conn, $id, $name, $description) {
    $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $description, $id]);
}

function deleteCategory($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
}
?>