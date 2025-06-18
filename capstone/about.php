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
    <title>About Us</title>
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
        padding: 0;
        overflow: hidden; /* Prevent scrolling on the body */
        background-size: cover;
        background-color: <?=$setting['background_color']?>;
        font-family: <?=$setting['font_style']?>;
    }
    .navbar {
        background-color: <?=$setting['primary_color']?>;
        position: fixed; /* Fix the navbar at the top */
        width: 100%;
        top: 0;
        z-index: 1000; /* Ensure the navbar is above other content */
    }
    .navbar-nav .nav-link {
        color: <?=$setting['secondary_color']?> !important;
        font-family: 'Montserrat', sans-serif;
    }
    .body-home {
        background-color: <?=$setting['background_color']?>;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start; /* Ensure content starts from the top */
        color: #fff;
        margin-top: 56px; /* Adjust for the height of the fixed navbar */
    }
    .scrollable-content {
        height: calc(100vh - 56px); /* Adjust for the height of the fixed navbar */
        overflow-y: auto; /* Enable vertical scrolling */
        padding: 20px;
        box-sizing: border-box;
    }
    .about-bar {
        position: relative;
        text-align: center;
        margin-top: 54px; /* Add margin between navbar and title box */
        margin-bottom: 20px;
        font-family: 'Poppins', sans-serif; /* Apply Poppins font */
        font-size: 3rem; /* Increase font size */
        color: white;
        background: url('img/365312550_779895047479706_5683602959482120186_n.jpg') no-repeat center center;
        background-size: cover;
        padding: 40px;
        border-radius: 10px;
        width: 100%; /* Make the width smaller */
        margin-left: auto; /* Center the box horizontally */
        margin-right: auto; /* Center the box horizontally */
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
        background-color: #9f1015;
        color: white;
        padding: 20px;
        border-radius: 10px;
        width: calc(33.333% - 20px); /* Ensure three cards per row */
        height: 500px; /* Fixed height for the cards */
        box-sizing: border-box;
        text-align: center;
        position: relative;
        overflow: hidden; /* Hide overflowing content */
    }
    .about-box .school-logo {
        position: absolute;
        top: 0px; /* Move the logo higher */
        left: 20px; /* Move the logo to the left */
        width: 70px;
        height: auto;
        background-color: white;
        border-radius: 50%;
    }
    .about-box img {
        width: 200px; /* Increase image size */
        height: 200px; /* Set fixed height for images */
        border-radius: 50%;
        padding: 5px;
        margin-top: 20px; /* Move the image down */
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .about-box h2 {
        margin-top: 10px; /* Move the school name up */
        font-size: 1.5rem; /* Increase font size */
        font-weight: bold;
        text-align: center;
    }
    .about-box p {
        margin: 0;
        font-size: 1rem; /* Increase font size */
        line-height: 1.5; /* Increase line height */
        height: 100px; /* Set fixed height */
        overflow: hidden; /* Hide overflowing text */
        text-overflow: ellipsis; /* Add ellipsis for overflow */
        color: #5A565E; /* Set text color */
        font-family: 'Poppins', sans-serif; /* Set font to Poppins */
    }
    .about-box a {
    color: #9f1015;
    text-decoration: underline;
    font-size: 1.2rem; /* Increase font size */
    position: absolute;
    bottom: 10px; /* Position the link at the bottom */
    left: 50%;
    transform: translateX(-50%);
}
    .about-box .lower-half {
    background-color: white; /* Set background to white */
    color: #9f1015; /* Set text color to red */
    padding: 20px;
    border-radius: 0 0 10px 10px; /* Round bottom corners */
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40%; /* Set height to 30% */
    box-sizing: border-box;
    overflow: auto; /* Enable scrolling for overflowing content */
}
    .black-fill {
        background-color: transparent; /* Set background to transparent */
        margin: 0;
        padding: 0;
    }
    
</style>
</head>
<body class="body-home">
    <?php include "inc/navbar.php"; ?>
    
    <div class="scrollable-content">
        <div class="about-bar">
            <h2>
                <span>About Us</span>
            </h2>
        </div>
        <div class="black-fill">
            <div class="container-fluid"> <!-- Changed to container-fluid to use full width -->
                <div class="about-boxes">
                    <?php foreach ($boxes as $box) { ?>
                        <div class="about-box">
                            
                            <h2><?=$setting['school_name']?></h2>
                            <img src="uploads/<?=$box['logo']?>" alt="Box Image">
                            <div class="lower-half">
                                <h2><?=$box['title']?></h2>
                                <p>
                                    <?php 
                                    $content = $box['content'];
                                    echo strlen($content) > 200 ? substr($content, 0, 200) . '...' : $content; 
                                    ?>
                                </p>
                                <a href="about_detail.php?id=<?=$box['id']?>">Read more >></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>