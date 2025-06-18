<?php
function getNews($conn) {
    $sql = "SELECT id, title, content, image, date FROM news ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNewsById($conn, $id) {
    $sql = "SELECT id, title, content, image FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>