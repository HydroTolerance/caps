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
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
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
            $email = $row['clinic_email'];
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
        $date = $_POST['date_appointment'];
        $time = $_POST['time_appointment'];
        $services = $_POST['services_appointment'];
        
        $name_sql = "SELECT client_firstname, client_lastname FROM zp_client_record WHERE id=?";
        $name_stmt = mysqli_prepare($conn, $name_sql);
        mysqli_stmt_bind_param($name_stmt, "i", $id);
        mysqli_stmt_execute($name_stmt);
        $name_result = mysqli_stmt_get_result($name_stmt);
    
        if ($name_row = mysqli_fetch_assoc($name_result)) {
            $fname = $name_row['client_firstname'] ." ". $name_row['client_lastname'];

            $info_sql = "INSERT INTO zp_derma_appointment (patient_id, name_appointment, date_appointment, time_appointment, services_appointment) VALUES (?, ?, ?, ?, ?)";
            $info_stmt = mysqli_prepare($conn, $info_sql);
            mysqli_stmt_bind_param($info_stmt, "issss", $id, $fname, $date, $time, $services);
    
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
        $email = $_POST['clinic_email'];
        $econtact = $_POST['client_emergency_person'];
        $relation = $_POST['client_relation'];
        $econtactno = $_POST['client_emergency_contact_number'];

        // Update patient record in zp_client_record table
        $sql_update_client = "UPDATE zp_client_record SET client_firstname=?, client_lastname=?, client_birthday=?, client_gender=?, client_number=?, clinic_email=?, client_emergency_person=?, client_relation=?, client_emergency_contact_number=? WHERE id=?";
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
    
    ?>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="mx-3">
                        <a class="btn btn-warning" href="client_record.php">Cancel</a>
                        <h2 style="color:6537AE;" class="text-center">Client Record (Edit)</h2>
                        <form method="post" >
                            <div class="row mb-3">
                                <input class="form-label" type="hidden" name="id" value="<?php echo $id; ?>">
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <div class=" col-md-3">
                                    <div class="bg-white pt-5 text-center rounded border">
                                        <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%; display: block; margin: 0 auto;"><br>
                                        <div class="bg-purple py-2 rounded-bottom">
                                            <label class="text-center text-light"><b><?php echo $recordId; ?></b></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-4">
                                    <div class="bg-white p-5 border rounded">
                                        <div class="row">
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
                                        <div class="row mb-3">
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
                                <div class="col-md-11 bg-white p-5 border rounded mb-3">
                                <div class="row mb-3">
                                    <label class="mb-2">EMERGENCY PERSON:</label>
                                    <hr>
                                    <div class="col-md-5">
                                        <label class="mb-3">Contact Number:</label>
                                        <input class="form-control" type="text" name="client_number" value="<?php echo $contact; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-3">Email:</label>
                                        <input class="form-control" type="email" name="clinic_email" value="<?php echo $email; ?>" required>
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
                                    <input class="btn btn-purple bg-purple text-white" type="submit" name="update_client" value="Update">
                                </div>
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
                            </ul>
                        <!-- Container for the Diagnosis -->
                        <div id="diagnosisContainer" class="bg-white p-3 rounded-3">
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="mb-3">
                                    <label class="mb-3">Select an option:</label>
                                    <select class="form-control" id="diagnosisSelect">
                                        <option selected disabled>-- Set a Diagnosis --</option>
                                        <option value="date">Date of Diagnosis</option>
                                        <option value="history">History of the Patient</option>
                                        <option value="diagnosis">Diagnosis of the Patient</option>
                                        <option value="management">Management</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="date_diagnosis_div"  style="display: none; width: 100%;">
                                    <label class="mb-3">Date of Diagnosis:</label>
                                    <input class="form-control" name="date_diagnosis" type="date" required>
                                </div>
                                <div class="mb-3" id="history_div" style="display: none;">
                                    <label class="mb-3">History of the Patient:</label>
                                    <textarea class="form-control" name="history" id="summernote" rows="4" required></textarea>
                                </div>
                                <div class="mb-3" id="diagnosis_div" style="display: none;">
                                    <label class="mb-3">Diagnosis of the Patient:</label>
                                    <textarea class="form-control" name="diagnosis" id="summernote" rows="4" required></textarea>
                                </div>
                                <div class="mb-3" id="management_div" style="display: none;">
                                    <label class="mb-3">Management</label>
                                    <textarea class="form-control" name="management" id="summernote" rows="4" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <input class="btn btn-purple bg-purple text-white" type="submit" name="add_diagnosis" value="Add Diagnosis">
                                </div>
                            </form>
                            <div>
                            <div class="text-dark p-4 rounded-4 mb-3">
                                <h2 style="color: 6537AE;">Diagnosis</h2>
                                    <table class="table table-striped nowrap" id="clientTable" style="width:100%;">
                                        <thead>
                                                    <tr>
                                                        <th>Date:</th>
                                                        <th>History:</th>
                                                        <th>Diagnosis:</th>
                                                        <th>Management:</th>
                                                    </tr>
                                                </thead>
                                        <tbody>
                                        <?php
                                            if (isset($_GET['id'])) {
                                                include "../../db_connect/config.php";
                                                $id = $_GET['id'];
                                                $stmt = mysqli_prepare($conn, "SELECT * FROM zp_derma_record WHERE patient_id=?");
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
                                    <label for="">Schedule Date <span class="text-danger">*</span></label>
                                    <input type="da" class="form-control" placeholder="Enter Schedule Date" id="d" name="date_appointment" value="<?php echo isset($date) ? $date : ''; ?>" required>
                                </div>
                                <div>
                                <label>Select Time Appointment <span class="text-danger">*</span></label>
                                    <select class="form-control" name="time_appointment" id="time" required> <!-- Add required attribute here -->
                                        <option value="" disabled selected>-- Select Time --</option>
                                        <?php if (isset($time)): ?>
                                            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                                        <?php endif; ?>
                                    </select>
                                    <div>
                                        <label>Services <span class="text-danger">*</span></label>
                                        <select class="form-select" name="services_appointment" required>
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
                            <div class="d-flex justify-content-center">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
    <script src="js/record.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: './get_schedule.php?id=<?php echo $id; ?>',
            eventClick: function(event) {
                alert('Event clicked: ' + event.title);
            }
        });
            $('#clientTable').DataTable({
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                }
            });
    });
</script>

    </body>
    </html>