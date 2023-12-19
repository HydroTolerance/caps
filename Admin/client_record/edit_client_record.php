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
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    
<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.5/css/dataTables.dateTime.min.css">
<script src="https://cdn.datatables.net/datetime/1.1.5/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <style>
        </style>
    </head>
    <body>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        include "../../db_connect/config.php";
        $sql = "SELECT * FROM zp_client_record WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $recordId = $row['clinic_number'];
            $fname = $row['client_firstname'];
            $mname = $row['client_middle'];
            $lname = $row['client_lastname'];
            $sname = $row['client_suffix'];
            $dob = $row['client_birthday'];
            $gender = $row['client_gender'];
            $contact = $row['client_number'];
            $email = $row['client_email'];
            $econtact = $row['client_emergency_person'];
            $relation = $row['client_relation'];
            $econtactno = $row['client_emergency_contact_number'];
            $avatar = $row['client_avatar'];
            $houseNumber = $row['client_house_number'];
            $streetName = $row['client_street_name'];
            $barangay = $row['client_barangay'];
            $city = $row['client_city'];
            $province = $row['client_province'];
            $postalCode = $row['client_postal_code'];
        } else {
            echo "Record not found";
            exit;
        }
        if (isset($_POST['update_client'])) {
            $email = $_POST['client_email'];

            // Check zp_client_record table
            $checkClientEmailSql = "SELECT id FROM zp_client_record WHERE client_email = ? AND id != ?";
            $checkClientEmailStmt = mysqli_prepare($conn, $checkClientEmailSql);
            mysqli_stmt_bind_param($checkClientEmailStmt, "si", $email, $id);
            mysqli_stmt_execute($checkClientEmailStmt);
            $checkClientEmailResult = mysqli_stmt_get_result($checkClientEmailStmt);

            // Check zp_accounts table
            $checkAccountsEmailSql = "SELECT id FROM zp_accounts WHERE clinic_email = ? AND id != ?";
            $checkAccountsEmailStmt = mysqli_prepare($conn, $checkAccountsEmailSql);
            mysqli_stmt_bind_param($checkAccountsEmailStmt, "si", $email, $id);
            mysqli_stmt_execute($checkAccountsEmailStmt);
            $checkAccountsEmailResult = mysqli_stmt_get_result($checkAccountsEmailStmt);

            if (mysqli_num_rows($checkClientEmailResult) > 0 || mysqli_num_rows($checkAccountsEmailResult) > 0) {
                // Email already exists in either table, show SweetAlert
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Email already exists. Please choose a different email.',
                        }).then(function() {
                            window.location.href = 'edit_client_record.php?id=" . $id . "';
                        });
                    </script>";
                exit;
            }
        
            $id = $_POST['id'];
    $fname = $_POST['client_firstname'];
    $lname = $_POST['client_lastname'];
    $mname = $_POST['client_middle'];
    $sname = $_POST['client_suffix'];
    $dob = $_POST['client_birthday'];
    $gender = $_POST['client_gender'];
    $contact = $_POST['client_number'];
    $email = $_POST['client_email'];
    $econtact = $_POST['client_emergency_person'];
    $relation = $_POST['client_relation'];
    $econtactno = $_POST['client_emergency_contact_number'];
    $houseNumber = $_POST['client_house_number'];
    $streetName = $_POST['client_street_name'];
    $barangay = $_POST['client_barangay'];
    $city = $_POST['client_city'];
    $province = $_POST['client_province'];
    $postalCode = $_POST['client_postal_code'];
    $sql_update = "UPDATE zp_client_record SET client_firstname = ?, client_lastname = ?, client_middle = ?, client_suffix = ?, client_birthday = ?, client_gender = ?, client_number = ?, client_email = ?, client_emergency_person = ?, client_relation = ?, client_emergency_contact_number = ?, client_house_number = ?, client_street_name = ?, client_barangay = ?, client_city = ?, client_province = ?, client_postal_code = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($updateStmt, "sssssssssssssssssi",
        $fname, $lname, $mname, $sname, $dob, $gender, $contact, $email, $econtact, $relation, $econtactno,
        $houseNumber, $streetName, $barangay, $city, $province, $postalCode, $id);
        
            if (mysqli_stmt_execute($updateStmt)) {
                logActivity($conn, $userData['id'], $userData['clinic_lastname'], 'Update Record', $userData['clinic_role'], 'Update Client Record');
                // Success
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Client record updated successfully.',
                        }).then(function() {
                            window.location.href = 'view.php?id=" . $id . "';
                        });
                    </script>";
            } else {
                // Error
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update client record.',
                        });
                    </script>";
            }
        
            mysqli_stmt_close($updateStmt);
        }
        
        // Retrieve additional info if available
        $info_sql = "SELECT diagnosis FROM zp_derma_record WHERE patient_id=?";
        $info_stmt = mysqli_prepare($conn, $info_sql);
        mysqli_stmt_bind_param($info_stmt, "i", $id);
        mysqli_stmt_execute($info_stmt);
        $info_result = mysqli_stmt_get_result($info_stmt);
        if (mysqli_num_rows($info_result) > 0) {
            $info_row = mysqli_fetch_assoc($info_result);
            $diagnosis = $info_row['diagnosis'];
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($info_stmt);
        mysqli_close($conn);
    }
    function logActivity($conn, $userId, $name, $actionType, $role, $actionDescription) {
        $timezone = new DateTimeZone('Asia/Manila');
        $dateTime = new DateTime('now', $timezone);
        $timestamp = $dateTime->format('Y-m-d H:i:s');
        $sql = "INSERT INTO activity_log (user_id, name, action_type, role, action_description, timestamp) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'isssss', $userId, $name, $actionType, $role, $actionDescription, $timestamp);
    
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
    }
    }
    ?>

        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div>
                    <div class="col-lg-12">
                    <div class="mx-3">
                        <form method="post"  id="updateForm">
                            <div class="container">
                            <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i> </a>
                            <h2 style="color:6537AE;" class="text-center fw-bold">EDIT CLIENT RECORD</h2>
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="bg-white mb-4 p-5 text-center rounded border" style="height: 90%; padding-bottom: 25px;">
                                            <img src="../../img/avatar/<?php echo $avatar; ?>" alt="Avatar" style="width: 155px; height: 155px; border-radius: 50%; margin: 0 auto;"><br>
                                        </div>
                                    </div>

                                    <div class="col-xl-9 col-lg-12 mb-4">
                                        <div class="bg-white h-100 p-4 border rounded">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="mb-3 ">First Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="client_firstname" value="<?php echo $fname; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Middle Name </label>
                                                    <input class="form-control" type="text" name="client_middle" value="<?php echo $mname; ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Last Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="client_lastname" value="<?php echo $lname; ?>"  required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="" class="mb-3">Suffix</label>
                                                    <input type="text" class="form-control" name="client_suffix" value="<?php echo $sname; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="mb-3">Gender <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="client_gender" required>
                                                        <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                                                        <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Date of Birth <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="date" name="client_birthday" value="<?php echo $dob; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Contact Number <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="client_number" value="<?php echo $contact; ?>"  required pattern="09[0-9]{9}" required oninput="validateInput(this)">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="mb-3">Email <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="email" name="client_email" value="<?php echo $email; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white p-5 border rounded mb-3" style="padding: 20px;">
                                    <div class="row mb-3">
                                        <label class="mb-2">CLIENT ADDRESS</label>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom07" class="form-label mb-3">House Number <span class="text-danger">*</span></label>
                                            <input class="form-control" id="validationCustom07" type="text" value="<?php echo $houseNumber; ?>" name="client_house_number" required>
                                            <div class="invalid-feedback">Please enter the house number.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom08" class="form-label mb-3">Street Name <span class="text-danger">*</span></label>
                                            <input class="form-control" id="validationCustom08" type="text" value="<?php echo $streetName; ?>" name="client_street_name" required>
                                            <div class="invalid-feedback">Please enter the street name.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom09" class="form-label mb-3">Barangay <span class="text-danger">*</span></label>
                                            <input class="form-control" id="validationCustom09" type="text" value="<?php echo $barangay; ?>" name="client_barangay" required>
                                            <div class="invalid-feedback">Please enter the barangay.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom10" class="form-label mb-3">City <span class="text-danger">*</span></label>
                                            <input class="form-control" id="validationCustom10" type="text" value="<?php echo $city; ?>" name="client_city" required>
                                            <div class="invalid-feedback">Please enter the city.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom11" class="form-label mb-3">Province <span class="text-danger">*</span></label>
                                            <input class="form-control" id="validationCustom11" type="text" value="<?php echo $province; ?>" name="client_province" required>
                                            <div class="invalid-feedback">Please enter the province.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom12" class="form-label mb-3">Postal Code <span class="text-danger">*</span></label>
                                            <input class="form-control" id="validationCustom12" type="text" value="<?php echo $postalCode ?>" name="client_postal_code" required>
                                            <div class="invalid-feedback">Please enter the postal code.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white p-5 border rounded mb-3" style="padding: 20px;">
                                    <div class="row mb-3">
                                        <label class="mb-2">EMERGENCY PERSON</label>
                                        <hr>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="mb-3">Contact Person <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="client_emergency_person" value="<?php echo $econtact; ?>" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="mb-3">Relation  <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="client_relation" value="<?php echo $relation; ?>" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="mb-3">Contact Person Number  <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="client_emergency_contact_number" value="<?php echo $econtactno; ?>"  required pattern="09[0-9]{9}" required oninput="validateInput(this)">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-purple bg-purple text-white float-end" type="submit" id="submitBtn" name="update_client">Save</button>
                                    </div>
                                </div>
                        </form>
                        
                        </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="displayAccount" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Full Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Full Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Data will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

    <script src="js/record.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    
