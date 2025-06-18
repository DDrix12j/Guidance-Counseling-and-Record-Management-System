<?php 
include "DB_connection.php";
include "data/setting.php";
include "data/about.php";
$setting = getSetting($conn);
$boxes = getAllAboutBoxes($conn);
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="tntsannexicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            background-size: cover;
            background-color: <?=$setting['background_color']?>;
            font-family: 'Poppins', sans-serif;
        }

        .body-home {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .scrollable-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .about-bar {
            position: relative;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            color: white;
            background: url('img/365312550_779895047479706_5683602959482120186_n.jpg') no-repeat center center;
            background-size: cover;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            box-sizing: border-box;
        }

        .about-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }

        .about-bar h2 {
            position: relative;
            z-index: 1;
            letter-spacing: 1px;
            font-size: 3rem;
        }

        .about-content {
            text-align: left;
            color: black;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: normal;
        }

        .about-content p {
            margin: 0 0 10px 0;
            font-size: 1rem;
        }

        .about-content ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        .about-content ul li {
            margin-bottom: 10px;
        }

        .about-content a {
            color: #ff0000;
            text-decoration: none;
            background-color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            border: 2px solid #ff0000;
            font-weight: normal;
        }

        .about-content a:hover {
            background-color: #ff0000;
            color: white;
        }

        .black-fill {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .btn-current-page {
            background-color: #ff0000;
            color: white;
            font-weight: normal;
        }

        .btn-current-page:hover {
            background-color: #ff0000;
            color: white;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
    </style>
</head>
<body class="body-home">
    <?php include "inc/navbar.php"; ?>
    
    <div class="scrollable-content">
        <div class="about-bar">
            <h2>
                <span>Guidance</span>
            </h2>
        </div>
        <div class="d-flex justify-content-start mb-3" style="margin-left: 1%;">
            <a href="index.php" class="btn btn-light mx-2 text-danger">Home</a>
            <a href="contact.php" class="btn btn-light mx-2 btn-current-page">Contact</a>
            <a href="services.php" class="btn btn-light mx-2 text-danger">Guidance</a>
            <a href="services.php" class="btn btn-light mx-2 text-danger">Career Guidance</a>
            <a href="request-support.php" class="btn btn-light mx-2 text-danger">Request & Support</a>
        </div>
        <div class="black-fill">
            <div class="container mt-5">
                <div class="about-content">
                    <p>Mr. Daniel Reyes is the dedicated Guidance Counselor at Tanza National Trade School Annex. He is committed to helping students with their academic, personal, and career-related concerns. With a passion for guiding young minds, he ensures that every student receives the support they need to succeed.</p>
                    <p><strong>Guidance Office</strong></p>
                    <p>Mr. Daniel Reyes, RGC – Guidance Counselor</p>
                    <p>📞 Contact Number: 09734829192</p>
                    <p>📧 Email: daniel.reyes@tnths-annex.edu.ph</p>
                    <p>📍 Office Location: Guidance Office, Room 102</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>