<?php 
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Clinic Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-pro@latest/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
</head>
<style>
    .page-item.active .page-link {
    background-color: #6537AE !important;
    color: #fff !important;
    border: #6537AE;
}   

#pageloader {
    background: rgba(255, 255, 255, 0.8);
    display: none;
    height: 100%;
    position: fixed;
    width: 100%;
    z-index: 9999;
}
th{
   background-color:#6537AE  !important;
   color: #fff  !important;
}
  .top-height {
    margin-top: 22px;
    height: -10px;
  }
</style>
<body>
    <?php
    if (isset($_POST['submit'])) {
        include "../../db_connect/config.php";
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $password = generatePasswordFromBirthday($birthday);
        $role = $_POST['role'];
        
        // Check if the email exists in zp_accounts
        $checkEmailQueryAccounts = "SELECT COUNT(*) FROM zp_accounts WHERE clinic_email = ?";
        $stmtCheckEmailAccounts = mysqli_prepare($conn, $checkEmailQueryAccounts);
        mysqli_stmt_bind_param($stmtCheckEmailAccounts, "s", $email);
        mysqli_stmt_execute($stmtCheckEmailAccounts);
        mysqli_stmt_bind_result($stmtCheckEmailAccounts, $emailCountAccounts);
        mysqli_stmt_fetch($stmtCheckEmailAccounts);
        mysqli_stmt_close($stmtCheckEmailAccounts);

        // Check if the email exists in zp_client_record
        $checkEmailQueryClient = "SELECT COUNT(*) FROM zp_client_record WHERE client_email = ?";
        $stmtCheckEmailClient = mysqli_prepare($conn, $checkEmailQueryClient);
        mysqli_stmt_bind_param($stmtCheckEmailClient, "s", $email);
        mysqli_stmt_execute($stmtCheckEmailClient);
        mysqli_stmt_bind_result($stmtCheckEmailClient, $emailCountClient);
        mysqli_stmt_fetch($stmtCheckEmailClient);
        mysqli_stmt_close($stmtCheckEmailClient);

        if ($emailCountAccounts > 0 || $emailCountClient > 0) {
            echo "<script>
                window.addEventListener('DOMContentLoaded', (event) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'The email address already exists in the database.',
                    }).then(function() {
                        window.location.href = 'clinic_account.php'; // Redirect to your page
                    });
                });
            </script>";
            exit();
        }

        // Check if an image was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image = $_FILES['image'];
            $maxFileSize = 5 * 1024 * 1024;

            if ($image['size'] > $maxFileSize) {
                echo "Error: The uploaded image file exceeds the maximum allowed size of 5MB.";
                exit();
            } else {
                $uploadDir = '../../img/img/';
                $imageFileName = $uploadDir . time() . '_' . uniqid() . '.jpg';
                $imagePath = $imageFileName;

                if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                    echo "Error: There was an error uploading the image.";
                    exit();
                }
            }
        } else {
            $defaultImages = [
                'Derma' => '../../img/avatar/femaleAvatar.png',
                'Staff' => '../../img/avatar/maleAvatar.png',
            ];
            $defaultImage = $defaultImages[$role] ?? 'default_unknown.jpg';
            $imageFileName = $defaultImage;
        }

        $sql = "INSERT INTO zp_accounts (clinic_firstname, clinic_lastname, clinic_email, clinic_gender, image, clinic_password, clinic_birthday, clinic_role, account_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss", $fname,  $lname, $email, $gender, $imageFileName, $password, $birthday, $role);

        if (mysqli_stmt_execute($stmt)) {
            require '../appointment/phpmailer/PHPMailerAutoload.php';
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
                $mail->addAddress($email, $fname . ' ' . $lname);
                $mail->isHTML(true);
                $mail->Subject = 'Account Created';

                $mail->Body = '
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                color: #333;
                                padding: 20px;
                            }
                            
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #fff;
                                padding: 20px;
                                border-radius: 5px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }
                            
                            h2 {
                                color: #6537AE;
                            }
                            p {
                                margin-bottom: 10px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h2>Hello ' . $fname . ' ' . $lname . ',</h2>
                            <p>Your account has been created successfully.</p>
                            <p>Your registered email address is: <strong>' . $email . '</strong></p>
                            <p>Your temporary password is set to your birthday. For example, if your birthday is on November 22, 2002, your password will be: <strong>2002-11-22</strong></p>
                        </div>
                    </body>
                    </html>
                ';
                
                $mail->send();

                // Log activity
                $userData = $_SESSION['id'];
                $clinicRole = $userData['clinic_role'];
                $actionDescription = "Created a clinic account for: " . $fname . " " . $lname;
                logActivity($conn, $userData['id'], $userData['clinic_lastname'], $clinicRole, $actionDescription);

                // Success message and redirection
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Account successfully Created! Email sent.",
                    }).then(function() {
                        window.location.href = "clinic_account.php"; // Redirect after user clicks OK
                    });
                </script>';
                exit();
            } catch (Exception $e) {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Email could not be sent. Mailer Error: ' . $mail->ErrorInfo . '"
                    });
                </script>';
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

