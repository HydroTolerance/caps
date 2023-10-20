<?php
include "../function.php";
checklogin();
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
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

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
        } else {
            echo "Record not found";
            exit;
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

    if (isset($_POST['add_diagnosis'])) {
        include "../../db_connect/config.php"; // Include your database configuration

        $id = $_POST['id'];
        $diagnosis = $_POST['diagnosis'];
        $history = $_POST['history'];
        $date_diagnosis = $_POST['date_diagnosis'];
        $management = $_POST['management'];

        // Insert or update diagnosis information in zp_derma_record table
        $info_sql = "INSERT INTO zp_derma_record (patient_id, date_diagnosis, history, management, diagnosis) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE diagnosis=?";
        $info_stmt = mysqli_prepare($conn, $info_sql);
        mysqli_stmt_bind_param($info_stmt, "isssss", $id, $date_diagnosis, $history, $management, $diagnosis, $diagnosis);

        if ($info_stmt->execute()) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data Updated successfully.'
                }).then(function() {
                    window.location.href = 'edit_client_record.php?id=" . $id . "';
                });</script>";
        }else {
            echo" Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to add data.'
            });";
        }
        
        mysqli_stmt_close($info_stmt);
        mysqli_close($conn);
    }
    if (isset($_POST['add_appointment'])) {
        include "../../db_connect/config.php";

        $id = $_POST['id'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $services = $_POST['services'];

        $reference = generateReferenceCode();
        $appointment_id = generateAppointmentID();
        $currentTimestamp = date("Y-m-d H:i:s");

        $name_sql = "SELECT client_firstname, client_lastname, client_email FROM zp_client_record WHERE id=?";
        $name_stmt = mysqli_prepare($conn, $name_sql);
        mysqli_stmt_bind_param($name_stmt, "i", $id);
        mysqli_stmt_execute($name_stmt);
        $name_result = mysqli_stmt_get_result($name_stmt);
    
        if ($name_row = mysqli_fetch_assoc($name_result)) {
            $fname = $name_row['client_firstname'];
            $lname = $name_row['client_lastname'];
            $email = $name_row['client_email'];

            $info_sql = "INSERT INTO zp_appointment (client_id, firstname, appointment_id, reference_code, lastname, email, date, time, services, appointment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,'Pending')";
            $info_stmt = mysqli_prepare($conn, $info_sql);
            mysqli_stmt_bind_param($info_stmt, "issssssss", $id, $fname, $appointment_id, $reference, $lname, $email, $date, $time, $services);
    
            if (mysqli_stmt_execute($info_stmt)) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data Updated successfully.'
                }).then(function() {
                    window.location.href = 'edit_client_record.php?id=" . $id . "';
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
            }
        } else {
            echo "Client not found";
            exit;
        }
    mysqli_stmt_close($info_stmt);
    mysqli_close($conn);
    }
        
    if (isset($_POST['update_client'])) {
        include "../../db_connect/config.php";

        $id = $_POST['id'];
        $fname = $_POST['client_firstname'];
        $lname = $_POST['client_lastname'];
        $dob = $_POST['client_birthday'];
        $gender = $_POST['client_gender'];
        $contact = $_POST['client_number'];
        $email = $_POST['client_email'];
        $econtact = $_POST['client_emergency_person'];
        $relation = $_POST['client_relation'];
        $econtactno = $_POST['client_emergency_contact_number'];
        $sql_update_client = "UPDATE zp_client_record SET client_firstname=?, client_lastname=?, client_birthday=?, client_gender=?, client_number=?, client_email=?, client_emergency_person=?, client_relation=?, client_emergency_contact_number=? WHERE id=?";
        $stmt_update_client = mysqli_prepare($conn, $sql_update_client);
        mysqli_stmt_bind_param($stmt_update_client, "sssssssssi", $fname, $lname, $dob, $gender, $contact, $email, $econtact, $relation, $econtactno, $id);

        if ($stmt_update_client->execute()) {
            echo "<script>
            window.addEventListener('DOMContentLoaded', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Data Updated successfully.'
            }).then(function() {
                window.location.href = 'edit_client_record.php?id=" . $id . "';
            });
        });</script>";
    }else {
        echo" Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to add data.'
        });";
    }
    }
    if (isset($_POST['insert_session'])) {
        include "../../db_connect/config.php";
        $id = $_POST['id'];
        $sessionName = $_POST['session_name'];
        $session_stmt = mysqli_prepare($conn, "INSERT INTO zp_sessions (client_id, session_name) VALUES (?,?)");
        if ($session_stmt) {
            mysqli_stmt_bind_param($session_stmt, "is", $id , $sessionName);
            if (mysqli_stmt_execute($session_stmt)) {
                mysqli_stmt_close($session_stmt); // Close the prepared statement
                mysqli_close($conn); // Close the database connection
                echo "<script>
                window.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data Updated successfully.'
                }).then(function() {
                    window.location.href = 'edit_client_record.php?id=" . $id . "';
                });
            });</script>";
            } else {
                echo "Error creating ZP Session: " . mysqli_error($conn);
            }
        }
    } else if (isset($_POST['session_id']) && isset($_POST['diagnosis_text'])) {
        include "../../db_connect/config.php";
        $sessionId = $_POST['session_id'];
        $diagnosisText = $_POST['diagnosis_text'];
        $sessionDate = $_POST['diagnosis_date'];
        $sessionStart = $_POST['session_time_start'];
        $sessionEnd = $_POST['session_end_time'];
        $sql = "INSERT INTO zp_diagnoses (session_id, diagnosis_text, diagnosis_date, session_end_time, session_time_start) VALUES (?, ?, ?, ?, ?)";
        $diagnosis_stmt = mysqli_prepare($conn, $sql);
        if ($diagnosis_stmt) {
            mysqli_stmt_bind_param($diagnosis_stmt, "issss", $sessionId, $diagnosisText, $sessionDate, $sessionStart, $sessionEnd);
            if (mysqli_stmt_execute($diagnosis_stmt)) {
                mysqli_stmt_close($diagnosis_stmt);
                mysqli_close($conn);
                echo "<script>
                window.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data Updated successfully.'
                }).then(function() {
                    window.location.href = 'edit_client_record.php?id=" . $id . "';
                });
            });</script>";
            } else {
                echo "Error adding ZP Diagnosis: " . mysqli_error($conn);
            }
        }
    }
