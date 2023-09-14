<?php
include "../function.php";
checklogin();
$userData = $_SESSION['zep_acc'];
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
      </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js">
      </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js">
      </script>
      <style>
        .error {
        color: #F00;
        }
      </style>
      <script>
        $().ready(function () {
            $("#signUpForm").validate({
                rules: {
                    client_firstname: "required",
                    lastname: "required",
                    username: {
                        required: true,
                        minlength: 2
                    },
                    client_emergency_person: {
                        required: true,
                        minlength: 11,
                        number: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    agree: "required"
                },
                messages: {
                    client_firstname: " Please enter your firstname",
                    lastname: " Please enter your lastname",
                    username: {
                        required: " Please enter a username",
                        minlength:
                      " Your username must consist of at least 2 characters"
                    },
                    client_emergency_person: {
                        required: " Please enter a number",
                        minlength:
                      " Your number must be consist of at least 11 numbers",
                      client_emergency_person : "Please enter only number"
                    },
                    agree: "Please accept our policy"
                }
            });
        });
    </script>
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
    $email = $_POST['clinic_email'];
    $password = $_POST['clinic_password'];
    $econtact = $_POST['client_emergency_person'];
    $relation = $_POST['client_relation'];
    $econtactno = $_POST['client_emergency_contact_number'];
    $avatarFileName = ''; 

    if ($gender === 'Male') {
        $avatarFileName = 'maleAvatar.png';
    } elseif ($gender === 'Female') {
        $avatarFileName = 'femaleAvatar.png';
    }

    $checkSql = "SELECT COUNT(*) FROM zp_client_record WHERE client_firstname = ? AND client_lastname = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "ss", $fname, $lname);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $count);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);

        if ($count > 0) {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Data already exists.'
                });
            </script>";
        } else {
            $record_id = generateRecordID();
            $insertSql = "INSERT INTO zp_client_record (clinic_number, client_firstname, client_lastname, client_middle, client_suffix, client_birthday, client_number, client_gender, clinic_email, clinic_password, client_emergency_person, client_relation, client_emergency_contact_number, client_avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertSql);
            if ($insertStmt) {
                mysqli_stmt_bind_param($insertStmt, "ssssssssssssss", $record_id, $fname, $lname, $mname, $sname, $birthday, $contact, $gender, $email, $password, $econtact, $relation, $econtactno, $avatarFileName);

                if (mysqli_stmt_execute($insertStmt)) {
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
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to add data.'
                        });
                    </script>";
                }

                mysqli_stmt_close($insertStmt);
            } else {
                echo "Error in preparing the insertion statement: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error in preparing the check statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
function generateRecordID() {
    include "../../db_connect/config.php";
    $sql = "SELECT MAX(SUBSTRING_INDEX(clinic_number, '-', -1)) AS max_counter FROM zp_client_record";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $max_counter = intval($row['max_counter']);
    $recordID = 'clinic_number-' . str_pad($max_counter + 1, 3, '0', STR_PAD_LEFT);
    return $recordID;
}
?>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                <div class="ms-3">
            </div>
                    <div class="m-2 bg-white text-dark p-4 rounded-4 border border-4 shadow-sm">
                            <h2 style="color:6537AE;">Client Record (Edit)</h2>
                                <form method="post" id="signUpForm">
                                    <div class="row">
                                        <div class="mb-3">
                                            <input class="form-label" type="hidden" name="id">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="mb-2">First Name:</label>
                                            <input class="form-control" type="text" name="client_firstname">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="mb-2">Last Name:</label>
                                            <input class="form-control" type="text" name="client_lastname">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="mb-2">Middle Name:</label>
                                            <input class="form-control" type="text" name="client_middle" required>
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label class="mb-2">Suffix:</label>
                                            <input class="form-control" type="text" name="client_suffix" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="mb-3">Gender:</label>
                                        <select class="form-control" name="client_gender" id="client_gender" required>
                                            <option selected="true" disabled></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="mb-3">Date of Birth:</label>
                                            <input class="form-control" type="date" name="client_birthday" id="d" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="mb-2 mt-4">Account User:</label>
                                        <hr>
                                        <div class="mb-3 col-md-6">
                                            <label class="mb-3">Email:</label>
                                            <input class="form-control" type="email" name="clinic_email" required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="mb-3">Password:</label>
                                            <input class="form-control" type="password" name="clinic_password" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="mb-2 mt-4">EMERGENCY PERSON:</label>
                                        <hr>
                                        <div class="mb-3 col-md-6">
                                            <label class="mb-3">Contact Number:</label>
                                            <input class="form-control" type="text" name="client_number" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="mb-3">Contact Person:</label>
                                            <input class="form-control" type="tel" name="client_emergency_person">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="mb-3">Relation:</label>
                                            <input class="form-control" type="text" name="client_relation" required>
                                        </div>
                                        <div class="mb-3 col-md-5">
                                            <label class="mb-3">Contact Person Number:</label>
                                            <input class="form-control" type="text" name="client_emergency_contact_number" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <input class="btn btn-purple bg-purple text-white" type="submit" name="submit" value="Create Record">
                                        <a class="btn btn-warning" href="client_record.php">Cancel</a>
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
        configuration = {
            allowInput: true,
          dateFormat: "Y-m-d",
          maxDate: "today"

        }
        flatpickr("#d", configuration);
      </script>
    </body>
</html>