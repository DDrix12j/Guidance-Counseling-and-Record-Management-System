<?php 
session_start();

if (isset($_POST['uname']) && isset($_POST['pass'])) {
    include "../DB_connection.php";
    
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../login.php?error=$em");
        exit;
    } else if (empty($pass)) {
        $em  = "Password is required";
        header("Location: ../login.php?error=$em");
        exit;
    } else {
        // Check in admin table
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($pass, $user['password'])) {
                $_SESSION['role'] = 'Admin';
                $_SESSION['admin_id'] = $user['admin_id'];
                header("Location: ../admin/index.php");
                exit;
            }
        }

        // Check in teachers table
        $sql = "SELECT * FROM teachers WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($pass, $user['password'])) {
                $_SESSION['role'] = 'Teacher';
                $_SESSION['teacher_id'] = $user['teacher_id'];
                header("Location: ../Teacher/index.php");
                exit;
            }
        }

        // Check in registrar_office table
        $sql = "SELECT * FROM registrar_office WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            if (password_verify($pass, $user['password'])) {
                $_SESSION['role'] = 'Registrar Office';
                $_SESSION['r_user_id'] = $user['r_user_id'];
                header("Location: ../RegistrarOffice/index.php");
                exit;
            }
        }

        // If no match found
        $em  = "Incorrect Username or Password";
        header("Location: ../login.php?error=$em");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>