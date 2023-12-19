<?php
session_start();
include "db_connect/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, trim($_POST['clinic_email']));
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if new password and confirm password match
    if ($new_password != $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $resultAccounts = mysqli_query($conn, "SELECT * FROM zp_accounts WHERE clinic_email = '$email'");
        $countAccounts = mysqli_num_rows($resultAccounts);
        $resultClientRecord = mysqli_query($conn, "SELECT * FROM zp_client_record WHERE client_email = '$email'");
        $countClientRecord = mysqli_num_rows($resultClientRecord);

        if ($countAccounts > 0) {
            mysqli_query($conn, "UPDATE zp_accounts SET clinic_password = '$hashed_password' WHERE clinic_email = '$email'");
            header("Location: login.php");
            exit();
        } elseif ($countClientRecord > 0) {
            mysqli_query($conn, "UPDATE zp_client_record SET client_password = '$hashed_password' WHERE client_email = '$email'");
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Email not found. Please try again.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.19.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="t/images/icon1.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
    $(document).ready(function () {
        // Add custom rule for strong passwords
        $.validator.addMethod("strongPassword", function (value, element) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
        }, "Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, one number, and one special character.");

        // Initialize form validation
        $("#signUpForm").validate({
            rules: {
                new_password: {
                    required: true,
                    strongPassword: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#form2ExamplePassword"
                }
            },
            messages: {
                new_password: {
                    required: "Please enter a password."
                },
                confirm_password: {
                    required: "Please enter the same password again.",
                    equalTo: "Passwords do not match."
                }
            },
            errorElement: "div",
            errorPlacement: function (error, element) {
                // Add the 'invalid-feedback' class to the error message
                error.addClass("invalid-feedback");
                // Add the error message after the input element
                error.insertAfter(element);
            },
            highlight: function (element, errorClass, validClass) {
                // Add the 'is-invalid' class to the input element when it is invalid
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element, errorClass, validClass) {
                // Remove the 'is-invalid' class from the input element when it is valid
                $(element).removeClass("is-invalid");
            }
        });
    });
</script>
</head>
<body style="background-color: #6537AE;">
<div class="container-fluid" style="background-color: #6537AE;">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-sm-10 col-md-8 col-lg-8 animate__animated animate__fadeIn">
        
            <div class="card shadow">
                 <div class="card-header d-flex justify-content-end">
                    <a href="index.php" class="btn-close" aria-label="Close"></a>
                </div>
                <div class="card-body p-4"> <!-- Added padding class p-4 -->
                    <div class="row">
                        <div class="col-lg-6 m-auto">
                            <img src="./t/images/Reset password-amico.svg" alt="" class=" d-none d-lg-block  img-fluid">
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center mb-4">
                                <img src="t/images/6.png" style="width: 125px;" alt="logo" class="mb-3">
                                <h2 class="text-center" style="font-family: Lora;">RESET YOUR PASSWORD</h2>
                            </div>
                            <form method="post" id="signUpForm" class="needs-validation" novalidate>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="password" id="form2ExamplePassword" class="form-control" name="new_password" placeholder="Enter your Password" required />
                                    <label for="password">New Password</label>
                                </div>

                                <div class="form-floating mb-3 mt-3">
                                    <input type="password" id="form2ExampleConfirmPassword" class="form-control" name="confirm_password" placeholder="Confirm Password" required />
                                    <label for="confirm_password">Confirm Password</label>
                                </div>
                                <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="showPasswordsCheckbox">
                                        <label class="form-check-label" for="showPasswordsCheckbox">Show Passwords</label>
                                    </div>
                                <input type="hidden" name="clinic_email" value="<?php echo htmlspecialchars($_GET['email']); ?>" />
                                <div class="mb-3">
                                    <?php if (!empty($error_message)) : ?>
                                        <div class="alert alert-danger animate__animated animate__fadeIn" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-center pt-1 mb-5 pb-1">
                                    <button type="submit" name="reset_password" value="Reset Password" class="btn w-100 text-white my-3" style="background-color: #6537AE;">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // ... Your existing code ...

        // Show/hide passwords
        $("#showPasswords").on('click', function () {
            var newPasswordField = $("#form2ExamplePassword");
            var confirmPasswordField = $("#form2ExampleConfirmPassword");
            var type = newPasswordField.attr('type');

            if (type === 'password') {
                type = 'text';
            } else {
                type = 'password';
            }

            newPasswordField.attr('type', type);
            confirmPasswordField.attr('type', type);
        });

        // Toggle password visibility for both password fields with a single checkbox
        $("#showPasswordsCheckbox").on('change', function () {
            var newPasswordField = $("#form2ExamplePassword");
            var confirmPasswordField = $("#form2ExampleConfirmPassword");
            var type = newPasswordField.attr('type');

            if (type === 'password') {
                type = 'text';
            } else {
                type = 'password';
            }

            newPasswordField.attr('type', type);
            confirmPasswordField.attr('type', type);
        });
    });
</script>
</body>
</html>
