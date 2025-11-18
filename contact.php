<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $company = htmlspecialchars($_POST['company']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $reason = htmlspecialchars($_POST['reason']);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jpatelhvac123@gmail.com';
        $mail->Password = 'hywy likw ewgj bcrj';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Send email to admin
        $mail->setFrom('jpatelhvac123@gmail.com', 'EMS Site');
        $mail->addAddress('jpatelhvac123@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'EMS Website - Contact Form Details';
        $mail->Body = "
            <h3>Contact Form Details</h3>
            <p><strong>Name:</strong> $fname $lname</p>
            <p><strong>Company:</strong> $company</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Reason:</strong> $reason</p>
        ";
        $mail->send();

        // Send confirmation email to user
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = 'Contact Form Submission';
        $mail->Body = "Dear $fname,<br><br>Thank you for contacting us. We will get back to you soon.<br><br>Regards, <br>Jay Patel - Sr. Controls System Engineer";
        $mail->send();

        // Redirect back to Contact.html with success message
		echo "<script>alert('Message sent successfully!');</script>";
        header("Location: contact.html?success=1");
        exit;
    } catch (Exception $e) {
        // Redirect back with error message
        $error = urlencode("Mailer Error: {$mail->ErrorInfo}");
        header("Location: contact.html?error=$error");
        exit;
    }
}
?>
