<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['access'] !== 'limited') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Limited Access | EMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Header -->
  <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
    <div class="container">
      <a class="navbar-brand title" href="index.html">Energy Management System</a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <nav class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
          <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
          <li class="nav-item"><a href="login.html" class="nav-link active">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

<section class="d-flex text-white justify-content-center align-items-center" style="height:100vh; background:black;">
  <div class="text-center">
    <h2>Welcome to Limited Access</h2>
    <p>You have limited viewing rights.</p>
    <a href="login.html" class="btn btn-light">Return to Login</a>
  </div>
</section>

  <footer class="footer bg-dark text-white text-center py-4">
		<p>Connect with me on 
        <a href="https://www.linkedin.com" class="text-info" target="_blank">LinkedIn</a> 
            | Email: <a href="mailto:jpatelhvac123@gmail.com" class="text-info">Jay Patel</a>
        </p>
        <p>&copy; 2025 Energy Management System. All Rights Reserved.</p>
  </footer>
</body>
</html>
