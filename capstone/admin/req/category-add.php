<?php
include "../../DB_connection.php";
include "../../data/category.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    if (!empty($name) && !empty($description)) {
        addCategory($conn, null, $name, $description);
        header("Location: ../quiz/category-manage.php?success=Category added successfully");
        exit;
    } else {
        $error = "All fields are required.";
        header("Location: ../quiz/category-add.php?error=$error");
        exit;
    }
}
?>