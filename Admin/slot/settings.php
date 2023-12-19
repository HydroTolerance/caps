<?php
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Availability</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<style>
 #pageloader {
        background: rgba(255, 255, 255, 0.9);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    .custom-loader {

        margin: 0 auto;
        margin-top: 35vh;
    }

    /* FlipX animation for the custom-loader and the image */
    @keyframes flipX {
        0% {
            transform: scaleX(1);
        }
        50% {
            transform: scaleX(-1);
        }
        100% {
            transform: scaleX(1);
        }
    }
    .flipX-animation {
        animation-name: flipX;
        animation-duration: 1s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;
    }
    .page-item.active .page-link {
    background-color: #6537AE !important;
    color: #fff !important;
    border: #6537AE;
}
.page-link {
    color: black !important;
}
th{
   background-color:#6537AE  !important;
   color: #fff  !important;
}
</style>
<body>
<div id="pageloader">
    <div class="custom-loader flipX-animation"></div>
    <div class="text-center">
        <img src="../../t/images/6.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
    </div>
    <h4 class="text-center" style="font-family: Lora;"> Please Wait</h4>
</div>
<?php
include "../../db_connect/config.php";
require 'phpmailer/PHPMailerAutoload.php';
if (isset($_POST['submit'])) {
    $disable = $_POST['day_to_disable'];
    $newAppointmentDate = $_POST['new_appointment_date'];
    $reason = $_POST['apt_reason'];
    $stmt = mysqli_prepare($conn, "INSERT INTO disabled_days (day_to_disable, new_appointment_date) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $disable, $newAppointmentDate);

    if (mysqli_stmt_execute($stmt)) {
        $affectedAppointments = getAffectedAppointments($disable);
        $updateStmt = mysqli_prepare($conn, "UPDATE zp_appointment SET date = ?, apt_reason = ?, appointment_status = 'Rescheduled (Admin)' WHERE id = ?");
        foreach ($affectedAppointments as $appointment) {
            $appointmentId = $appointment['id'];
            mysqli_stmt_bind_param($updateStmt, "ssi", $newAppointmentDate, $reason, $appointmentId);
            mysqli_stmt_execute($updateStmt);
            sendRescheduleEmail($appointment, $newAppointmentDate, $reason);
        }
        logActivity($conn, $userData['id'], $userData['clinic_lastname'], 'Admin Disable Date', $userData['clinic_role'], 'Disable Date');
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "The booking date successfully disable!"
                }).then(function() {
                    window.location = "settings.php"; // Redirect after user clicks OK
                });
            </script>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function getAffectedAppointments($disabledDate) {
    global $conn;
    $appointments = array();

    $allowedStatus = ["Rescheduled (Admin)", "Rescheduled (Client)", "Rescheduled (Derma)", "Acknowledged", "Pending"];

    $stmt = mysqli_prepare($conn, 'SELECT * FROM zp_appointment WHERE date = ? AND appointment_status IN (?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, "ssssss", $disabledDate, ...$allowedStatus);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        // Check if the appointment status is in the allowed list
        if (in_array($row['appointment_status'], $allowedStatus)) {
            $appointments[] = $row;
        }
    }

    return $appointments;
}

function sendRescheduleEmail($appointment, $newAppointmentDate ,$reason) {
    global $mail;
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
        $mail->addAddress($appointment['email'], $appointment['firstname'] . ' ' . $appointment['lastname']);
        $mail->isHTML(true);
        $mail->Subject = 'Appointment Update: Rescheduled';

        // Format the appointment date
        $formattedReason = $reason;
        $formattedAppointmentDate = date('F j, Y', strtotime($appointment['date']));
        $formattedNewAppointmentDate = date('F j, Y', strtotime($newAppointmentDate));
        $formattedReference = $appointment['reference_code'];
        // Customized message with appointment details and CSS styles
        $message = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                    }
                    .container {
                        width: 80%;
                        margin: 20px auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 5px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #6537AE;
                    }
                    p {
                        color: #333;
                    }
                    strong {
                        font-weight: bold;
                    }
                    .signature {
                        margin-top: 20px;
                        color: #777;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Appointment Update: Rescheduled</h1>
                    <p>Dear ' . $appointment['firstname'] . ' ' . $appointment['lastname'] . ',</p>
                    <p>We want to inform you that your appointment scheduled for <strong>' . $formattedAppointmentDate . '</strong> has been rescheduled.</p>
                    <p>Your new appointment date is <strong>' . $formattedNewAppointmentDate . '</strong>. We apologize for any inconvenience this may cause.</p>
                    <p> ' . $formattedReason  . '</p>
                    <p>Thank you for your transaction. Please note that rescheduling your appointment is limited to 5 attempts, and cancelling is allowed only once. To proceed with rescheduling or cancelling, <a href="https://zephyderm.infinityfreeapp.com/t/reschedule.php?reference_code=' . $formattedReference . '">tap here.</a></p>
                    <p>Thank you for your understanding.</p>
                    <p class="signature">Best regards,<br>Z Skin Care Center</p>
                </div>
            </body>
            </html>
        ';
        $mail->Body = $message;
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
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
                    <div class="bg-white py-3 mb-3 border border-bottom">
                        <div class="d-flex justify-content-between mx-4">
                            <div>
                            <h2 style="color:6537AE;" class="fw-bold">DISABLING OF APPOINTMENT DATES</h2>
                            </div>
                            <div class="align-items-center">
                                <a class="btn bg-purple text-white" onclick="DisableDaysModal();">CREATE</a>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-12">
                </div>
                    <div class="col-lg-12">
            <div class="bg-white p-3 rounded-3 border mx-3">
            <table class="table table-bordered  table-striped nowrap" id="disableTable"  cellspacing="0" style="width: 100%;" >
                <thead>
                    <tr>
                        <th>Old Appointment Days</th>
                        <th>New Appointment Days</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                        include "../../db_connect/config.php";
                        $stmt = mysqli_prepare($conn, 'SELECT id, day_to_disable, new_appointment_date FROM disabled_days ORDER BY new_appointment_date DESC');
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $id, $days, $newdays);
                        while(mysqli_stmt_fetch($stmt)) {
                        ?>
                        <tr>
                        <td><?= date('F j, Y', strtotime($days))?></td>
                        <td><?= date('F j, Y', strtotime($newdays)) ?></td>
                        <td>
                            <a href="#" onclick="deleteDays(<?php echo $id;?>)" class="btn btn-outline-purple" type="submit" name="update_data" va>Delete</a>
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

<div class="modal fade" id="DisableDaysModal" tabindex="-1" aria-labelledby="DisableDaysModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DisableDaysModalLabel">Add Specific Day to Disable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- create form will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function() {
        $('#disableTable').DataTable({
        responsive: true,
        "ordering": false,
        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        });
    });
    document.getElementById('updateForm').addEventListener('submit', function (event) {
    event.preventDefault();
    Swal.fire({
        title: 'Confirm Update',
        text: 'Are you sure you want to update this data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            const form = event.target;
            const formData = new FormData(form);

            fetch('update_availability.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data Updated successfully.'
                    }).then(function() {
                        window.location.href = 'settings.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update data.'
                    });
                }
            });
        }
    });
});
function DisableDaysModal(id) {
    verifyAdminPassword('create', () => {
        $.ajax({
            url: 'add_disable.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                $('#DisableDaysModal .modal-body').html(response);
                $('#DisableDaysModal').modal('show');
            }
        });
    });
    }
    
    function deleteDays(id) {
        verifyAdminPassword('create', () => {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_days.php',
                    type: 'GET',
                    data: { id: id },
                    success: function (response) {
                        window.location.href = 'settings.php';
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error deleting FAQ: ' + xhr.responseText,
                        });
                    }
                });
            }
        });
        return false;
    }
        )}
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
