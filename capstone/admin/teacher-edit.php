<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['teacher_id'])) {

    if ($_SESSION['role'] == 'Admin') {
      
       include "../DB_connection.php";
       include "data/subject.php";
       include "data/grade.php";
       include "data/section.php";
       include "data/class.php";
       include "data/teacher.php"; // Include the file containing getTeacherById

       $subjects = getAllSubjects($conn);
       $classes  = getAllClasses($conn);
       
       $teacher_id = $_GET['teacher_id'];
       $teacher = getTeacherById($teacher_id, $conn); // Fetch teacher details

       if ($teacher == 0) {
         header("Location: teacher.php");
         exit;
       }

       // Split the teacher's subjects and classes into arrays
       $teacher_subjects = explode(',', $teacher['subject']);
       $teacher_classes = explode(',', $teacher['class']);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Teacher</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <style>
        body {
            overflow-y: auto;
        }

        .container {
            max-height: 90vh;
            overflow-y: auto;
        }
        </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <a href="teacher.php" class="btn btn-dark">Go Back</a>
        <form method="post" class="shadow p-3 mt-5 form-w" action="req/teacher-edit.php">
            <h3>Edit Teacher</h3><hr>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_GET['error']?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?=$_GET['success']?>
                </div>
            <?php } ?>
            <input type="hidden" name="teacher_id" value="<?=$teacher['teacher_id']?>">

            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" value="<?=$teacher['fname']?>" name="fname" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" value="<?=$teacher['lname']?>" name="lname" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" value="<?=$teacher['username']?>" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Subjects</label>
                <select multiple class="form-control" name="subjects[]">
                    <?php foreach ($subjects as $subject) { ?>
                        <option value="<?=$subject['subject_id']?>" <?= in_array($subject['subject_id'], $teacher_subjects) ? 'selected' : '' ?>>
                            <?=$subject['subject']?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Classes</label>
                <div class="row row-cols-5">
                    <?php foreach ($classes as $class): ?>
                        <div class="col">
                            <input type="checkbox" name="classes[]" value="<?=$class['class_id']?>" <?= in_array($class['class_id'], $teacher_classes) ? 'checked' : '' ?>>
                            <?php 
                                $grade = getGradeById($class['grade'], $conn); 
                                $section = getSectioById($class['section'], $conn); 
                            ?>
                            <?=$grade['grade_code']?>-<?=$grade['grade'].$section['section']?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" value="<?=$teacher['position']?>" name="position" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" value="<?=$teacher['address']?>" name="address" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" value="<?=$teacher['phone_number']?>" name="phone_number" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" value="<?=$teacher['email_address']?>" name="email_address" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" value="<?=$teacher['date_of_birth']?>" name="date_of_birth" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <input type="radio" name="gender" value="Male" <?= $teacher['gender'] == 'Male' ? 'checked' : '' ?>> Male
                <input type="radio" name="gender" value="Female" <?= $teacher['gender'] == 'Female' ? 'checked' : '' ?>> Female
            </div>
            <button type="submit" class="btn btn-primary">Update Teacher</button>
        </form>
    </div>
</body>
</html>
<?php 
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>