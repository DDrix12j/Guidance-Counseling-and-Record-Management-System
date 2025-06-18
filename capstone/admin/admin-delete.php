<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && isset($_GET['admin_id'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/admin.php";

        $admin_id = $_GET['admin_id'];
        if (removeAdmin($admin_id, $conn)) {
            $sm = "Admin deleted successfully";
            header("Location: admin-manage.php?success=$sm");
            exit;
        } else {
            $em = "Unknown error occurred";
            header("Location: admin-manage.php?error=$em");
            exit;
        }
    } else {
        header("Location: admin-manage.php");
        exit;
    }
} else {
    header("Location: admin-manage.php");
    exit;
}
?>