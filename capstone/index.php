<?php 
require_once "DB_connection.php";

$sql = "INSERT INTO website_visits (visit_time) VALUES (NOW())";
$stmt = $conn->prepare($sql);
$stmt->execute();


require_once "data/setting.php";
require_once "data/news.php"; // Include the news data file
$setting = getSetting($conn);

if ($setting != 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
    overflow: hidden; /* Prevent scrolling on the entire page */
    background: url('img/<?=$setting['background_image']?>') no-repeat center center fixed; 
    background-size: cover;
    background-color: <?=$setting['background_color']?>;
    font-family: <?=$setting['font_style']?>;
}

.body-home {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Align content to the top */
    align-items: center;
    color: #fff;
    padding: 0px; /* Add padding for spacing */
    margin: 0; /* Remove all margins */
    width: 100%; /* Ensure full width */
    overflow-y: auto; /* Enable vertical scrolling */
    max-height: 100vh; /* Limit height to viewport */
    box-sizing: border-box; /* Include padding in height calculation */
    background-color: #fff; /* Add white background to hide margins */
}

.black-fill {
    background: rgba(0, 0, 0, 0.9);
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: #fff;
    width: 100%; /* Ensure full width */
    margin: 0; /* Remove left and right margins */
    padding: 0 20px; /* Optional: Add padding inside the black-fill */
    box-sizing: border-box; /* Include padding in width calculation */
}
.carousel-item img {
    width: 100%; /* Make the image span the full width of the viewport */
    height: 80%; /* Make the image span the full height of the viewport */
    object-fit: contain; /* Ensure the entire image is visible without cropping */
}

.carousel-container {
    opacity: 0; /* Start hidden */
    animation: slideUp 1s ease-out forwards; /* Slide up animation */
}

@keyframes slideUp {
    from {
        transform: translateY(100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.news-announcements {
    padding: 20px;
    background-color: <?=$setting['news_section_color']?>; /* Use the new setting */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 0px;
    width: 100%;
    opacity: 0; /* Start hidden */
    transform: translateX(100px); /* Start off-screen to the right */
    transition: opacity 1s ease-out, transform 1s ease-out; /* Smooth animation */
}

.news-announcements.visible {
    opacity: 1; /* Fully visible */
    transform: translateX(0); /* Slide into position */
}

.news-announcements h2 {
    text-align: center;
    margin-top: 40px;
    margin-bottom: 75px;
    font-family: <?=$setting['news_section_font']?>, sans-serif;
    font-weight: bold;
    color: <?=$setting['news_section_font_color']?>; /* Use the new setting */
    font-size: 50px;
}
.news-card-title {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: <?=$setting['news_section_font_color']?>; /* Use the new setting */
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 3rem; /* Increase the width */
    height: 3rem; /* Increase the height */
    background-size: 100%, 100%; /* Ensure the background image covers the entire area */
}
.news-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s;
    margin-bottom: 200px;
}
.news-card:hover {
    transform: translateY(-50px);
}
.news-card img {
    width: 100%;
    height: auto;
}
.news-card-body {
    padding: 15px;
}
.news-card-title {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color:#9f1015; /* Change font color to red */
}
.news-card-date {
    font-size: 0.9rem;
    color: #000; /* Change font color to black */
    margin-bottom: 10px;
}
.news-card-content {
    font-size: 1rem;
    color: gray; /* Change font color to gray */
}
.news-card-link {
    display: block;
    margin-top: 10px;
    font-size: 1rem;
    color:#9f1015; /* Change link color to red */
    text-decoration: none; /* Remove underline */
    cursor: pointer;
}
.news-card-link:hover {
    color: darkred; /* Change link hover color to dark red */
}
@media (min-width: 768px) {
    .news-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}
@media (min-width: 992px) {
    .news-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
.news-card img {
    width: 100%; /* Make the image span the full width */
    height: 200px; /* Set a fixed height */
    object-fit: cover; /* Ensure the image covers the area without distortion */
}
</style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="body-home" >
        <div class="black-fill">
        <div class="carousel-container">
            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <?php
                    $news = getNews($conn); // Fetch news from the database
                    $active = 'active';
                    foreach ($news as $item) {
                        echo "<div class='carousel-item $active'>";
                        if (!empty($item['image'])) {
                            echo "<img src='uploads/{$item['image']}' alt='{$item['title']}' class='mx-auto d-block'>";
                        }
                        echo "</div>";
                        $active = '';
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
            <section class="news-announcements" id="newsSection">
                <h2>News and Updates</h2>
                <div class="news-grid">
                    <?php
                    foreach ($news as $item) {
                        echo "<div class='news-card'>";
                        if (!empty($item['image'])) {
                            echo "<img src='uploads/{$item['image']}' alt='{$item['title']}'>";
                        }
                        echo "<div class='news-card-body'>";
                        echo "<div class='news-card-title'>{$item['title']}</div>";
                        echo "<div class='news-card-date'>Posted on: {$item['date']}</div>";
                        echo "<div class='news-card-content'>{$item['content']}</div>";
                        echo "<a class='news-card-link' href='news_details.php?id={$item['id']}'>Read More &rarr;</a>"; // Change link text and add arrow
                        echo "</div></div>";
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // IntersectionObserver to trigger animation when the section is in view
        document.addEventListener("DOMContentLoaded", function () {
            const newsSection = document.querySelector("#newsSection");
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        newsSection.classList.add("visible");
                    }
                });
            }, { threshold: 0.1 });
            observer.observe(newsSection);
        });
    </script>
</body>
</html>
<?php
}
?>