<?php
include "../../DB_connection.php";
include "../../data/category.php";

if (isset($_GET['id'])) {
    deleteCategory($conn, $_GET['id']);
    header("Location: category-manage.php?success=Category deleted successfully");
    exit;
} else {
    header("Location: category-manage.php?error=Category ID is required");
    exit;
}
?>