if (isset($_POST['edit_submit'])) {
    include "../../db_connect/config.php";
    $edit_id = $_POST['edit_id'];
    $edit_fname = $_POST['edit_fname'];
    $edit_lname = $_POST['edit_lname'];
    $edit_email = $_POST['edit_email'];
    $edit_role = $_POST['edit_role'];
    $edit_birthday = $_POST['birthday'];
/*     $edit_password = $_POST['edit_password'];

        // Check if the password is provided and update it
        if (!empty($edit_password)) {
            $edit_password_hashed = password_hash($edit_password, PASSWORD_DEFAULT);
            $updatePasswordSql = "UPDATE zp_accounts SET clinic_password = ? WHERE id = ?";
            $stmtUpdatePassword = mysqli_prepare($conn, $updatePasswordSql);
            mysqli_stmt_bind_param($stmtUpdatePassword, "ss", $edit_password_hashed, $edit_id);

            if (!mysqli_stmt_execute($stmtUpdatePassword)) {
                echo "Error: " . mysqli_error($conn);
                exit();
            }

            mysqli_stmt_close($stmtUpdatePassword);
        } */
    // Fetch the current email from the database for the edited record
    $getCurrentEmailSql = "SELECT clinic_email FROM zp_accounts WHERE id=?";
    $getCurrentEmailStmt = mysqli_prepare($conn, $getCurrentEmailSql);
    mysqli_stmt_bind_param($getCurrentEmailStmt, "s", $edit_id);
    mysqli_stmt_execute($getCurrentEmailStmt);
    mysqli_stmt_bind_result($getCurrentEmailStmt, $currentEmail);
    mysqli_stmt_fetch($getCurrentEmailStmt);
    mysqli_stmt_close($getCurrentEmailStmt);

    // Check if the email has been changed
    if ($currentEmail !== $edit_email) {
        // Check if the new email exists in zp_accounts (excluding the current edited record)
        $checkEmailQueryAccounts = "SELECT COUNT(*) FROM zp_accounts WHERE clinic_email = ? AND id != ?";
        $stmtCheckEmailAccounts = mysqli_prepare($conn, $checkEmailQueryAccounts);
        mysqli_stmt_bind_param($stmtCheckEmailAccounts, "ss", $edit_email, $edit_id);
        mysqli_stmt_execute($stmtCheckEmailAccounts);
        mysqli_stmt_bind_result($stmtCheckEmailAccounts, $emailCountAccounts);
        mysqli_stmt_fetch($stmtCheckEmailAccounts);
        mysqli_stmt_close($stmtCheckEmailAccounts);

        // Check if the new email exists in zp_client_record
        $checkEmailQueryClient = "SELECT COUNT(*) FROM zp_client_record WHERE client_email = ?";
        $stmtCheckEmailClient = mysqli_prepare($conn, $checkEmailQueryClient);
        mysqli_stmt_bind_param($stmtCheckEmailClient, "s", $edit_email);
        mysqli_stmt_execute($stmtCheckEmailClient);
        mysqli_stmt_bind_result($stmtCheckEmailClient, $emailCountClient);
        mysqli_stmt_fetch($stmtCheckEmailClient);
        mysqli_stmt_close($stmtCheckEmailClient);

        if ($emailCountAccounts > 0 || $emailCountClient > 0) {
            // New email already exists, cannot update
            echo "<script>
                window.addEventListener('DOMContentLoaded', (event) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'The email address already exists please input another email.',
                    }).then(function() {
                        window.location.href = 'clinic_account.php'; // Redirect to your page
                    });
                });
            </script>";
            exit();
        }
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $getOldImageSql = "SELECT image FROM zp_accounts WHERE id=?";
        $getOldImageStmt = mysqli_prepare($conn, $getOldImageSql);
        mysqli_stmt_bind_param($getOldImageStmt, "s", $edit_id);
        mysqli_stmt_execute($getOldImageStmt);
        mysqli_stmt_bind_result($getOldImageStmt, $oldImage);
        mysqli_stmt_fetch($getOldImageStmt);
        mysqli_stmt_close($getOldImageStmt);
        $isDefaultImage = in_array($oldImage, [
            '../../img/avatar/femaleAvatar.png',
            '../../img/avatar/maleAvatar.png',
        ]);
    
        if (!$isDefaultImage && !empty($oldImage) && file_exists('../../img/img/' . $oldImage)) {
            unlink('../../img/img/' . $oldImage);
        }
    
        $uploadDir = '../../img/img/';
        $imageName = $uploadDir . time() . '_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    
        $imagePath = $imageName;
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $sql = "UPDATE zp_accounts SET clinic_firstname=?, clinic_lastname=?, clinic_email=?, clinic_role=?, image=?, clinic_birthday=?";
            $sql .= " WHERE id=?";
    
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $edit_fname, $edit_lname, $edit_email, $edit_role, $imageName, $edit_birthday, $edit_id);
    
            if (mysqli_stmt_execute($stmt)) {
                $userData = $_SESSION['id'];
                $clinicRole = $userData['clinic_role'];
                $actionDescription = "Updated clinic account for: " . $edit_fname . " " . $edit_lname;
                logActivity($conn, $userData['id'], $userData['clinic_lastname'], $clinicRole, $actionDescription);
    
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Account updated successfully!",
                    }).then(function() {
                        window.location.href = "clinic_account.php"; // Redirect after user clicks OK
                    });
                </script>';
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: There was an error uploading the image.";
        }
    
    } else {
        $sql = "UPDATE zp_accounts SET clinic_firstname=?, clinic_lastname=?, clinic_email=?, clinic_role=?, clinic_birthday=?";
        $sql .= " WHERE id=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $edit_fname, $edit_lname, $edit_email, $edit_role, $edit_birthday, $edit_id);

        if (mysqli_stmt_execute($stmt)) {
            $userData = $_SESSION['id'];
            $clinicRole = $userData['clinic_role'];
            $actionDescription = "Updated clinic account for: " . $edit_fname . " " . $edit_lname;
            logActivity($conn, $userData['id'],  $userData['clinic_lastname'], $clinicRole, $actionDescription);

            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Account updated successfully!",
                    }).then(function() {
                        window.location.href = "clinic_account.php"; // Redirect after user clicks OK
                    });
                </script>';
                exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function generateAccountID($conn) {
    // No need for custom logic, let the auto-increment handle it
    $accountID = 'clinic_account-' . mysqli_insert_id($conn);
    return $accountID;
}


