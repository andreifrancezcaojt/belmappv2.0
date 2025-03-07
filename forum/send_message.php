<?php
session_name('user_session');
session_start();
require "../includes/dbcon.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user's email and username from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT email, username FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $user_email = $user['email'];
    $username = $user['username'];
} else {
    die("User not found.");
}

// Get the form data
$subject = $_POST['subject'];
$message_body = $_POST['message'];

// Initialize PHPMailer
$mail = new PHPMailer(true);

// Start HTML structure for SweetAlert and loading animation
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sending Message</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Loading animation styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            display: none;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #28a745;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <script>
        // Show loading overlay when the form is submitted
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', () => {
                    document.getElementById('loadingOverlay').classList.add('active');
                });
            }
        });
    </script>

<?php
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'demitriivanperalta.basc@gmail.com'; // Your email address
    $mail->Password = 'uqjwwfxwlfwxksdn'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('demitriivanperalta.basc@gmail.com', 'BASC E-Library');
    $mail->addAddress('demitri.inovero@gmail.com'); // The recipient (you)
    $mail->addReplyTo($user_email, $username); // User's email as Reply-To

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = "<p><strong>Message from:</strong> $username ($user_email)</p><p>$message_body</p>";
    $mail->AltBody = "Message from: $username ($user_email)\n\n$message_body"; // Plain text version

    // Send email
    $mail->send();
    echo "<script>
        document.getElementById('loadingOverlay').classList.remove('active'); // Hide loading overlay
        Swal.fire({
            title: 'Message Sent!',
            text: 'Your message has been sent successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'thread.php'; // Redirect to threads page or any page you want
        });
    </script>";

} catch (Exception $e) {
    echo "<script>
        document.getElementById('loadingOverlay').classList.remove('active'); // Hide loading overlay
        Swal.fire({
            title: 'Error!',
            text: 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.history.back(); // Go back to the previous page
        });
    </script>";
}
?>
</body>
</html>
