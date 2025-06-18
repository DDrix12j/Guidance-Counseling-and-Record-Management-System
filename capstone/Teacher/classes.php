<?php 
session_start();
if (isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Teacher') {
       include "../DB_connection.php";
       include "data/class.php";
       include "data/grade.php";
       include "data/section.php";
       include "data/teacher.php";
       
       $teacher_id = $_SESSION['teacher_id'];
       $teacher = getTeacherById($teacher_id, $conn);

        // Get assigned class IDs (assuming comma-separated)
        $assigned_class_ids = array_filter(array_map('trim', explode(',', $teacher['class'])));

        // Fetch all classes
        $all_classes = getAllClasses($conn);

        // Filter classes to only those assigned to this teacher
        $classes = array_filter($all_classes, function($class) use ($assigned_class_ids) {
            return in_array($class['class_id'], $assigned_class_ids);
        });
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers - Classes</title>
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
        if ($classes != 0) {
     ?>
     <div class="container mt-5">

           <div class="table-responsive">
              <table class="table table-bordered mt-3 n-table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Class</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 0; foreach ($classes as $class ) { 
                      ?>
                  

                      <?php 
                          $grade  = getGradeById($class['grade'], $conn);
                          $section = getSectioById($class['section'], $conn);
                          $c = $grade['grade_code'].'-'.$grade['grade'].$section['section'];
                          $i++; ?>
                            <tr>
                                <th scope="row"><?=$i?></th>
                                <td>

                                      <?php echo $c; ?>
                                      
                            </td>
                          </tr>

                            <?php         
                          
                          
                       ?>
                       
                <?php } ?>
                </tbody>
              </table>
           </div>
         <?php }else{ ?>
             <div class="alert alert-info .w-450 m-5" 
                  role="alert">
                Empty!
              </div>
         <?php } ?>
     </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
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