<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.5/css/dataTables.dateTime.min.css">
<script src="https://cdn.datatables.net/datetime/1.1.5/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: 'get_schedule.php?id=<?php echo $id; ?>',
                eventClick: function(event) {
                    Swal.fire({
                        title: 'Your Appointment',
                        text: event.title,
                    });
                }
            });
        });
    </script>
    <script>
        configuration = {
            allowInput: true,
            dateFormat: "Y-m-d",
            maxDate: "today"

        }
        flatpickr("#date_diagnosis", configuration);

        configuration = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K"

        }
        flatpickr("#time_diagnosis", configuration);
      </script>
      <script>
            document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('clearFormButton').addEventListener('click', function () {
            document.getElementById('sessionForm').reset();
        });
    });

</script>
<script>

function showData(id) {
    $.ajax({
        url: 'get_diagnosis.php',
        type: 'POST',
        data: {id: id, secret_key: 'helloimjaycearon' },
        success: function(response) {
            $('#dataModal .modal-body').html(response);
            $('#dataModal').modal('show');
        }
    });
}
      function validateInput(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 11) {
            inputElement.value = inputElement.value.slice(0, 11);
        }
    };
    function validateNum(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 6) {
            inputElement.value = inputElement.value.slice(0, 6);
        }
    };
</script>
<?php
include "../../db_connect/config.php";
$sql = "SELECT day_to_disable FROM disabled_days";
$result = $conn->query($sql);
$disableDates = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disableDates[] = $row['day_to_disable'];
    }
}
$sql = "SELECT day, is_available FROM availability";
$result = $conn->query($sql);
$disableDays = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['is_available'] == 0) {
            $disableDays[] = $row['day'];
        }
    }
}

$conn->close();
?>
<script>
    var configuration = {
        dateFormat: "Y-m-d",
        allowInput: true,
        minDate: new Date().fp_incr(1),
        maxDate: new Date().fp_incr(60),
        "disable": [
            function(date) {
                date.setHours(23, 59, 59, 999);
                var dateString = date.toISOString().split('T')[0];
                var dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                
                return <?php echo json_encode($disableDates); ?>.includes(dateString) ||
                       <?php echo json_encode($disableDays); ?>.includes(dayName[date.getDay()]);
            },
        ]
    };

    flatpickr("#d", configuration);
    function validateNum(inputElement) {
        inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
        if (inputElement.value.length > 6) {
            inputElement.value = inputElement.value.slice(0, 6);
        }
    };
</script>
    </body>
    </html>