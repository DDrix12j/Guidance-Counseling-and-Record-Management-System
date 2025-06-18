<?php
include "DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tracking_number = $_POST['tracking_number'];

    $sql = "SELECT * FROM message WHERE tracking_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tracking_number]);
    $request = $stmt->fetch();

    if ($request) {
        echo "<h3>Request Details</h3>";
        echo "<p><strong>Tracking Number:</strong> " . htmlspecialchars($request['tracking_number']) . "</p>";
        echo "<p><strong>Type of Request:</strong> " . htmlspecialchars($request['type_of_request']) . "</p>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($request['message']) . "</p>";
        echo "<p><strong>Status:</strong> " . htmlspecialchars($request['status']) . "</p>";
        if (!empty($request['admin_message'])) {
            echo "<p><strong>Admin Message:</strong> " . htmlspecialchars($request['admin_message']) . "</p>";
        } else {
            echo "<p><strong>Admin Message:</strong> No message from admin yet.</p>";
        }
    } else {
        echo "<p>No request found with the provided tracking number.</p>";
    }
}
?>