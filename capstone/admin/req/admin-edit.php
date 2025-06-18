<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (isset($_POST['username']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['admin_id'])) {
            include "../../DB_connection.php";
            include "../data/admin.php";

            $username = $_POST['username'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $admin_id = $_POST['admin_id'];

            if (empty($username)) {
                $em = "Username is required";
                header("Location: ../admin-edit.php?error=$em&admin_id=$admin_id");
                exit;
            } else if (empty($fname)) {
                $em = "First name is required";
                header("Location: ../admin-edit.php?error=$em&admin_id=$admin_id");
                exit;
            } else if (empty($lname)) {
                $em = "Last name is required";
                header("Location: ../admin-edit.php?error=$em&admin_id=$admin_id");
                exit;
            } else {
                $sql = "UPDATE admin SET username=?, fname=?, lname=? WHERE admin_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username, $fname, $lname, $admin_id]);
                $sm = "Admin updated successfully";
                header("Location: ../admin-edit.php?success=$sm&admin_id=$admin_id");
                exit;
            }
        } else {
            header("Location: ../admin-manage.php");
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