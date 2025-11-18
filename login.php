<?php
session_start();
include 'db.php';

header("Content-Type: application/json");

// ---------------------------------------------
//  PHPMailer
// ---------------------------------------------
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// ---------------------------------------------
//  FUNCTION: SEND REGISTRATION EMAILS
// ---------------------------------------------
function sendRegistrationEmails($fname, $lname, $email, $phone, $plainPassword) {

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jpatelhvac123@gmail.com';
        $mail->Password = 'hywy likw ewgj bcrj';  // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // ------------------------------------------------
        // Send ADMIN notification
        // ------------------------------------------------
        $mail->setFrom('jpatelhvac123@gmail.com', 'EMS Registration System');
        $mail->addAddress('jpatelhvac123@gmail.com'); 
        $mail->isHTML(true);
        $mail->Subject = 'EMS Website Registration';
        $mail->Body = "
            <h2>New User Registered</h2>
            <p><strong>Name:</strong> $fname $lname</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Password (unencrypted):</strong> $plainPassword</p>
        ";
        $mail->send();

        // ------------------------------------------------
        // Send USER confirmation email
        // ------------------------------------------------
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = "Welcome to EMS - Registration Successful";
        $mail->Body = "
            Dear $fname,<br><br>
            Thank you for registering at EMS.<br>
            Your account has been created successfully.<br><br>
            <strong>Email:</strong> $email<br>
            <strong>Password:</strong> $plainPassword<br><br> 
            Regards,<br>
            Jay Patel - Sr. Controls System Engineer
        ";
        $mail->send();

        return true;

    } catch (Exception $e) {
        return false;
    }
}

// ---------------------------------------------
//  USER REGISTRATION
// ---------------------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'register') {

    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $plainPassword = $_POST['password']; // used for email
    $password = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
        exit;
    }

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, phone, password)
                            VALUES (:fname, :lname, :email, :phone, :password)");

    $ok = $stmt->execute([
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'phone' => $phone,
        'password' => $password
    ]);

    if ($ok) {
        // Send emails
        sendRegistrationEmails($fname, $lname, $email, $phone, $plainPassword);
        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
    }

    exit;
}

// ---------------------------------------------
//  LOGIN
// ---------------------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'login') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $passphrase = $_POST['passphrase'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user;

        // Access control
        if ($passphrase === "Unihvac123") {
            $_SESSION['access'] = "full";
            $redirect = "ems-sites.php";

        } elseif ($passphrase === "Unihvac@123") {
            $_SESSION['access'] = "full";
            $redirect = "https://jay19991.github.io/portfolio/";

        } else {
            $_SESSION['access'] = "limited";
            $redirect = "ems-sites1.php";
        }

        echo json_encode(['status' => 'success', 'redirect' => $redirect]);
    } 
    else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    }

    exit;
}

?>
