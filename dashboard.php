<?php
session_start();

// If user not logged in → redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<p>You are successfully logged in.</p>

<a href="logout.php">Logout</a>

</body>
</html>
