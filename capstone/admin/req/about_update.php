<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content'])) {
        include "../../DB_connection.php";
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $logo = '';
        $image = '';

        // Handle logo upload
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
            $logo = basename($_FILES['logo']['name']);
            $targetLogo = "../../uploads/" . $logo;
            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $targetLogo)) {
                $em = "Error uploading logo file";
                header("Location: ../about_edit.php?id=$id&error=$em");
                exit;
            }
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = basename($_FILES['image']['name']);
            $targetImage = "../../uploads/" . $image;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetImage)) {
                $em = "Error uploading image file";
                header("Location: ../about_edit.php?id=$id&error=$em");
                exit;
            }
        }

        // Check if any field is empty
        if (empty($title) || empty($content)) {
            $em = "Title and content are required";
            header("Location: ../about_edit.php?id=$id&error=$em");
            exit;
        } else {
            // Update the database
            if ($logo && $image) {
                $sql = "UPDATE about_boxes SET title=?, content=?, logo=?, image=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $content, $logo, $image, $id]);
            } elseif ($logo) {
                $sql = "UPDATE about_boxes SET title=?, content=?, logo=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $content, $logo, $id]);
            } elseif ($image) {
                $sql = "UPDATE about_boxes SET title=?, content=?, image=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $content, $image, $id]);
            } else {
                $sql = "UPDATE about_boxes SET title=?, content=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $content, $id]);
            }
            $sm = "Box updated successfully";
            header("Location: ../about_edit.php?id=$id&success=$sm");
            exit;
        }
    } else {
        header("Location: ../about_manage.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>