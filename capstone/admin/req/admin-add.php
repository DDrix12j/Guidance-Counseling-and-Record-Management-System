<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['fname']) && isset($_POST['lname'])) {
            include "../../DB_connection.php";
            include "../data/admin.php";

            $username = $_POST['username'];
            $password = $_POST['password'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];

            if (empty($username)) {
                $em = "Username is required";
                header("Location: ../admin-add.php?error=$em");
                exit;
            } else if (empty($password)) {
                $em = "Password is required";
                header("Location: ../admin-add.php?error=$em");
                exit;
            } else if (empty($fname)) {
                $em = "First name is required";
                header("Location: ../admin-add.php?error=$em");
                exit;
            } else if (empty($lname)) {
                $em = "Last name is required";
                header("Location: ../admin-add.php?error=$em");
                exit;
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO admin (username, password, fname, lname) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username, $password, $fname, $lname]);
                $sm = "New admin added successfully";
                header("Location: ../admin-add.php?success=$sm");
                exit;
            }
        } else {
            header("Location: ../admin-add.php");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>