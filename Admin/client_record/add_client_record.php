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
    <title>Dashboard</title>
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
    $password = password_hash($birthday, PASSWORD_BCRYPT);

    $econtact = $_POST['client_guardian'];
    $relation = $_POST['client_relation'];
    $econtactno = $_POST['client_emergency_contact_number'];
    $avatarFileName = '';

    if ($gender === 'Male') {
        $avatarFileName = '../../img/avatar/maleAvatar.png';
    } elseif ($gender === 'Female') {
        $avatarFileName = '../../img/avatar/femaleAvatar.png';
    }

    // Check if the email exists in zp_client_record
    $checkClientEmailSql = "SELECT COUNT(*) FROM zp_client_record WHERE client_email = ?";
    $checkClientEmailStmt = mysqli_prepare($conn, $checkClientEmailSql);
    
    if ($checkClientEmailStmt) {
        mysqli_stmt_bind_param($checkClientEmailStmt, "s", $email);
        mysqli_stmt_execute($checkClientEmailStmt);
        mysqli_stmt_bind_result($checkClientEmailStmt, $clientEmailCount);
        mysqli_stmt_fetch($checkClientEmailStmt);
        mysqli_stmt_close($checkClientEmailStmt);
        
        // Check if the email exists in zp_accounts
        $checkAccountsSql = "SELECT COUNT(*) FROM zp_accounts WHERE clinic_email = ?";
        $checkAccountsStmt = mysqli_prepare($conn, $checkAccountsSql);
        
        if ($checkAccountsStmt) {
            mysqli_stmt_bind_param($checkAccountsStmt, "s", $email);
            mysqli_stmt_execute($checkAccountsStmt);
            mysqli_stmt_bind_result($checkAccountsStmt, $accountsCount);
            mysqli_stmt_fetch($checkAccountsStmt);
            mysqli_stmt_close($checkAccountsStmt);

            // Check if the client's name already exists in zp_client_record
            $checkNameSql = "SELECT COUNT(*) FROM zp_client_record WHERE client_firstname = ? AND client_lastname = ? AND client_middle = ? AND client_suffix = ?";
            $checkNameStmt = mysqli_prepare($conn, $checkNameSql);
            
            if ($checkNameStmt) {
                mysqli_stmt_bind_param($checkNameStmt, "ssss", $fname, $lname, $mname, $sname);
                mysqli_stmt_execute($checkNameStmt);
                mysqli_stmt_bind_result($checkNameStmt, $nameCount);
                mysqli_stmt_fetch($checkNameStmt);
                mysqli_stmt_close($checkNameStmt);
                
                if ($clientEmailCount > 0 || $accountsCount > 0 || $nameCount > 0) {
                    echo "<script>
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: 'Email or client with the same name already exists.'
                        });
                    </script>";
                } else {
                    $clinicNumber = "clinic_number-" . rand(100, 999); // You can generate the clinic_number as needed
                    $insertSql = "INSERT INTO zp_client_record (clinic_number, client_firstname, client_lastname, client_middle, client_suffix, client_birthday, client_number, client_gender, client_email, client_password, client_emergency_person, client_relation, client_emergency_contact_number, client_avatar, client_house_number, client_street_name, client_barangay, client_city, client_province, client_postal_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $insertStmt = mysqli_prepare($conn, $insertSql);
                    
                    if ($insertStmt) {
                        mysqli_stmt_bind_param($insertStmt, "ssssssssssssssssssss", $clinicNumber, $fname, $lname, $mname, $sname, $birthday, $contact, $gender, $email, $password, $econtact, $relation, $econtactno, $avatarFileName, $houseNumber, $streetName, $barangay, $city, $province, $postalCode);
                        
                        if (mysqli_stmt_execute($insertStmt)) {
                            $clinicRole = $userData['clinic_role'];
                            $actionDescription = "Client added: " . $fname . " " . $lname;
                            $insertLogQuery = "INSERT INTO activity_log (user_id, action_type, role, action_description) 
                                               VALUES (?, 'Client Added', ?, ?)";
                            $stmt = mysqli_prepare($conn, $insertLogQuery);
                            mysqli_stmt_bind_param($stmt, 'iss', $userData['id'], $clinicRole, $actionDescription);
                            
                            if (mysqli_stmt_execute($stmt)) {
                                echo "<script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Data added successfully.'
                                    }).then(function(result) {
                                        if (result.isConfirmed) {
                                            window.location.href = 'client_record.php';
                                        }
                                    });
                                </script>";
                                exit();
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
                echo "Error in preparing the name check statement: " . mysqli_error($conn);
            }
        } else {
            echo "Error in preparing the zp_accounts check statement: " . mysqli_error($conn);
        }
    } else {
        echo "Error in preparing the zp_client_record check statement: " . mysqli_error($conn);
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
                    <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i> Go Back</a>
                    <h2 style="color:6537AE;" class="text-center">Create Client Record</h2>
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
                                <input class="form-control" type="text" name="client_middle" required>
                                <div class="invalid-feedback">N/A is acceptable for Middle Name.</div>
                            </div>
                            <!-- Suffix -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label mb-2">Suffix</label>
                                <input class="form-control" type="text" name="client_suffix" required>
                                <div class="invalid-feedback">N/A is acceptable for Suffix.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="validationCustom03" class="form-label mb-3">Sex <span class="text-danger">*</span></label>
                                <select class="form-control" id="validationCustom03" name="client_gender" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="validationCustom04" class="form-label mb-3">Contact Number <span class="text-danger">*</span></label>
                                <input class="form-control" id="validationCustom04" type="text" name="client_number" oninput="validateInput(this)";  required>
                                <div class="invalid-feedback">Please enter a valid contact number.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="validationCustom05" class="form-label mb-3">Date of Birth <span class="text-danger">*</span></label>
                                <input class="form-control" id="d" type="date" name="client_birthday" required placeholder="">
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
                                <label for="validationCustom12" class="form-label mb-3">Postal Code<span class="text-danger">*</label>
                                <input class="form-control" id="validationCustom12" type="text" name="client_postal_code" required>
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
                                <input class="form-control" id="validationCustom15" type="tel" name="client_emergency_contact_number" oninput="validateInput(this)"; required>
                                <div class="invalid-feedback">Please enter a valid contact number for the emergency contact.</div>
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            <input class="btn btn-purple bg-purple text-white" type="submit" name="submit" value="Create Record">
                            <button type="button" class="btn btn-secondary" id="clearFormButton">Clear Form</button>
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
        maxDate: "today"
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
    function clearFormFields() {
        document.getElementById('signUpForm').reset();
    }

    document.getElementById('clearFormButton').addEventListener('click', clearFormFields);
</script>

    </body>
</html>