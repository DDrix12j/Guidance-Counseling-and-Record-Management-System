<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    if (isset($_GET['id'])) {
        include "../../DB_connection.php";
        $id = $_GET['id'];

        $sql = "DELETE FROM about_boxes WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $sm = "Box deleted successfully";
        header("Location: ../about_manage.php?success=$sm");
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