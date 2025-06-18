
<div class="d-flex">
  <nav id="sidebar" class="sidebar bg-light d-flex flex-column vh-100 shadow" style="width: 250px;">
    <div class="text-center py-4 border-bottom">
      <h6 class="mt-2 fw-bold link-text">Teacher Panel</h6>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="index.php" class="nav-link link-dark fs-6 py-3">
          <i class="fa-solid fa-chart-line me-2"></i>
          <span class="link-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="classes.php" class="nav-link link-dark fs-6 py-3">
          <i class="fa-solid fa-school me-2"></i>
          <span class="link-text">Classes</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="students.php" class="nav-link link-dark fs-6 py-3">
          <i class="fa-solid fa-user-graduate me-2"></i>
          <span class="link-text">Students Grade</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="pass.php" class="nav-link link-dark fs-6 py-3">
          <i class="fa-solid fa-key me-2"></i>
          <span class="link-text">Change Password</span>
        </a>
      </li>
      <li class="nav-item mt-auto">
        <a href="../logout.php" class="nav-link link-danger fs-6 py-3">
          <i class="fa-solid fa-right-from-bracket me-2"></i>
          <span class="link-text">Logout</span>
        </a>
      </li>
    </ul>
  </nav>
  <div class="flex-grow-1 p-3" id="mainContent">
    <!-- Main Content Here -->
  </div>
</div>

<!-- FontAwesome CDN (for icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
  .sidebar {
    min-width: 250px;
    max-width: 250px;
    transition: width 0.3s;
  }
  .nav-link {
    display: flex;
    align-items: center;
    border-radius: 8px;
    transition: background-color 0.3s, transform 0.2s;
  }
  .nav-link i {
    margin-right: 8px;
  }
  .nav-link:hover {
    background-color: #e9ecef;
    transform: translateX(4px);
  }
  .link-danger {
    color: #dc3545 !important;
  }
  .link-danger:hover {
    background-color: #f8d7da !important;
    color: #dc3545 !important;
  }
  .link-text {
    font-weight: 500;
  }
  .flex-grow-1 {
    margin-left: 250px;
    padding-left: 20px;
    transition: margin-left 0.3s;
  }
</style>