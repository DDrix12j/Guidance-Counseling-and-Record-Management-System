<div class="d-flex">
  <nav id="sidebar" class="sidebar bg-light d-flex flex-column vh-100 shadow" style="width: 250px;">
    <div class="text-center py-4 border-bottom">
      <h6 class="mt-2 fw-bold link-text">Admin Panel</h6>
    </div>

    <ul class="nav flex-column">
      <li class="nav-item"><a href="index.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-chart-line me-2"></i><span class="link-text">Dashboard</span></a></li>
      <li class="nav-item"><a href="student.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-user-graduate me-2"></i><span class="link-text">Student Masterlist</span></a></li>
      <li class="nav-item"><a href="teacher.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-chalkboard-teacher me-2"></i><span class="link-text">Teacher Masterlist</span></a></li>
      <li class="nav-item"><a href="class.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-school me-2"></i><span class="link-text">Class Management</span></a></li>
      <li class="nav-item"><a href="grade.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-layer-group me-2"></i><span class="link-text">Grade Management</span></a></li>
      <li class="nav-item"><a href="course.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-book me-2"></i><span class="link-text">Subjects/Courses</span></a></li>
      <li class="nav-item"><a href="section.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-layer-group me-2"></i><span class="link-text">Section Management</span></a></li>
      <li class="nav-item"><a href="teacher-invite.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-user-plus me-2"></i><span class="link-text">Invite Teacher</span></a></li>
      <li class="nav-item"><a href="counseling.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-comments me-2"></i><span class="link-text">Counseling</span></a></li>
      <li class="nav-item"><a href="violations.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-exclamation-triangle me-2"></i><span class="link-text">Violations</span></a></li>
      <li class="nav-item"><a href="message.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-envelope me-2"></i><span class="link-text">Request & Support</span></a></li>
      <li class="nav-item"><a href="settings.php" class="nav-link link-dark fs-6 py-3"><i class="fa-solid fa-cogs me-2"></i><span class="link-text">Settings</span></a></li>
    </ul>
  

    <div class="p-3 border-top">
      <button id="toggleMode" class="btn btn-lg btn-outline-secondary w-100 mb-2">
        <i class="fa-solid fa-moon me-2"></i><span class="link-text">Toggle Dark Mode</span>
      </button>
      <a href="../logout.php" class="btn btn-lg btn-danger w-100 mb-2">
        <i class="fa-solid fa-right-from-bracket me-2"></i><span class="link-text">Logout</span>
      </a>
      <button id="minimizeSidebar" class="btn btn-sm btn-outline-secondary w-100">
        <i class="fa-solid fa-angles-left"></i>
      </button>
    </div>
  </nav>

  <div class="flex-grow-1 p-3" id="mainContent">
    <!-- Main Content Here -->
  </div>
</div>

<style>
  /* Nav link styling */
.nav-link {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  border-radius: 8px;
  transition: background-color 0.3s, transform 0.2s;
}


  /* Main layout */
  #sidebar {
    width: 250px;
    transition: width 0.3s;
  }

  #mainContent {
    margin-left: 0;
    padding-left: 20px;
    transition: margin-left 0.3s;
  }

  /* Minimized sidebar styles */
  body.sidebar-minimized #sidebar {
    width: 80px !important;
  }

  body.sidebar-minimized .link-text {
    display: none !important;
  }

body.sidebar-minimized .nav-link {
  justify-content: center !important;
  padding: 0.75rem !important;
}

body.sidebar-minimized .nav-link i {
  margin: 0 !important;
  font-size: 1.2rem;
}
  body.sidebar-minimized #minimizeSidebar {
    margin-left: auto;
    margin-right: auto;
    display: block;
  }

  /* Dark Mode Styling */
  .dark-mode {
    background-color: #1e1e2f !important;
    color: white !important;
  }

  .dark-mode .nav-link {
    color: #ccc !important;
  }

  .dark-mode .nav-link:hover {
    background-color: #343a40;
  }

  .dark-mode .sidebar {
    background-color: #2c2c3e !important;
  }

  .dark-mode #mainContent {
    background-color: #1a1a28;
    color: #f1f1f1;
  }

  .btn-lg {
    font-size: 1.2rem;
    padding: 12px;
  }

  .dark-mode .btn-outline-secondary {
    background-color: #444 !important;
    border-color: #444 !important;
    color: #ccc !important;
  }

  .dark-mode .btn-outline-secondary:hover {
    background-color: #555 !important;
  }

  .dark-mode table,
  .dark-mode th,
  .dark-mode td {
    background-color: #2c2c3e !important;
    color: #f1f1f1 !important;
    border-color: #444 !important;
  }

  .dark-mode .btn,
  .dark-mode button {
    background-color: #444 !important;
    color: #f1f1f1 !important;
    border-color: #555 !important;
  }

  .dark-mode .btn:hover,
  .dark-mode button:hover {
    background-color: #555 !important;
    border-color: #666 !important;
  }

  .dark-mode input,
  .dark-mode select,
  .dark-mode textarea {
    background-color: #2c2c3e !important;
    color: #f1f1f1 !important;
    border-color: #444 !important;
  }

  .dark-mode input::placeholder,
  .dark-mode textarea::placeholder {
    color: #ccc !important;
  }

  .dark-mode label {
    color: #f1f1f1 !important;
  }

  .dark-mode .nav-tabs .nav-link.active {
    background-color: #444 !important;
    color: #f1f1f1 !important;
  }

  .dark-mode .nav-tabs .nav-link {
    background-color: #2c2c3e !important;
    color: #ccc !important;
  }

  .dark-mode .nav-tabs .nav-link:hover {
    background-color: #343a40 !important;
    color: #f1f1f1 !important;
  }
</style>

<script>
  const toggleButton = document.getElementById('toggleMode');
  const minimizeButton = document.getElementById('minimizeSidebar');

  // Dark mode handler
  function applyDarkMode(saved) {
    if (saved === 'true') {
      document.body.classList.add('dark-mode');
    } else {
      document.body.classList.remove('dark-mode');
    }
  }

  // Load dark mode preference
  document.addEventListener('DOMContentLoaded', () => {
    const savedDark = localStorage.getItem('darkMode');
    applyDarkMode(savedDark);

    const minimized = localStorage.getItem('sidebarMinimized') === 'true';
    document.body.classList.toggle('sidebar-minimized', minimized);
  });

  // Toggle dark mode
  toggleButton.addEventListener('click', () => {
    const isDark = document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', isDark);
  });

  // Toggle sidebar minimize
  minimizeButton.addEventListener('click', () => {
    const isMinimized = document.body.classList.toggle('sidebar-minimized');
    localStorage.setItem('sidebarMinimized', isMinimized);
  });
</script>

<!-- Required CDN for Bootstrap & FontAwesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
