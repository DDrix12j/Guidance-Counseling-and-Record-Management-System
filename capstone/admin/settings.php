<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/setting.php";
        $setting = getSetting($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="tntsannexicon.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f9f9fb;
    }

    .settings-container {
      display: flex;
      gap: 2rem;
      padding-top: 20px;
    }

    .nav-pills {
      background-color: #fff;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      width: 220px;
    }

    .nav-pills .nav-link {
      color: #333;
      font-weight: 500;
      border-radius: 8px;
      margin-bottom: 10px;
      transition: background 0.2s ease-in-out;
    }

    .nav-pills .nav-link.active,
    .nav-pills .nav-link:hover {
      background-color: #0d6efd;
      color: #fff;
    }

    .form-section {
      flex-grow: 1;
    }

    .form-card {
      background: #fff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .form-card h5 {
      font-weight: bold;
      margin-bottom: 1rem;
      border-bottom: 1px solid #ddd;
      padding-bottom: 0.5rem;
    }

    .form-label {
      font-weight: 500;
    }

    .btn-primary {
      padding: 10px 30px;
      font-weight: 500;
      border-radius: 8px;
    }

    .img-preview {
      margin-top: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
<?php include "inc/navbar.php"; ?>
<div class="container mt-4">
  <form method="post" class="form-w scrollable-form" action="req/setting-edit.php" enctype="multipart/form-data">
    <h3 class="mb-3">Edit Settings</h3>
    <hr>

    <?php if (isset($_GET['error'])) { ?>
      <div class="alert alert-danger"><?= $_GET['error'] ?></div>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
      <div class="alert alert-success"><?= $_GET['success'] ?></div>
    <?php } ?>

    <div class="settings-container">
      <!-- Side Navigation Tabs -->
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="school-tab" data-bs-toggle="pill" data-bs-target="#school" type="button" role="tab">School</button>
        <button class="nav-link" id="navbar-tab" data-bs-toggle="pill" data-bs-target="#navbar" type="button" role="tab">Navigation Bar</button>
        <button class="nav-link" id="news-tab" data-bs-toggle="pill" data-bs-target="#news" type="button" role="tab">News Section</button>
        <button class="nav-link" id="admin-tab" data-bs-toggle="pill" data-bs-target="#admin" type="button" role="tab">Admin</button>
        <button class="nav-link" id="career-tab" data-bs-toggle="pill" data-bs-target="#career" type="button" role="tab">Career Assessment</button>
        <button class="nav-link" id="about-tab" data-bs-toggle="pill" data-bs-target="#about" type="button" role="tab">About Us</button>
      </div>

      <!-- Tab Content -->
      <div class="tab-content form-section" id="v-pills-tabContent">
        <!-- School Tab -->
        <div class="tab-pane fade show active form-card" id="school" role="tabpanel">
          <h5>School Information</h5>
          <div class="mb-3">
            <label class="form-label">School Name</label>
            <input type="text" class="form-control" value="<?= $setting['school_name'] ?>" name="school_name">
          </div>
          <div class="mb-3">
            <label class="form-label">Navigation Bar Title</label>
            <input type="text" class="form-control" value="<?= $setting['slogan'] ?>" name="slogan">
          </div>
          <div class="mb-3">
            <label class="form-label">School Logo</label>
            <input type="file" class="form-control" name="school_logo">
            <?php if ($setting['school_logo']) { ?>
              <img src="../img/<?= $setting['school_logo'] ?>" alt="School Logo" width="100" class="img-preview">
            <?php } ?>
          </div>
        </div>

        <!-- Navigation Bar Tab -->
        <div class="tab-pane fade form-card" id="navbar" role="tabpanel">
          <h5>Navigation Bar Settings</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Navigation Bar Color</label>
              <input type="color" class="form-control" value="<?= $setting['primary_color'] ?>" name="primary_color">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Navigation Bar Font Color</label>
              <input type="color" class="form-control" value="<?= $setting['secondary_color'] ?>" name="secondary_color">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Background Color</label>
            <input type="color" class="form-control" value="<?= $setting['background_color'] ?>" name="background_color">
          </div>
        </div>

        <!-- News Section Tab -->
        <div class="tab-pane fade form-card" id="news" role="tabpanel">
          <h5>News Section Style</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">News Section Background Color</label>
              <input type="color" class="form-control" value="<?= $setting['news_section_color'] ?>" name="news_section_color">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">News Section Font Color</label>
              <input type="color" class="form-control" value="<?= $setting['news_section_font_color'] ?>" name="news_section_font_color">
            </div>
          </div>
          <div class="mt-3">
            <a href="news.php" class="btn btn-primary">Manage News</a>
          </div>
        </div>

        <div class="tab-pane fade form-card" id="admin" role="tabpanel">
          <h5>Admin Section</h5>
          <div class="mt-3">
            <a href="admin-manage.php" class="btn btn-primary">Manage Admins</a>
          </div>
        </div>

        <div class="tab-pane fade form-card" id="career" role="tabpanel">
          <h5>Career Assessment Settings</h5>
          <div class="mt-3">
            <a href="quiz-manage.php" class="btn btn-primary">Manage Career Assessment</a>
          </div>
        </div>

        <div class="tab-pane fade form-card d-flex flex-column justify-content-center align-items-center" id="about" role="tabpanel" style="min-height: 300px;">
  <h5 class="mb-3">About Us Section</h5>
  <p class="text-center mb-4" style="max-width: 500px;">
    Manage and update the About Us page details here.
  </p>
  <a href="about_manage.php" class="btn btn-primary">Manage About Us</a>
</div>

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
  } else {
    header("Location: ../login.php");
    exit;
  } 
} else {
  header("Location: ../login.php");
  exit;
}
?>
