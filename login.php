<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username']; 
    $password = $_POST['password'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "Login successful!";
            // Later you can redirect: header("Location: dashboard.php");

        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that username or email!";
    }

    $stmt->close();
    $conn->close();
}
?>
