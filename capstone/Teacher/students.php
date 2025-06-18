<?php 
session_start();
if (isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Teacher') {
       include "../DB_connection.php";
       include "data/teacher.php";
       include "data/student.php";
       include "data/class.php";
       include "data/grade.php";
       include "data/section.php";
       
       $teacher_id = $_SESSION['teacher_id'];
       $teacher = getTeacherById($teacher_id, $conn);

       // Get assigned class IDs (comma-separated string to array)
       $assigned_class_ids = array_filter(array_map('trim', explode(',', $teacher['class'])));

       // Prepare SQL to fetch students in these classes
       if (count($assigned_class_ids) > 0) {
           // Prepare placeholders for PDO
           $placeholders = implode(',', array_fill(0, count($assigned_class_ids), '?'));
           $sql = "SELECT * FROM students WHERE class_id IN ($placeholders)";
           $stmt = $conn->prepare($sql);
           $stmt->execute($assigned_class_ids);
           $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } else {
           $students = [];
       }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers - Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      overflow-y: auto;
    }
    .container {
      max-height: 90vh;
      overflow-y: auto;
    }
    body {
    margin: 0;
    padding: 0;
    display: flex;
  }
  
  .navbar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    overflow-y: auto;
  }
  
  .navbar-nav .nav-link {
    color: #fff;
    padding: 10px 20px;
    text-align: left;
  }
  
  .navbar-nav .nav-link:hover {
    background-color: #495057;
    color: #fff;
  }
  
  .navbar-brand {
    text-align: center;
  }
  
  .flex-grow-1 {
    margin-left: 250px; /* Adjust based on navbar width */
    padding: 20px;
  }
  </style>
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if (count($students) > 0) {
     ?>
     <div class="container mt-5">
           <h3>Students in Your Classes</h3>
           <div class="table-responsive">
              <table class="table table-bordered mt-3 n-table">
                <thead>
                  <tr>
                    <th scope="col">LRN</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Class</th>
                    <th scope="col">Grade</th>
                    <!-- Add more columns as needed -->
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($students as $student): 
                          $class = getClassById($student['class_id'], $conn);
                          $grade = $class ? getGradeById($class['grade'], $conn) : null;
                          $section = $class ? getSectioById($class['section'], $conn) : null;
                          $class_label = $class && $grade && $section ? $grade['grade_code'].'-'.$grade['grade'].' '.$section['section'] : 'N/A';
                      ?>
                      <tr onclick="window.location.href='fill-report-card.php?student_id=<?= $student['student_id'] ?>'" style="cursor:pointer;">
                          <td><?= htmlspecialchars($student['lrn']) ?></td>
                          <td><?= htmlspecialchars($student['fname']) ?></td>
                          <td><?= htmlspecialchars($student['lname']) ?></td>
                          <td><?= htmlspecialchars($class_label) ?></td>
                          <td><?= $grade ? htmlspecialchars($grade['grade_code'].'-'.$grade['grade']) : 'N/A' ?></td>
                      </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
           </div>
         <?php }else{ ?>
             <div class="alert alert-info .w-450 m-5" 
                  role="alert">
                No students found for your classes.
              </div>
         <?php } ?>
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