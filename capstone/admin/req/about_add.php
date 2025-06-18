<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    if (isset($_POST['title']) && isset($_POST['content']) && isset($_FILES['logo'])) {
        include "../../DB_connection.php";
        $title = $_POST['title'];
        $content = $_POST['content'];
        $logo = '';
        $image = '';

        // Check if the logo file was uploaded without errors
        if ($_FILES['logo']['error'] == 0) {
            $logo = basename($_FILES['logo']['name']);
            $targetLogo = "../../uploads/" . $logo;
            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $targetLogo)) {
                $em = "Error uploading logo file";
                header("Location: ../about_manage.php?error=$em");
                exit;
            }
        } else {
            $em = "Logo file upload error: " . $_FILES['logo']['error'];
            header("Location: ../about_manage.php?error=$em");
            exit;
        }

        // Check if the image file was uploaded without errors
        if ($_FILES['image']['error'] == 0) {
            $image = basename($_FILES['image']['name']);
            $targetImage = "../../uploads/" . $image;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetImage)) {
                $em = "Error uploading image file";
                header("Location: ../about_manage.php?error=$em");
                exit;
            }
        }

        // Check if any field is empty
        if (empty($title) || empty($content) || empty($logo)) {
            $em = "All fields are required";
            header("Location: ../about_manage.php?error=$em");
            exit;
        } else {
            $sql = "INSERT INTO about_boxes (title, content, logo, image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$title, $content, $logo, $image])) {
                header("Location: ../about_manage.php?success=Box added successfully");
                exit;
            } else {
                $em = "Error adding box";
                header("Location: ../about_manage.php?error=$em");
                exit;
            }
        }
    } else {
        $em = "All fields are required";
        header("Location: ../about_manage.php?error=$em");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>