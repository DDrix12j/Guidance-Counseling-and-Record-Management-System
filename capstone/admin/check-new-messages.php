<?php
include "../DB_connection.php";

function getNewMessagesCount($conn) {
    $sql = "SELECT COUNT(*) as count FROM message WHERE is_new = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

echo getNewMessagesCount($conn);
?>