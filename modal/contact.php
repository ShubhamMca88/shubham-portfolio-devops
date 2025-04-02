<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Ensure the request is a POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die(json_encode(['status' => 'error', 'message' => 'Invalid request method']));
}

// Fetching form values safely
$php_name = htmlspecialchars($_POST['ajax_name'], ENT_QUOTES, 'UTF-8');
$php_email = filter_var($_POST['ajax_email'], FILTER_SANITIZE_EMAIL);
$php_message = htmlspecialchars($_POST['ajax_message'], ENT_QUOTES, 'UTF-8');

// Validate email
if (!filter_var($php_email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
    exit;
}

// Gmail credentials
$gmail_username = "shubhammca88@gmail.com";
$gmail_password = "nkfo quxg takj twqw"; // Replace with correct App Password

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $gmail_username;
    $mail->Password = $gmail_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email Headers
    $mail->setFrom($php_email, $php_name);
    $mail->addAddress("shubhammca88@gmail.com"); // Your email
    $mail->addReplyTo($php_email, $php_name);

    // Email Content
    $mail->isHTML(true);
    $mail->Subject = "New Contact Form Message";
    $mail->Body = "
        <div style='padding:20px; background-color:#f5f5f5; color:#333;'>
            <h3>Contact Form Message</h3>
            <strong style='color:#f00a77;'>Name:</strong> $php_name<br>
            <strong style='color:#f00a77;'>Email:</strong> $php_email<br>
            <strong style='color:#f00a77;'>Message:</strong> $php_message<br><br>
            <p>We will get back to you soon.</p>
        </div>
    ";

    // Send Email
    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Message has been sent successfully!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Error: {$mail->ErrorInfo}"]);
}
?>