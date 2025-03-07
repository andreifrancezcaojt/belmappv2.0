<?php 
session_name('user_session');
session_start();

require "../includes/dbcon.php";



// //echo $_SERVER['REQUEST_URI'];
// $servername = "localhost:3307";
// $username = "root";
// $password = "";
// $dbname = "cap";


// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Check if the function exists before declaring it
// if (!function_exists('getMostActiveUser')) {
//     function getMostActiveUser($conn)
//     {
//         $q = "SELECT a.username, COUNT(b.user_id) AS login_count
//               FROM users a
//               LEFT JOIN login_history b ON a.id = b.user_id
//               GROUP BY a.username
//               ORDER BY login_count DESC
//               LIMIT 1";
//         $result = mysqli_query($conn, $q);

//         if ($result && mysqli_num_rows($result) > 0) {
//             $row = mysqli_fetch_assoc($result);
//             return $row['username'];
//         } else {
//             return "No users found";
//         }
//     }
// }

// function get($sql)
// {
//     error_reporting(0);
//     global $conn;
//     $rs = mysqli_query($conn, $sql);
//     $rw = mysqli_fetch_array($rs);
//     return $rw[0];
// }

// function getbooks() {
//     global $conn;
//     // $b = mysqli_query($conn, 'SELECT a.id, a.pdf_id, a.rating, b.pdf_name, a.views
//     //                            FROM ratings a
//     //                            JOIN pdf_file b ON a.pdf_id = b.id
//     //                            ORDER BY a.views DESC
//     //                            LIMIT 3');
//     $b = mysqli_query($conn, 'SELECT * FROM pdf_file ORDER BY views DESC LIMIT 3');
//     $bks = array();
//     $views = array();
    
//     while($rw = mysqli_fetch_array($b)) {
//         $bks[] = $rw['pdf_name'];
//         $views[] = $rw['views']; // Add views to the array
//     }
    
//     return array('names' => $bks, 'views' => $views); // Return both names and views
// }



// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
include '../phpmailer/src/PHPMailer.php';
include '../phpmailer/src/SMTP.php';
include '../phpmailer/src/Exception.php';

$username = "";
$id = ""; 
$email = "";
$errors = array();

// If user signup button is clicked
if (isset($_POST['signup'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    // Check if Student ID exists in either the students or instructors table
    $student_or_instructor_check = "
    SELECT student_id AS id, fullname, NULL AS course
    FROM students
    WHERE student_id = '$id'
    UNION
    SELECT instructor_id AS id, fullname, NULL AS course
    FROM instructors
    WHERE instructor_id = '$id'
";

    $res = mysqli_query($conn, $student_or_instructor_check);

    if (!$res) {
        die("Query failed: " . mysqli_error($conn)); // Output SQL error if query fails
    }

    if (mysqli_num_rows($res) == 0) {
        $errors['id'] = "Your ID is not included in the system!";
    }

    // Check if passwords match
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }

    // Check if email already exists in the users table
    $email_check = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($conn, $email_check);

    if (!$res) {
        die("Query failed: " . mysqli_error($conn)); // Output SQL error if query fails
    }

    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = "Email that you have entered already exists!";
    }

    // Proceed only if there are no errors so far
    if (count($errors) === 0) {
        // Email validity check
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $code = rand(999999, 111111);
            $status = "notverified";

            // PHPMailer setup to send verification email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'demitriivanperalta.basc@gmail.com'; // Your email address
                $mail->Password   = 'uqjwwfxwlfwxksdn';    // Your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587; // Typically port 587 for TLS

                // Recipients
                $mail->setFrom('demitriivanperalta.basc@gmail.com', 'BASC E-Library');
                $mail->addAddress($email); // Add the user's email

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'BASC E-Library Email Verification Code';
                $mail->Body    = "Your verification code is $code";
                $mail->AltBody = "
                Thank you for registering with BASC E-Library! 
                To ensure your account is secure and ready for use, please verify your email by entering this code : $code.
                
                Once verified, you'll have access to a wealth of digital resources at your fingertips. 
                If you didn't sign up, you can safely ignore this email.
                We look forward to supporting your learning journey!"; // Plain text version

                // Send email
                $mail->send();

                // Insert data into the database only if the email is successfully sent
                $insert_data = "INSERT INTO users (id, username, email, password, code, status)
                                values('$id', '$username', '$email', '$encpass', '$code', '$status')";
                $data_check = mysqli_query($conn, $insert_data);

                if (!$data_check) {
                    die("Query failed: " . mysqli_error($conn)); // Output SQL error if query fails
                }

                if ($data_check) {
                    $info = "We've sent a verification code to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    header('location: user-otp.php');
                    exit();
                } else {
                    $errors['db-error'] = "Failed while inserting data into the database!";
                }

            } catch (Exception $e) {
                // If email sending fails, display an error and prevent database insertion
                $errors['otp-error'] = "Failed while sending code! Mailer Error: {$mail->ErrorInfo}";
            }

        } else {
            $errors['email'] = "Invalid email address!";
        }
    }
}


// If user clicks the verification code submit button
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);

    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE users SET code = $code, status = '$status' WHERE code = $fetch_code";
        $update_res = mysqli_query($conn, $update_otp);
        if ($update_res) {
            $_SESSION['name'] = $username;
            $_SESSION['email'] = $email;
            header('location: login.php');
            exit();
        } else {
            $errors['otp-error'] = "Failed while updating code!";
        }
    } else {
        $errors['otp-error'] = "You've entered an incorrect code!";
    }
}

// Forgot password - sending reset code
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
        $run_query = mysqli_query($conn, $insert_code);
        if ($run_query) {
            // Send password reset code via email
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'demitriivanperalta.basc@gmail.com'; 
                $mail->Password   = 'uqjwwfxwlfwxksdn';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587; 

                //Recipients
                $mail->setFrom('demitriivanperalta.basc@gmail.com', 'BASC E-Library');
                $mail->addAddress($email); 

                // Content
                $mail->isHTML(true); 
                $mail->Subject = 'Password Reset Code';
                $mail->Body    = "
                Good day! 
                We received a request to reset your password for your BASC E-Library account. 
                Your password reset code is $code. 
                Thank you! ";
                $mail->AltBody = "Your password reset code is $code";

                // Send email
                $mail->send();
                $info = "We've sent a password reset code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } catch (Exception $e) {
                $errors['otp-error'] = "Failed while sending code! Mailer Error: {$mail->ErrorInfo}";
            }

        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "The email address you've entered does not exist.";
    }
}

// If user clicks check reset OTP button
if(isset($_POST['check-reset-otp'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered an incorrect code.";
    }
}

// If user clicks change password button
if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "Confirm password not matched.";
    } else {
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if($run_query){
            $info = "Your password has been changed. You can now login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        } else {
            $errors['db-error'] = "Failed to change your password.";
        }
    }
}

// If login now button click
if(isset($_POST['login-now'])){
    header('Location: login.php');
}

?>