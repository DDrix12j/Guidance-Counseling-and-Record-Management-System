<!-- filepath: d:\aaaa\htdocs\capstonework\capstone\admin\req\violations-delete.php -->
<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../../DB_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Delete the record
        $sql = "DELETE FROM violations_records WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        header("Location: ../violations.php?success=Record deleted successfully");
        exit;
    } else {
        header("Location: ../violations.php?error=No ID provided");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}
?>