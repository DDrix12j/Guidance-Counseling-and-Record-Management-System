<?php 
require_once __DIR__ . "/../DB_connection.php";
require_once __DIR__ . "/../data/setting.php";
require_once __DIR__ . "/../data/about.php"; // Include the file to fetch about cards

$setting = getSetting($conn);
$slogan = isset($setting['slogan']) ? strtoupper($slogan = $setting['slogan']) : ''; // Convert to uppercase
$aboutCards = getAllAboutBoxes($conn); // Fetch all about cards
$current_page = basename($_SERVER['PHP_SELF']); // Get current page filename
?>
<nav class="navbar navbar-expand-lg" style="background-color: <?=$setting['primary_color']?>;">
  <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
          <img src="tntsannexicon.png" width="70" class="navbar-icon me-2"> 
          <span class="navbar-title" style="color: <?=$setting['secondary_color']?>;"> <?=$slogan?> </span>
      </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto" id="navLinks">
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">
            <i class="fa fa-home"></i> Home
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link <?= ($current_page == 'about.php') ? 'active' : '' ?>" href="about.php" id="aboutDropdown" role="button">
            <i class="fa fa-info-circle"></i> About
          </a>
          <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
            <?php foreach (array_slice($aboutCards, 0, 3) as $card) { // Limit to 3 cards ?>
              <li>
                <a class="dropdown-item" href="about_detail.php?id=<?=$card['id']?>"> <?=$card['title']?> </a>
              </li>
            <?php } ?>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link <?= ($current_page == 'services.php' || $current_page == 'contact.php' || $current_page == 'request-support.php') ? 'active' : '' ?>" href="services.php" id="guidanceDropdown" role="button">
            <i class="fa fa-compass"></i> Guidance
          </a>
          <ul class="dropdown-menu" aria-labelledby="guidanceDropdown">
            <li>
              <a class="dropdown-item <?= ($current_page == 'contact.php') ? 'active' : '' ?>" href="contact.php">Contact</a>
            </li>
            <li>
              <a class="dropdown-item <?= ($current_page == 'career-guidance.php') ? 'active' : '' ?>" href="career-guidance.php">Career Guidance</a>
            </li>
            <li>
              <a class="dropdown-item <?= ($current_page == 'request-support.php') ? 'active' : '' ?>" href="request-support.php">Request & Support</a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($current_page == 'login.php') ? 'active' : '' ?>" href="login.php">
            <i class="fa fa-sign-in"></i> Login
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  .navbar-icon {
    background-color: white;
    border-radius: 50%;
    padding: 5px; /* Adjust padding as needed */
  }
  .navbar-title {
    font-size: 1.0em; /* Adjust the font size as needed */
  }
  #navLinks .nav-item {
    margin-left: 20px; /* Reduce spacing between buttons */
  }
  .container-fluid {
    max-width: 100%; /* Ensure full width */
  }
  .navbar {
    background-color: <?=$setting['primary_color']?>;
    top: 0;
    width: 100%;
    height: 100px; /* Adjust the height as needed */
    opacity: 1;
    z-index: 1000; /* Ensure it stays on top of other elements */
    font-family: 'Montserrat', sans-serif; /* Apply Montserrat font */
    font-weight: bold; /* Make the font bold */
  }
  .navbar-nav {
    margin-right: 75px; /* Push buttons more to the left */
  }
  .navbar-nav .nav-link {
    color: <?=$setting['secondary_color']?> !important;
    font-family: 'Montserrat', sans-serif; /* Apply Montserrat font */
    font-weight: bold;
    padding: 15px 20px;
    text-transform: uppercase;
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
  }
  .navbar-nav .nav-link.active {
    background-color: #9f1015;
    border-radius: 5px;
    color: white !important;
  }
  .navbar-nav .nav-link.active:hover {
    background-color: #9f1015 !important; /* Ensure the active page retains its color */
    color: white !important;
  }
  .navbar-nav .nav-link:not(.active):hover {
    background-color: #9f1015; /* Change background color on hover for non-active links */
    color: white !important;
  }
  .dropdown-menu {
    background-color: <?=$setting['primary_color']?>; /* Match navbar background */
    border: none;
    box-shadow: none;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-20px);
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    display: block; /* Ensure dropdown is always in the DOM */
    position: absolute; /* Prevent layout issues */
  }
  .nav-item.dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0); /* Slide down effect */
  }
  .dropdown-item {
    color: <?=$setting['secondary_color']?> !important; /* Match navbar text color */
    font-family: 'Montserrat', sans-serif;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 1.2em; /* Increase font size */
    padding: 15px 20px; /* Increase padding for larger buttons */
  }
  .dropdown-item:hover {
    background-color: #9f1015; /* Highlight color on hover */
    color: white !important;
  }
</style>