if (isset($_POST['update_diagnosis'])) {
    include "../../db_connect/config.php";
    $id = $_POST['id'];
    $editedHistory = $_POST['edit_history'];
    $editedDiagnosis = $_POST['edit_diagnosis'];
    $editedManagement = $_POST['edit_management'];

    // Update the record in the database
    $update_sql = "UPDATE zp_derma_record SET history=?, diagnosis=?, management=? WHERE id=?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "sssi", $editedHistory, $editedDiagnosis, $editedManagement, $id);

    if ($update_stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($update_stmt);
    mysqli_close($conn);
}


if (isset($_POST['archive'])) {
    $id = $_POST['id'];
    include "../../db_connect/config.php";
    $archive_sql = "UPDATE zp_derma_record SET archive = 1 WHERE id = ?";
    $archive_stmt = mysqli_prepare($conn, $archive_sql);
    mysqli_stmt_bind_param($archive_stmt, "i", $id);

    if ($archive_stmt->execute()) {
        echo "Record archived successfully";
    } else {
        echo "Error archiving record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($archive_stmt);
    mysqli_close($conn);
}




    
    function generateReferenceCode() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $reference = '';
        $length = 6;
    
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $reference .= $characters[$randomIndex];
        }
    
        return $reference;
    }
    
    function generateAppointmentID() {
        $counterFile = '../../CapDev/appointment_counter.txt';
        $counter = file_get_contents($counterFile);
        $counter++;
        $appointmentID = 'apt#' . str_pad($counter, 3, '0', STR_PAD_LEFT);
        file_put_contents($counterFile, $counter);
    
        return $appointmentID;
    }
    
    ?>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="mx-3">
                        <form method="post" >
                            <div class="container">
                            <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i> Go Back</a>
                        <h2 style="color:6537AE;" class="text-center">Edit Client Record</h2>
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class=" col-xl-3 col-lg-12">
                                        <div class="bg-white pt-5 text-center rounded border mb-3">
                                            <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 155px; height: 155px; border-radius: 50%; display: block; margin: 0 auto;"><br>
                                            <div class="bg-purple p-2 rounded-bottom">
                                                <label class="text-center text-light"><b><?php echo $recordId; ?></b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-12 mb-4">
                                        <div class="bg-white p-5 border rounded">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="mb-3">First Name:</label>
                                                    <input class="form-control" type="text" name="client_firstname" value="<?php echo $fname; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Middle Name:</label>
                                                    <input class="form-control" type="text" name="client_middle" value="<?php echo $mname; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Last Name:</label>
                                                    <input class="form-control" type="text" name="client_lastname" value="<?php echo $lname; ?>" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="" class="mb-3">Suffix</label>
                                                    <input type="text" class="form-control" name="client_suffix" value="<?php echo $sname; ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="mb-3">Gender:</label>
                                                    <select class="form-control" name="client_gender" required>
                                                        <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                                                        <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="mb-3">Date of Birth:</label>
                                                    <input class="form-control" type="date" name="client_birthday" value="<?php echo $dob; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white p-5 border rounded mb-3" style="padding: 20px;">
                                <div class="row mb-3">
                                    <label class="mb-2">EMERGENCY PERSON:</label>
                                    <hr>
                                    <div class="col-md-5">
                                        <label class="mb-3">Contact Number:</label>
                                        <input class="form-control" type="text" name="client_number" value="<?php echo $contact; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-3">Email:</label>
                                        <input class="form-control" type="email" name="client_email" value="<?php echo $email; ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="mb-3">Contact Person:</label>
                                        <input class="form-control" type="text" name="client_emergency_person" value="<?php echo $econtact; ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="mb-3">Relation:</label>
                                        <input class="form-control" type="text" name="client_relation" value="<?php echo $relation; ?>" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="mb-3">Contact Person Number:</label>
                                        <input class="form-control" type="text" name="client_emergency_contact_number" value="<?php echo $econtactno; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input class="btn btn-purple bg-purple text-white" type="submit" name="update_client" value="Update Information">
                                </div>
                            </div>
                        </form>
                    <div class="bg-white p-3 rounded-3 border">
                            <ul class="nav nav-tabs" >
                                <li class="nav-item">
                                    <a class="nav-link active" id="diagnosisTab" href="#">Diagnosis</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appointmentTab" href="#">Appointment</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sessionTab" href="#">Session</a>
                                </li>
                            </ul>
                        <!-- Container for the Diagnosis -->
                        <div id="diagnosisContainer" class="bg-white p-3 rounded-3">
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="mb-3" id="date_diagnosis_div"  style="width: 100%;">
                                    <label class="mb-3">Date of Diagnosis: <span class="text-danger">*</span></label>
                                    <input class="form-control" id="date_diagnosis" name="date_diagnosis" type="date" placeholder="Time of Diagnosis" required>
                                </div>
                                <div class="mb-3" id="history_div">
                                    <label class="mb-3">History of the Patient: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="history" id="summernote" rows="4" required></textarea>
                                </div>
                                <div class="mb-3" id="diagnosis_div">
                                    <label class="mb-3">Diagnosis of the Patient: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="diagnosis" id="summernote" rows="4" required></textarea>
                                </div>
                                <div class="mb-3" id="management_div">
                                    <label class="mb-3">Management: <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="management" id="summernote" rows="4" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <input class="btn btn-purple bg-purple text-white" type="submit" name="add_diagnosis" value="Add Diagnosis">
                                </div>
                            </form>
                            <div>
                            <div class="text-dark border rounded p-3 mb-3">
                                <h2 style="color: 6537AE;" class="text-center">Diagnosis of the Patient</h2>
                                    <table id="clientTable" class="table table table-bordered table-striped nowrap" style="width:100%">
                                        <thead>
                                                    <tr>
                                                        <th>Date:</th>
                                                        <th>History:</th>
                                                        <th>Diagnosis:</th>
                                                        <th>Management:</th>
                                                        <th>Action:</th>
                                                    </tr>
                                                </thead>
                                        <tbody>
                                        <?php
                                            if (isset($_GET['id'])) {
                                                include "../../db_connect/config.php";
                                                $id = $_GET['id'];
                                                $stmt = mysqli_prepare($conn, "SELECT * FROM zp_derma_record WHERE patient_id=? AND archive != '1'");
                                                mysqli_stmt_bind_param($stmt, "i", $id);
                                                mysqli_stmt_execute($stmt);
                                                $info_result = mysqli_stmt_get_result($stmt);
                                                while ($info_row = mysqli_fetch_assoc($info_result)) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo date('M d, Y', strtotime($info_row['date_diagnosis']))?></td>
                                                            <td><?php echo $info_row['history']?></td>
                                                            <td><?php echo $info_row['diagnosis']?></td>
                                                            <td><?php echo $info_row['management']?></td>
                                                            <td>
                                                                <div style="display: flex; gap: 10px;">
                                                                    <button type="button" onclick="showData('<?php echo $info_row['id']; ?>')" class="btn btn-purple bg-purple text-white btn-sm" data-zep-acc="<?php echo $info_row['id']; ?>">Edit</button>
                                                                    <form method="post" action="">
                                                                        <input type="hidden" name="id" value="<?php echo $info_row['id']; ?>">
                                                                        <button type="submit" name="archive" class="btn btn-danger btn-sm">Archive</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <?php
                                            }           mysqli_stmt_close($stmt);
                                                mysqli_close($conn);
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>     
                        </div>
                        </div>

                        <!-- Container for Appointment -->

                        <div id="appointmentContainer" style="display: none;" class="bg-white p-3 rounded-3">
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div>
                                    <label for="">Select Date Appointment<span class="text-danger">*</span></label>
                                    <input type="da" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" value="<?php echo isset($date) ? $date : ''; ?>" required>
                                </div>
                                <div>
                                <label>Select Time Appointment <span class="text-danger">*</span></label>
                                    <select class="form-control" name="time" id="time" required>
                                        <option value="" disabled selected>-- Select Time --</option>
                                        <?php if (isset($time)): ?>
                                            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                                        <?php endif; ?>
                                    </select>
                                    <div>
                                        <label>Services <span class="text-danger">*</span></label>
                                        <select class="form-select" name="services" required>
                                            <option value="">-- Select Service --</option>
                                            <option value="Nail">Nail</option>
                                            <option value="Hair">Hair</option>
                                            <option value="Skin">Skin</option>
                                            <option value="Face">Face</option>
                                        </select>
                                    </div>
                                <div class="mb-3 mt-3">
                                    <input type="submit" name="add_appointment" class="btn btn-purple bg-purple text-white" value="Add Appointment">
                                </div>
                            </form>
                        </div>
                            <div class="border rounded p-3 my-3">
                            
                            <div class="row">
                                <div class="col-md-6"> <!-- Calendar column -->
                                <div class="d-flex justify-content-center">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered my-3">
                                    <tr><th colspan='3' class='text-center' style='background-color: #f2f2f2;'>Upcoming Appointment</th></tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Service</th>
                                    </tr>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $id = $_GET['id'];
                                        include "../../db_connect/config.php";
                                        
                                        // Fetch upcoming appointments (assuming the date is in the future)
                                        $currentDate = date("Y-m-d");
                                        $upcomingAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = '$id' AND date >= '$currentDate'";
                                        $upcomingAppointmentsResult = mysqli_query($conn, $upcomingAppointmentsQuery);
                                        while ($appointmentRow = mysqli_fetch_assoc($upcomingAppointmentsResult)) {
                                            $appointmentDate = $appointmentRow['date'];
                                            $appointmentTime = $appointmentRow['time'];
                                            $appointmentService = $appointmentRow['services'];
                                            echo "<tr>";
                                            echo "<td>$appointmentDate</td>";
                                            echo "<td>$appointmentTime</td>";
                                            echo "<td>$appointmentService</td>";
                                            echo "</tr>";
                                        }
                                        
                                        // Add a header for past appointments
                                        echo "<tr><th colspan='3' class='text-center' style='background-color: #f2f2f2;'>Past Appointments</th></tr>";
                                        echo "<th>Date</th>";
                                        echo "<th>Time</th>";
                                        echo "<th>Service</th>";
                                        
                                        $pastAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = '$id' AND date < '$currentDate'";
                                        $pastAppointmentsResult = mysqli_query($conn, $pastAppointmentsQuery);
                                        while ($appointmentRow = mysqli_fetch_assoc($pastAppointmentsResult)) {
                                            $appointmentDate = $appointmentRow['date'];
                                            $appointmentTime = $appointmentRow['time'];
                                            $appointmentService = $appointmentRow['services'];
                                            echo "<tr>";
                                            echo "<td>$appointmentDate</td>";
                                            echo "<td>$appointmentTime</td>";
                                            echo "<td>$appointmentService</td>";
                                            echo "</tr>";
                                        }
                                        
                                        mysqli_close($conn);
                                    }
                                    ?>
                                </table>

                            </div>
                            </div>
                            
                            </div>
                        </div>
                        <!-- Add Session Container -->
                    <div id="sessionContainer" class="bg-white p-3" style="display: none;">
                        <div class="container border rounded p-3">
                            <h2 class="text-center mt-3" style="color:#6537AE">Create a ZP Session</h2>
                            <form method="POST">
                                <label for="session_name">Session Name:</label>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control">
                                <input type="text" name="session_name" class="form-control" required>
                                <input type="submit" name="insert_session" class="btn mt-3  text-white" style="background-color:#6537AE" value="Add Session">
                            </form>
                        </div>
                        <div class="border rounded p-3 my-3">
                        <div>
                            <h2 class="my-3 text-center" class="color:#6537AE;">Session of the Client</h2>
                        </div>
                        <?php
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                include "../../db_connect/config.php";
                                $sessionsQuery = "SELECT * FROM zp_sessions WHERE client_id = '$id'";
                                $sessionsResult = mysqli_query($conn, $sessionsQuery);
                                if ($sessionsResult) {
                                    while ($sessionRow = mysqli_fetch_assoc($sessionsResult)) {
                                        $sessionId = $sessionRow['id'];
                                        $sessionName = $sessionRow['session_name'];
                                        ?>

                                        <div class="container rounded border my-3">
                                            <div class="row my-3">
                                                <div class="col-lg-6">
                                                    <h2>Services: <?= $sessionName ?></h2>
                                                    <form method="POST" id="sessionForm">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="session_id" value="<?= $sessionId ?>">
                                                            <div class="mt-3">
                                                                <label for="session_date" class="form-label">Session Date:</label>
                                                                <input type="date" class="form-control" name="diagnosis_date" id="date_diagnosis" placeholder="Select Date" required>
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="session_start_time" class="form-label">Start Time:</label>
                                                                <input type="time" class="form-control" id="time_diagnosis" name="session_time_start" placeholder="Select Session Start Time">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="session_end_time" class="form-label">End Time:</label>
                                                                <input type="time" class="form-control" id="time_diagnosis" name="session_end_time" placeholder="Select Session End Time">
                                                            </div>
                                                            <div class="mt-3">
                                                                <label for="session_notes" class="form-label">Session Notes:</label>
                                                                <textarea class="form-control" name="diagnosis_text" rows="4"></textarea>
                                                            </div>
                                                            <input type="submit" class="btn mt-3 text-white" style="background-color:#6537AE" value="Add Information">
                                                            <button type="button" class="btn btn-secondary mt-3" id="clearFormButton">Clear Form</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-lg-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Number of Session</th>
                                                            <th>Time Start of Session</th>
                                                            <th>Time end of Session</th>
                                                            <th>Date of Session</th>
                                                        </tr>
                                                        <?php
                                                        include "../../db_connect/config.php";
                                                        $diagnosesQuery = "SELECT * FROM zp_diagnoses WHERE session_id = $sessionId";
                                                        $diagnosesResult = mysqli_query($conn, $diagnosesQuery);

                                                        if ($diagnosesResult) {
                                                            $sessionNumber = 1; // Initialize session number
                                                            while ($diagnosisRow = mysqli_fetch_assoc($diagnosesResult)) {
                                                                $diagnosisText = $diagnosisRow['diagnosis_text'];
                                                                $sessionDate = $diagnosisRow['diagnosis_date'];
                                                                $sessionStart = $diagnosisRow['session_time_start'];
                                                                $sessionEnd = $diagnosisRow['session_end_time'];
                                                                ?>
                                                                <tr>
                                                                    <td><?= $sessionNumber ?></td>
                                                                    <td><?= date('F d, Y', strtotime($sessionDate)) ?></td>
                                                                    <td><?= date('h:i A', strtotime($sessionStart)) ?></td>
                                                                    <td><?= date('h:i A', strtotime($sessionEnd)) ?></td>
                                                                </tr>
                                                                <?php
                                                                $sessionNumber++;
                                                            }
                                                        } else {
                                                            echo "Error fetching diagnoses: " . mysqli_error($conn);
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </div>
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
        <div class="modal-dialog modal-dialog-centered">
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
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: 'get_schedule.php?id=<?php echo $id; ?>',
                eventClick: function(event) {
                    alert('Event clicked: ' + event.title);
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
        // Add an event listener to the "Clear Form" button
        document.getElementById('clearFormButton').addEventListener('click', function () {
            // Reset the form using JavaScript
            document.getElementById('sessionForm').reset();
        });
    });
</script>
<script>
function showData(id) {
$.ajax({
    url: 'edit_diagnosis.php',
    type: 'POST',
    data: { id: id },
    success: function (response) {
        $('#displayAccount .modal-body').html(response);
        $('#displayAccount').modal('show');
    }
})
}
</script>
<script>
    $(document).ready(function() {
    var table = $('#clientTable').DataTable({
        order: [[0, 'desc']],
        responsive: true,
        dom: "<'row'<'col-sm-1 mt-2 text-center'B><'col-md-1 mt-2 ' l><'col-md-10'f>>" +
     "<'row'<'col-md-12'tr>>" +
     "<'row'<'col-md-12'i><'col-md-12'p>>",
     buttons: [
    {
        extend: 'collection',
        text: '<i class="bi bi-funnel"></i>',
        buttons: ['copy', 'excel', 'pdf', 'csv', 'print']
    }
],

        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        select: true,
    });
})
</script>
<?php
include "../../db_connect/config.php";

// Fetch specific dates to disable from the database
$sql = "SELECT day_to_disable FROM disabled_days";
$result = $conn->query($sql);
$disableDates = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disableDates[] = $row['day_to_disable'];
    }
}

// Fetch specific days to disable from the database
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

</script>
    </body>
    </html>