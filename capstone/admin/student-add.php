<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
      
       include "../DB_connection.php";
       include "data/grade.php";
       include "data/section.php";
       include "data/teacher.php"; // Include teacher data
       include "data/class.php";
       $grades = getAllGrades($conn);
       $sections = getAllSections($conn);
       $teachers = getAllTeachers($conn); // Fetch all teachers
       $classes = getAllClasses($conn);

       $fname = '';
       $lname = '';
       $lrn = '';
       $guardian = '';
       $address = '';
       $birthday = '';
       $birthplace = '';

       if (isset($_GET['fname'])) $fname = $_GET['fname'];
       if (isset($_GET['lname'])) $lname = $_GET['lname'];
       if (isset($_GET['lrn'])) $lrn = $_GET['lrn'];
       if (isset($_GET['guardian'])) $guardian = $_GET['guardian'];
       if (isset($_GET['address'])) $address = $_GET['address'];
       if (isset($_GET['birthday'])) $birthday = $_GET['birthday'];
       if (isset($_GET['birthplace'])) $birthplace = $_GET['birthplace'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <?php 
        include "inc/navbar.php";
     ?>
     <div class="container mt-5">
        <a href="student.php"
           class="btn btn-dark">Go Back</a>

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/student-add.php">
        <h3>Add New Student</h3><hr>
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
        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$fname?>" 
                 name="fname" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$lname?>"
                 name="lname" required>
        </div>
        <div class="mb-3">
          <label class="form-label">LRN</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$lrn?>"
                 name="lrn" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Guardian</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$guardian?>"
                 name="guardian" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$address?>"
                 name="address" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Birthday</label>
          <input type="date" 
                 class="form-control"
                 value="<?=$birthday?>"
                 name="birthday" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Birthplace</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$birthplace?>"
                 name="birthplace" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Gender</label><br>
          <input type="radio"
                 value="Male"
                 checked 
                 name="gender"> Male
                 &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio"
                 value="Female"
                 name="gender"> Female
        </div><br><hr>
        <div class="mb-3">
          <label class="form-label">Grade</label>
          <div class="row row-cols-5">
            <?php foreach ($grades as $grade): ?>
            <div class="col">
              <input type="radio"
                     name="grade"
                     value="<?=$grade['grade_id']?>" required>
                     <?=$grade['grade_code']?>-<?=$grade['grade']?>
            </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Section</label>
          <div class="row row-cols-5">
            <?php foreach ($sections as $section): ?>
            <div class="col">
              <input type="radio"
                     name="section"
                     value="<?=$section['section_id']?>" required>
                     <?=$section['section']?>
            </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Adviser</label>
          <select name="adviser" class="form-select" required>
            <option value="">Select Adviser</option>
            <?php foreach ($teachers as $teacher): ?>
              <option value="<?=$teacher['fname'] . ' ' . $teacher['lname']?>">
                <?=$teacher['fname'] . ' ' . $teacher['lname']?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Class (Section)</label>
          <div class="row row-cols-5">
            <?php foreach ($classes as $class): 
              $grade = getGradeById($class['grade'], $conn);
              $section = getSectioById($class['section'], $conn);
              $label = $grade['grade_code'].'-'.$grade['grade'].$section['section'];
            ?>
            <div class="col">
              <input type="radio"
                     name="class_id"
                     value="<?=$class['class_id']?>" required>
                     <?=$label?>
            </div>
            <?php endforeach ?>
          </div>
        </div>

      <button type="submit" class="btn btn-primary">Register</button>
     </form>
     </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
    header("Location: ../login.php");
    exit;
} 

?>