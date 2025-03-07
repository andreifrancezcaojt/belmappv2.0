<?php
require_once "controllerUserData.php";

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the currently logged-in user's ID (from session or other method)
    $user_id = $_SESSION['user_id'];  // Assuming the user ID is stored in the session

    // Get the input values from the form
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $alert = "All fields are required.";
        $alert_type = 'error';
    } elseif ($new_password !== $confirm_password) {
        $alert = "New password and confirm password do not match.";
        $alert_type = 'error';
    } else {
        // Check if the old password is correct
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param("i", $user_id);  // Bind the user_id (int)
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify the old password
        if (password_verify($old_password, $user['password'])) {
            // Old password is correct, now update the password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);  // Hash the new password

            // Update the password in the database
            $update_query = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            if ($update_stmt === false) {
                die('MySQL prepare error: ' . $conn->error);
            }

            $update_stmt->bind_param("si", $hashed_new_password, $user_id);  // Bind hashed password and user_id (int)
            if ($update_stmt->execute()) {
                $alert = "Password successfully updated.";
                $alert_type = 'success';
                $redirect = 'home.php'; // Redirect to home or another page after successful password change
            } else {
                $alert = "Error updating password: " . $update_stmt->error;
                $alert_type = 'error';
            }
        } else {
            $alert = "Old password is incorrect.";
            $alert_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- Load SweetAlert2 Script -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Custom button style */
        .btn-custom {
            background-color: #28a745;
            border-color: #28a745;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .navbar-dark .navbar-toggler {
            border-color: #ffffff00;
            /* Toggler border color */
        }

        /* Adjusting the position of the eye icon */
        .eye-icon {
            position: absolute;
            right: 10px;
            /* Adjust the right value to bring it closer to the input field */
            top: 75%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            /* Reduced size for better alignment */
        }

        .form-group {
            position: relative;
        }

        .form-control {
            padding-right: 40px;
            /* Add extra padding to the right side for the icon */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow bg-success">
        <img class="logo" src="../assets/icon/library_logo_nbg.png" alt="Library Logo" style="width: 40px; height: 40px;">
        <a class="navbar-brand ml-2" href="../credentials/home.php">BASC E-Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon d-none sm "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"></ul>
        </div>
    </nav>
    <br><br><br>

    <div class="container mt-1">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Back button -->
            <a href="home.php" class="btn text-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <h2 class="text-center">Change Your Password</h2>

        <div class="jumbotron mt-4 p-4">
            <form action="change_password.php" method="post">
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-control" required>
                    <i class="eye-icon" id="toggleOldPassword"><i class="fas fa-eye-slash"></i></i>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                    <i class="eye-icon" id="toggleNewPassword"><i class="fas fa-eye-slash"></i></i>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    <i class="eye-icon" id="toggleConfirmPassword"><i class="fas fa-eye-slash"></i></i>
                </div>
                <button type="submit" name="submit" class="btn btn-custom text-light btn-block">Change Password</button>
            </form>
        </div>
    </div>

    <footer class="footer mt-auto py-4">
        <div class="text-center">
            <span class="text-muted">© <?php echo date("Y"); ?> BASC E-Library | Bulacan Agricultural State College.</span>
        </div>
    </footer>

    <!-- Scripts for SweetAlert2 and other libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($alert)): ?>
        <script>
            Swal.fire({
                title: '<?php echo $alert_type == 'success' ? 'Success!' : 'Error!'; ?>',
                text: '<?php echo $alert; ?>',
                icon: '<?php echo $alert_type; ?>',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '<?php echo isset($redirect) ? $redirect : 'change_password.php'; ?>';
            });
        </script>
    <?php endif; ?>

    <script>
        // Toggle visibility of passwords while the eye icon is pressed
        let isOldPasswordVisible = false;
        let isNewPasswordVisible = false;
        let isConfirmPasswordVisible = false;

        const newPasswordField = document.getElementById('new_password');
        const confirmPasswordField = document.getElementById('confirm_password');
        const toggleNewPasswordIcon = document.getElementById('toggleNewPassword');
        const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPassword');
        const oldPasswordField = document.getElementById('old_password');
        const toggleOldPasswordIcon = document.getElementById('toggleOldPassword');


        toggleOldPasswordIcon.addEventListener('mousedown', function() {
            isOldPasswordVisible = true;
            oldPasswordField.type = 'text';
            toggleOldPasswordIcon.querySelector('i').classList.remove('fa-eye-slash');
            toggleOldPasswordIcon.querySelector('i').classList.add('fa-eye');
        });

        toggleOldPasswordIcon.addEventListener('mouseup', function() {
            isOldPasswordVisible = false;
            oldPasswordField.type = 'password';
            toggleOldPasswordIcon.querySelector('i').classList.remove('fa-eye');
            toggleOldPasswordIcon.querySelector('i').classList.add('fa-eye-slash');
        });

        toggleNewPasswordIcon.addEventListener('mousedown', function() {
            isNewPasswordVisible = true;
            newPasswordField.type = 'text';
            toggleNewPasswordIcon.querySelector('i').classList.remove('fa-eye-slash');
            toggleNewPasswordIcon.querySelector('i').classList.add('fa-eye');
        });

        toggleNewPasswordIcon.addEventListener('mouseup', function() {
            isNewPasswordVisible = false;
            newPasswordField.type = 'password';
            toggleNewPasswordIcon.querySelector('i').classList.remove('fa-eye');
            toggleNewPasswordIcon.querySelector('i').classList.add('fa-eye-slash');
        });

        toggleConfirmPasswordIcon.addEventListener('mousedown', function() {
            isConfirmPasswordVisible = true;
            confirmPasswordField.type = 'text';
            toggleConfirmPasswordIcon.querySelector('i').classList.remove('fa-eye-slash');
            toggleConfirmPasswordIcon.querySelector('i').classList.add('fa-eye');
        });

        toggleConfirmPasswordIcon.addEventListener('mouseup', function() {
            isConfirmPasswordVisible = false;
            confirmPasswordField.type = 'password';
            toggleConfirmPasswordIcon.querySelector('i').classList.remove('fa-eye');
            toggleConfirmPasswordIcon.querySelector('i').classList.add('fa-eye-slash');
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>