function logActivity($conn, $userId, $name, $role, $actionDescription) {
    $timezone = new DateTimeZone('Asia/Manila');
    $dateTime = new DateTime('now', $timezone);
    $timestamp = $dateTime->format('Y-m-d H:i:s');
    $sql = "INSERT INTO activity_log (user_id, name, action_type, role, action_description, timestamp) VALUES (?, ?, 'Clinic Account', ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'issss', $userId, $name, $role, $actionDescription, $timestamp);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
function deactivateAccount($id) {
    include "../../db_connect/config.php";
    $sql = "UPDATE zp_accounts SET account_status = 'deactivated' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        $userData = $_SESSION['id'];
        $clinicRole = $userData['clinic_role'];
        $actionDescription = "Changing Account: " . $fname . " " . $lname;
        logActivity($conn, $userData['id'], $userData['clinic_lastname'], $clinicRole, $actionDescription);
        header("Location: clinic_account.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function generatePasswordFromBirthday($birthday) {
    $password = password_hash($birthday, PASSWORD_DEFAULT);
    return $password;
}
?>


<div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="text-center">
                        <div class="bg-white py-3 mb-3 border border-bottom">
                        <div class="d-flex justify-content-between mx-4">
                            <div>
                                <h2 style="color:6537AE;" class="fw-bold">CLINIC ACCOUNT</h2>
                            </div>
                            <div class="align-items-center">
                                <a class="btn bg-purple text-white" onclick="showInsertModal()">CREATE</a>
                            </div>
                        </div>
                    </div>

                <div>
                    <div class="bg-white p-3 rounded-3 border mx-3 mb-1" >
                    <div class="col-md-3">
                        <label for="yearFilter">Filter by Role</label>
                        <select id="yearFilter" class="form-select form-select-sm">
                            <option value="">All Role</option>
                            <option value="Staff">Staff</option>
                            <option value="Derma">Derma</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="yearFilter1">Filter by Role</label>
                        <select id="yearFilter1" class="form-select form-select-sm">
                            <option value="">All Role</option>
                            <option value="Active">Active</option>
                            <option value="Deactivated">Deactivate</option>
                        </select>
                    </div>
                        <table id="Table" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Profile Image</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../../db_connect/config.php";
                                $result = mysqli_query($conn, "SELECT * FROM zp_accounts WHERE clinic_role IN ('Derma', 'Staff');                                ");
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td>
                                        <img src="<?php echo $row['image']; ?>" alt="Image Description" width="100">
                                        </td>
                                        <td><?php echo $row['clinic_firstname'] . " " . $row['clinic_lastname']?></td>
                                        <td><?php echo $row['clinic_email'] ?></td>
                                        <td><?php echo $row['clinic_role'] ?></td>
                                        <td class="action-buttons">
                                            <div class="add-btn">
                                                <?php
                                                if ($row['account_status'] == 'active') {
                                                    echo '<button onclick="statusAccount(\'' . $row['id'] . '\', \'deactivate\')" class="btn btn-success bg-success text-white">Active</button>';
                                                } else {
                                                    echo '<button onclick="statusAccount(\'' . $row['id'] . '\', \'reactivate\')" class="btn btn-danger bg-danger text-white">Deactivated</button>';
                                                }
                                                ?>
                                                <button onclick="showData('<?php echo $row['id']; ?>')" class="btn btn-purple btn-outline-purple" data-zep-acc="<?php echo $row['id']; ?>">Edit</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="displayAccount" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:6537AE" id="dataModalLabel">Edit Clinic Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="insertAccount" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:6537AE" id="insertModalLabel">Create New Account</h5>
                <div class="modal-footer">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Data will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script src="js/clinic.js"></script>
<script>
    $(document).ready(function() {
        var dataTable = $('#Table').DataTable({
            dom: '<"row mx-auto"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3"B>>rtip',
            
            responsive: true,
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: true,
            select: true,
            "ordering": false,
        });
        var serviceTypeColumn = dataTable.column(3);
        $('#yearFilter').on('change', function () {
            var selectedServiceType = $(this).val();
            serviceTypeColumn.search(selectedServiceType).draw();
        });
    })

    function verifyAdminPassword(action, callback) {
    Swal.fire({
        title: 'Admin Verification',
        input: 'password',
        inputLabel: 'Enter Admin Password',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Verify',
        showLoaderOnConfirm: true,
        preConfirm: (adminPassword) => {
            // Send adminPassword to the server for verification
            return fetch('verified_password.php', {
                method: 'POST',
                body: JSON.stringify({ adminPassword }),
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Admin password verified, proceed with the action
                    callback();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                Swal.showValidationMessage(`Verification failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
}

</script>
</body>
</html>
