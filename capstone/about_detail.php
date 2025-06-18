<?php 
require_once "DB_connection.php";
require_once "data/setting.php";
require_once "data/about.php"; // Include the about data file

// Get the about ID from the URL
$about_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the about details from the database
$about_item = getAboutBoxById($about_id, $conn);

if ($about_item) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($about_item['title']) ?></title>
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
    overflow: auto; /* Allow scrolling */
    background: url('img/<?=$setting['background_image']?>') no-repeat center center fixed;
    background-size: cover;
    background-color: <?=$setting['background_color']?>;
    font-family: <?=$setting['font_style']?>;
}
.navbar {
    background-color: <?=$setting['primary_color']?>;
    top: 0;
    width: 100%;
    height: 150px; /* Adjust the height as needed */
    opacity: 0.9em;
    z-index: 1000; /* Ensure it stays on top of other elements */
    font-family: 'Montserrat', sans-serif; /* Apply Montserrat font */
    font-weight: bold; /* Make the font bold */
}
.navbar-nav .nav-link {
    color: <?=$setting['secondary_color']?> !important;
    font-family: 'Montserrat', sans-serif; /* Apply Montserrat font */
    font-weight: bold; /* Make the font bold */
}
.about-details {
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 200px;
    width: 80%;
    max-width: 800px; /* Set a maximum width */
    margin-left: auto;
    margin-right: auto;
}
</style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="about-details">
    <h2 style="text-align: center; margin-top: 30px; margin-bottom: 20px; font-family: 'Poppins', sans-serif; font-size: 3rem; font-weight: bold; color: white; background: url('img/365312550_779895047479706_5683602959482120186_n.jpg') no-repeat center center; background-size: cover; padding: 50px; border-radius: 10px; width: calc(100% - 40px); margin-left: 20px; margin-right: 20px; box-sizing: border-box; position: relative;">
    <span style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); border-radius: 10px;"></span>
    <span style="position: relative; z-index: 1;"><?=$about_item['title']?></span>
</h2>
        <?php if (!empty($about_item['image'])) { ?>
            <img src="uploads/<?=$about_item['image']?>" alt="<?=$about_item['title']?>" style="display: block; max-width: 80%; height: auto; margin: 20px auto; border-radius: 10px;">
        <?php } ?>
        <div class="about-content" style="font-family: 'Poppins', sans-serif; font-weight: bold; font-size: 1.5rem; margin-left: 50px; margin-right: 20px; margin-bottom: 50px; margin-top: 20px;">
            <?=$about_item['content']?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
} else {
    echo "Box not found.";
}
?>