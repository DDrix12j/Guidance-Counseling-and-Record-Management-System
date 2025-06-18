<?php
function getNews($conn) {
    $sql = "SELECT title, content, image, date FROM news ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>