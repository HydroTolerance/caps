<?php
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Add </title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/locales/bootstrap-datepicker.en.min.js"></script>
      <style>
        .error {
        color: #F00;
        }
      </style>

    </head>
    <body>
    <?php
if (isset($_POST['submit'])) {
    require_once "../../db_connect/config.php";

    $client = 'Client';
    $fname = $_POST['client_firstname'];
    $lname = $_POST['client_lastname'];
    $mname = $_POST['client_middle'];
    $sname = $_POST['client_suffix'];
    $birthday = $_POST['client_birthday'];
    $contact = $_POST['client_number'];
    $gender = $_POST['client_gender'];
    $email = $_POST['client_email'];
    $houseNumber = $_POST['client_house_number'];
    $streetName = $_POST['client_street_name'];
    $barangay = $_POST['client_barangay'];
    $city = $_POST['client_city'];
    $province = $_POST['client_province'];
    $postalCode = $_POST['client_postal_code'];
    $createdAt = (new DateTime('now', new DateTimeZone('Asia/Manila')))->format('Y-m-d H:i:s');
    $econtact = $_POST['client_guardian'];
    $relation = $_POST['client_relation'];
    $econtactno = $_POST['client_emergency_contact_number'];
    $avatarFileName = ($gender === 'Male') ? 'maleAvatar.png' : 'femaleAvatar.png';

    $passwordPlain = $birthday;

    $passwordHashed = password_hash($passwordPlain, PASSWORD_BCRYPT);
    
    $checkEmailSql = "SELECT COUNT(*) FROM zp_client_record WHERE client_email = ?";
    $checkEmailStmt = mysqli_prepare($conn, $checkEmailSql);

    if ($checkEmailStmt) {
        mysqli_stmt_bind_param($checkEmailStmt, "s", $email);
        mysqli_stmt_execute($checkEmailStmt);
        mysqli_stmt_bind_result($checkEmailStmt, $clientEmailCount);
        mysqli_stmt_fetch($checkEmailStmt);
        mysqli_stmt_close($checkEmailStmt);

        $checkEmailSql = "SELECT COUNT(*) FROM zp_accounts WHERE clinic_email = ?";
        $checkEmailStmt = mysqli_prepare($conn, $checkEmailSql);

        if ($checkEmailStmt) {
            mysqli_stmt_bind_param($checkEmailStmt, "s", $email);
            mysqli_stmt_execute($checkEmailStmt);
            mysqli_stmt_bind_result($checkEmailStmt, $accountEmailCount);
            mysqli_stmt_fetch($checkEmailStmt);
            mysqli_stmt_close($checkEmailStmt);

            if ($clientEmailCount > 0 || $accountEmailCount > 0) {
                echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning!',
                        text: 'Email already exists.'
                    });
                </script>";
            } else {
                // Perform the insertion
                $clinicNumber = "clinic_number-" . rand(100, 999);
                $insertSql = "INSERT INTO zp_client_record (clinic_number, client_firstname, client_lastname, client_middle, client_suffix, client_birthday, client_number, client_gender, client_email, client_password, client_emergency_person, client_relation, client_emergency_contact_number, client_avatar, client_house_number, client_street_name, client_barangay, client_city, client_province, client_postal_code, client_role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $insertStmt = mysqli_prepare($conn, $insertSql);

                if ($insertStmt) {
                    mysqli_stmt_bind_param($insertStmt, "ssssssssssssssssssssss", $clinicNumber, $fname, $lname, $mname, $sname, $birthday, $contact, $gender, $email, $passwordHashed, $econtact, $relation, $econtactno, $avatarFileName, $houseNumber, $streetName, $barangay, $city, $province, $postalCode, $client, $createdAt);
                    if (mysqli_stmt_execute($insertStmt)) {
                        $clinicRole = $userData['clinic_role'];
                        $actionDescription = "Client added: " . $fname . " " . $lname;
                        $timezone = new DateTimeZone('Asia/Manila');
                        $dateTime = new DateTime('now', $timezone);
                        $timestamp = $dateTime->format('Y-m-d H:i:s');
                        $insertLogQuery = "INSERT INTO activity_log (user_id, name, action_type, role, action_description, timestamp) VALUES (?, ?, ?, 'Client Added', ?, ?)";
                        $stmt = mysqli_prepare($conn, $insertLogQuery);
                        mysqli_stmt_bind_param($stmt, 'issss', $userData['id'],  $userData['clinic_lastname'], $clinicRole, $actionDescription, $timestamp);

                        if (mysqli_stmt_execute($stmt)) {
                            require 'phpmailer/PHPMailerAutoload.php';
                            $mail = new PHPMailer(true);

                            try {
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com';
                                $mail->SMTPAuth = true;
                                $mail->Username = 'blazered098@gmail.com';
                                $mail->Password = 'nnhthgjzjbdpilbh';
                                $mail->SMTPSecure = 'tls';
                                $mail->Port = 587;
                                $mail->setFrom('blazered098@gmail.com', 'Z Skin Care Center');
                                $mail->addAddress($email);
                                $mail->isHTML(true);
                                $mail->Subject = 'Account Created Successfully';
                                $mail->Body =
                                            '<!DOCTYPE html>
                                            <html lang="en">
                                            
                                            <head>
                                                <meta charset="UTF-8">
                                                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
                                                <title>Account Created Successfully</title>
                                                <style>
                                                    body {
                                                        font-family: "Roboto", sans-serif;
                                                        margin: 0;
                                                        padding: 0;
                                                        background-color: #f4f4f4;
                                                        color: #333;
                                                    }
                                            
                                                    .container {
                                                        max-width: 600px;
                                                        margin: 20px auto;
                                                        padding: 20px;
                                                        background-color: #fff;
                                                        border-radius: 5px;
                                                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                                    }
                                            
                                                    h2 {
                                                        color: #6537AE;
                                                    }
                                            
                                                    p {
                                                        margin-bottom: 20px;
                                                    }
                                            
                                                    .highlight {
                                                        background-color: #f8f8f8;
                                                        padding: 10px;
                                                        border-radius: 5px;
                                                        margin-bottom: 20px;
                                                    }
                                            
                                                    .footer {
                                                        text-align: center;
                                                        margin-top: 20px;
                                                        color: #888;
                                                    }
                                                </style>
                                            </head>
                                            
                                            <body>
                                                <div class="container">
                                                    <h2>Your Account Has Been Created Successfully</h2>
                                                    <p>
                                                        Hello' . $fname . " " . $lname . ',
                                                    </p>
                                                    <p>
                                                        Thank you for choosing Z Skin Care Center. Your account has been created successfully. Here are your account details:
                                                    </p>
                                                    <div class="highlight">
                                                        <p><strong>Username (Email): </strong>' . $email .'</p>
                                                        <p><strong>Password: </strong>' . $passwordPlain . '</p>
                                                    </div>
                                                    <p>
                                                        Please keep your login credentials confidential. If you wish to change your password, you can do so by clicking the following link:
                                                        <a href="https://zephyderm.infinityfreeapp.com/forgot_password.php">Change Password</a>
                                                    </p>
                                                    <p>
                                                        Please keep your login credentials confidential. If you have any questions or need assistance, feel free to contact us.
                                                    </p>
                                                    <p>Best regards,</p>
                                                    <p>Z Skin Care Center</p>
                                                    <div class="footer">
                                                        <p>This is an automated email, please do not reply.</p>
                                                    </div>
                                                </div>
                                            </body>
                                            
                                            </html>';
                                $mail->send();
                                echo "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Client record added successfully.'
                                    }).then(function(result) {
                                        if (result.isConfirmed) {
                                            window.location.href = 'client_record.php';
                                        }
                                    });
                                </script>";
                                exit();
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }

                        } else {
                            echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to add data.'
                                });
                            </script>";
                            exit();
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to add data.'
                            });
                        </script>";
                        exit();
                    }

                    mysqli_stmt_close($insertStmt);
                } else {
                    echo "Error in preparing the insertion statement: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Error in preparing the SQL statements: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>

<div id="wrapper">
    <?php include "../sidebar.php"; ?>
    <section id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="ms-3">
                </div>
                <div class="m-2 bg-white text-dark p-4 rounded-4 border shadow-sm">
                    <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i></a>
                    <h2 style="color:6537AE;" class="text-center fw-bold mb-4">CREATE CLIENT RECORD</h2>
                    <form method="post" id="signUpForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom01" class="form-label mb-2">First Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="validationCustom01" name="client_firstname" required>
                                <div class="invalid-feedback">Please enter the first name.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="validationCustom02" class="form-label mb-2">Last Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="validationCustom02" name="client_lastname" required>
                                <div class="invalid-feedback">Please enter the last name.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label mb-2">Middle Name</label>
                                <input class="form-control" type="text" name="client_middle">
                                <div class="invalid-feedback">N/A is acceptable for Middle Name.</div>
                            </div>
                            <!-- Suffix -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label mb-2">Suffix</label>
                                <input class="form-control" type="text" name="client_suffix">
                                <div class="invalid-feedback">N/A is acceptable for Suffix.</div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="validationCustom03" class="form-label mb-3">Sex <span class="text-danger">*</span></label>
                            <select class="form-select" id="validationCustom03" name="client_gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div class="invalid-feedback">Please select a gender.</div>
                        </div>

                            <div class="mb-3 col-md-3">
                                <label for="validationCustom04" class="form-label mb-3">Contact Number <span class="text-danger">*</span></label>
                                <input class="form-control" id="validationCustom04" type="tel" name="client_number" required pattern="09[0-9]{9}" required oninput="validateInput(this)">
                                <div class="invalid-feedback">Please enter a valid phone number that starts with '09'.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="validationCustom05" class="form-label mb-3">Date of Birth <span class="text-danger">*</span></label>
                                <input class="form-control datepicker" id="d" type="text" name="client_birthday" placeholder="" required autocomplete="off">
                                <div class="invalid-feedback">Please enter a valid date of birth.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="validationCustom06" class="form-label mb-3">Email</label>
                                <input class="form-control" id="validationCustom06" type="email" name="client_email" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                        <hr>
                        <label class="form-label">Client Address</label>
                        <hr>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom07" class="form-label mb-3">House Number<span class="text-danger">*</label>
                                <input class="form-control" id="validationCustom07" type="text" name="client_house_number" required>
                                <div class="invalid-feedback">Please enter the house number.</div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom08" class="form-label mb-3">Street Name<span class="text-danger">*</label>
                                <input class="form-control" id="validationCustom08" type="text" name="client_street_name" required>
                                <div class="invalid-feedback">Please enter the street name.</div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom09" class="form-label mb-3">Barangay<span class="text-danger">*</label>
                                <input class="form-control" id="validationCustom09" type="text" name="client_barangay" required>
                                <div class="invalid-feedback">Please enter the barangay.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom10" class="form-label mb-3">City<span class="text-danger">*</label>
                                <input class="form-control" id="validationCustom10" type="text" name="client_city" required>
                                <div class="invalid-feedback">Please enter the city.</div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom11" class="form-label mb-3">Province<span class="text-danger">*</label>
                                <input class="form-control" id="validationCustom11" type="text" name="client_province" required>
                                <div class="invalid-feedback">Please enter the province.</div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom12" class="form-label mb-3">Postal Code</label>
                                <input class="form-control" id="validationCustom12" type="tel" name="client_postal_code" pattern="[0-9]{4}" oninput="validateInput1(this)">
                                <div class="invalid-feedback">N/A is acceptable for Postal.</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <label class="form-label mb-2 mt-4">Emergency Person</label>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="validationCustom13" class="form-label mb-3">Guardian/Parent <span class="text-danger">*</span></label>
                                <input class="form-control" id="validationCustom13" type="text" name="client_guardian" required>
                                <div class="invalid-feedback">Please enter the guardian's name.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="validationCustom14" class="form-label mb-3">Relation <span class="text-danger">*</span></label>
                                <input class="form-control" id="validationCustom14" type="text" name="client_relation" required>
                                <div class="invalid-feedback">Please enter the relation.</div>
                            </div>
                            <div class="mb-3 col-md-5">
                                <label for="validationCustom15" class="form-label mb-3">Contact Person Number <span class="text-danger">*</span></label>
                                <input class="form-control" id="validationCustom15" id="number" placeholder="Phone Number" name="client_emergency_contact_number" required pattern="09[0-9]{9}" required oninput="validateInput(this)">
                                <div class="invalid-feedback">Please enter a valid phone number that starts with '09'.</div>
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            
                            <button type="button" class="btn btn-secondary" id="clearFormButton">Clear Form</button>
                            <input class="btn btn-purple bg-purple text-white" type="submit" name="submit" value="Create Record">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

    <script>
    configuration = {
        allowInput: true,
        dateFormat: "Y-m-d",
        maxDate: "today",
    };
    flatpickr("#d", configuration);

    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<script>
    function validateInput(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 11) {
            inputElement.value = inputElement.value.slice(0, 11);
        }
    };
    function validateInput1(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 4) {
            inputElement.value = inputElement.value.slice(0, 4);
        }
    };
    function clearFormFields() {
        document.getElementById('signUpForm').reset();
    }

    document.getElementById('clearFormButton').addEventListener('click', clearFormFields);
</script>

    </body>
</html>