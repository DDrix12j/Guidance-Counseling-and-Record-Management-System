<?php 
require_once "DB_connection.php";
require_once "data/setting.php";
require_once "data/news.php"; // Include the news data file
$setting = getSetting($conn);

// Validate and fetch the news item
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $news_item = getNewsById($conn, $id);

    if (!$news_item) {
        die("Error: News item not found.");
    }
} else {
    die("Error: Invalid or missing news ID.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($news_item['title']) ?></title>
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
            background-color: <?=$setting['background_color']?>;
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

        .news-content {
            text-align: left;
            color: black;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: normal;
            
        }

        .news-content p {
            margin: 0 0 10px 0;
            font-size: 1rem;
        }

        .news-content img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 20px auto;
            border-radius: 10px;
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
                <span><?= htmlspecialchars($news_item['title']) ?></span>
            </h2>
        </div>
        <div class="black-fill">
            <div class="container mt-5">
                <div class="news-content">
                    <?php if (!empty($news_item['image'])) { ?>
                        <img src="uploads/<?= htmlspecialchars($news_item['image']) ?>" alt="<?= htmlspecialchars($news_item['title']) ?>">
                    <?php } ?>
                    <p><?= htmlspecialchars($news_item['content']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>