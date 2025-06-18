<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";
    include "../data/about.php";

    $boxes = getAllAboutBoxes($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage About Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../tntsannexicon.png">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: auto; /* Make the page scrollable */
        }
        .logo-preview-container {
            background-color: black; /* Add black background */
            display: inline-block;
            padding: 10px;
            border-radius: 5px;
        }
        .about-boxes {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping */
            gap: 20px; /* Decrease the gap between the cards */
            justify-content: center; /* Center the cards */
            margin: 0 auto; /* Center the container */
            padding: 0;
            max-width: 100%; /* Use full width of the container */
        }
        .about-box {
            background-color: rgb(255, 25, 0);
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: calc(50% - 20px); /* Ensure two cards per row */
            box-sizing: border-box;
            text-align: center;
            position: relative;
            height: 400px; /* Increase height to fit both buttons */
        }
        .about-box img {
            width: 150px; /* Increase image size */
            height: auto; /* Maintain aspect ratio */
            background-color: white;
            border-radius: 50%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .about-box h2 {
            margin-top: 0;
            font-size: 2rem; /* Increase font size */
            font-weight: bold;
            text-align: center; /* Center align text */
        }
        .about-box p {
            margin: 0;
            font-size: 1.2rem; /* Increase font size */
            line-height: 1.5; /* Increase line height */
            height: 150px; /* Set fixed height */
            overflow: hidden; /* Hide overflowing text */
            text-overflow: ellipsis; /* Add ellipsis for overflow */
            color: #5A565E; /* Set text color */
            font-family: 'Poppins', sans-serif; /* Set font to Poppins */
        }
        .about-box a {
            color: red; /* Set link color to red */
            text-decoration: underline;
            font-size: 1.2rem; /* Increase font size */
            position: absolute;
            bottom: 10px; /* Position the link at the bottom */
            left: 50%;
            transform: translateX(-50%);
        }
        .about-box .lower-half {
            background-color: white; /* Set background to white */
            color: rgb(255, 25, 0); /* Set text color to red */
            padding: 20px;
            border-radius: 0 0 10px 10px; /* Round bottom corners */
            position: absolute;
            bottom: 50px; /* Adjust bottom position to fit buttons */
            left: 0;
            right: 0;
            height: 50%; /* Set height to 50% */
            box-sizing: border-box;
            overflow: auto; /* Enable scrolling for overflowing content */
        }
        .btn-warning, .btn-danger {
            margin: 5px; /* Add margin to buttons */
        }
        .btn-warning {
            background-color: orange;
            color: white;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <a href="index.php" class="btn btn-dark">Go Back</a>
        <form method="post" action="req/about_add.php" enctype="multipart/form-data" class="shadow p-3 mt-5 form-w">
            <h3>Add New Box</h3><hr>
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
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Logo</label>
                <input type="file" class="form-control" name="logo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input type="file" class="form-control" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Add Box</button>
        </form>

        <h3 class="mt-5">Existing Boxes</h3>
        <div class="about-boxes">
            <?php foreach ($boxes as $box) { ?>
                <div class="about-box">
                    <img src="../uploads/<?=$box['logo']?>" alt="Box Image" class="school-logo">
                    <h2><?=$box['title']?></h2>
                    <img src="../uploads/<?=$box['image']?>" alt="Content Image">
                    <div class="lower-half">
                        <h2><?=$box['title']?></h2>
                        <p>
                            <?php 
                            $content = $box['content'];
                            echo strlen($content) > 250 ? substr($content, 0, 250) . '...' : $content; 
                            ?>
                        </p>
                    </div>
                    <a href="about_edit.php?id=<?=$box['id']?>" class="btn btn-warning" style="bottom: 60px;">Edit</a>
                    <a href="req/about_delete.php?id=<?=$box['id']?>" class="btn btn-danger">Delete</a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
<?php
} else {
    header("Location: ../login.php");
    exit;
}
?>