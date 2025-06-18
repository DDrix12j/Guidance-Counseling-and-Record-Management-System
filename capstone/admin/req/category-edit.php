<?php
include "../../DB_connection.php";
include "../../data/category.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    if (!empty($name) && !empty($description)) {
        updateCategory($conn, $id, $name, $description);
        header("Location: ../quiz/category-manage.php?success=Category updated successfully");
        exit;
    } else {
        $error = "All fields are required.";
        header("Location: ../quiz/category-edit.php?id=$id&error=$error");
        exit;
    }
}
?>