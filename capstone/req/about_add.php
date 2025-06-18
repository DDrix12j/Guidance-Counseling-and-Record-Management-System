<?php
include "../../DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $logo = $_FILES['logo'];
    $image = $_FILES['image'];

    // Handle logo upload
    if ($logo['error'] == 0) {
        $logoPath = '../../uploads/' . basename($logo['name']);
        move_uploaded_file($logo['tmp_name'], $logoPath);
    } else {
        $logoPath = null;
    }

    // Handle image upload
    if ($image['error'] == 0) {
        $imagePath = '../../uploads/' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
    } else {
        $imagePath = null;
    }

    // Save the data to the database
    $stmt = $conn->prepare("INSERT INTO about_boxes (title, content, logo, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $logoPath, $imagePath);
    $stmt->execute();
    $stmt->close();

    header("Location: ../about_manage.php?success=Box added successfully");
    exit;
} else {
    header("Location: ../about_manage.php?error=Failed to add box");
    exit;
}
?>