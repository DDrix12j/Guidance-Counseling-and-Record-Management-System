<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (isset($_POST['teacher_id']) &&
            isset($_POST['fname']) &&
            isset($_POST['lname']) &&
            isset($_POST['username']) &&
            isset($_POST['address']) &&
            isset($_POST['phone_number']) &&
            isset($_POST['email_address']) &&
            isset($_POST['date_of_birth']) &&
            isset($_POST['gender']) &&
            isset($_POST['position']) &&
            isset($_POST['subjects']) &&
            isset($_POST['classes'])) {

            include '../../DB_connection.php';

            $teacher_id = $_POST['teacher_id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $username = $_POST['username'];
            $address = $_POST['address'];
            $phone_number = $_POST['phone_number'];
            $email_address = $_POST['email_address'];
            $date_of_birth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $position = $_POST['position'];
            $subjects = implode(',', $_POST['subjects']);
            $classes = implode(',', $_POST['classes']);

            $sql = "UPDATE teachers SET 
                    fname = ?, lname = ?, username = ?, address = ?, phone_number = ?, email_address = ?, 
                    date_of_birth = ?, gender = ?, position = ?, subjects = ?, class = ? 
                    WHERE teacher_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$fname, $lname, $username, $address, $phone_number, $email_address, 
                            $date_of_birth, $gender, $position, $subjects, $classes, $teacher_id]);

            $sm = "Teacher updated successfully!";
            header("Location: ../teacher-edit.php?success=$sm&teacher_id=$teacher_id");
            exit;
        } else {
            $em = "All fields are required!";
            header("Location: ../teacher-edit.php?error=$em&teacher_id=$teacher_id");
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
