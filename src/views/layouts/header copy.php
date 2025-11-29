<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NewDash Dashboard</title>
<link href="public/assets/css/style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex">

<!-- Sidebar -->
<div class="sidebar bg-dark text-white p-3">
    <a href="index.php" class="fs-4 fw-bold mb-4 d-block text-white">NewDash</a>
    <ul class="nav flex-column">

        <li class="nav-item has-submenu">
            <a href="#" class="sidebar-link">
                <span><i class="bi bi-speedometer2 me-2"></i> Dashboard</span>
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            <ul class="submenu">
                <li><a href="index.php?controller=DashboardController&action=index" class="sidebar-sublink">Home</a></li>
                <li><a href="#" class="sidebar-sublink">Analytics</a></li>
            </ul>
        </li>

        <li class="nav-item has-submenu">
            <a href="#" class="sidebar-link">
                <span><i class="bi bi-people me-2"></i> Users</span>
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            <ul class="submenu">
                <li><a href="index.php?controller=UserController&action=index" class="sidebar-sublink">All Users</a></li>
                <li><a href="#" class="sidebar-sublink">Add User</a></li>
            </ul>
        </li>

        <li class="nav-item has-submenu">
            <a href="#" class="sidebar-link">
                <span><i class="bi bi-gear me-2"></i> Settings</span>
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            <ul class="submenu">
                <li><a href="#" class="sidebar-sublink">Profile</a></li>
                <li><a href="#" class="sidebar-sublink">Preferences</a></li>
            </ul>
        </li>

    </ul>
</div>

<!-- Main -->
<div class="main flex-grow-1 bg-light min-vh-100">

    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
      <div class="container-fluid">
        <!-- Sidebar Toggle -->
        <button class="btn btn-outline-secondary d-lg-none me-2" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>

        <!-- Title -->
        <span class="navbar-brand mb-0 h1 d-none d-lg-block">Dashboard</span>

        <!-- Right side -->
<div class="ms-auto d-flex align-items-center">
    <!-- Welcome Text: فقط دسکتاپ -->
    <span class="welcome-text me-3 fw-semibold text-secondary d-none d-md-inline">Welcome, Admin</span>

    <!-- User Dropdown: همیشه نمایش -->
    <div class="dropdown">
      <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="public/assets/img/avatar.png" alt="Admin" class="rounded-circle me-2" width="32" height="32">
        Admin
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Logout</a></li>
      </ul>
    </div>
</div>

      </div>
    </nav>

    <!-- Content -->
    <div class="container-fluid py-4">
