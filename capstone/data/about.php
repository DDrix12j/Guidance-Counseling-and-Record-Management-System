<?php
function getAllAboutBoxes($conn) {
    $sql = "SELECT * FROM about_boxes";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAboutBoxById($id, $conn) {
    $sql = "SELECT * FROM about_boxes WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}
?>