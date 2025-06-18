<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['icon'])) {
        include "../../DB_connection.php";
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $icon = $_POST['icon'];
        $logo = '';

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
            $logo = basename($_FILES['logo']['name']);
            $target = "../../uploads/" . $logo;
            move_uploaded_file($_FILES['logo']['tmp_name'], $target);
        }

        if (empty($title) || empty($content) || empty($icon)) {
            $em = "All fields are required";
            header("Location: ../about_edit.php?id=$id&error=$em");
            exit;
        } else {
            if ($logo) {
                $sql = "UPDATE about_boxes SET title=?, content=?, icon=?, logo=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $content, $icon, $logo, $id]);
            } else {
                $sql = "UPDATE about_boxes SET title=?, content=?, icon=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $content, $icon, $id]);
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