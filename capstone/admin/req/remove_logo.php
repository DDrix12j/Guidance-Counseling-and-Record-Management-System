<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    if (isset($_GET['id'])) {
        include "../../DB_connection.php";
        $id = $_GET['id'];

        // Remove logo from database
        $sql = "UPDATE about_boxes SET logo=NULL WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        $sm = "Logo removed successfully";
        header("Location: ../about_edit.php?id=$id&success=$sm");
        exit;
    } else {
        header("Location: ../about_manage.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>