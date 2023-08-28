<?php
    include "../function.php";
    checklogin();
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
            $lname = $row['client_lastname'];
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
    ?>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "../sidebar.php"; ?>
            <div class="col main-content custom-navbar bg-light">
                <?php include "../navbar.php";?>
                <div class="ms-3">
                    <div class="m-2 bg-white text-dark p-4 rounded-4 border border-4 shadow-sm">
                        <h2 style="color:6537AE;" class="text-center mb-5">Client Record (View)</h2>
                        <div cl>
                            <div class="row mb-3 justify-content-center">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="col-md-2">
                                    <img class="justify content-center" src="<?php echo $avatar; ?>" alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%;"><br>
                                    <label class="text-center mt-3"><b><?php echo $recordId; ?></b></label>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <p class="fw-normal fs-1" style="margin-bottom: -20px;"><?php echo $fname . " " . $lname; ; ?></p><br>
                                    <label><b>Details:</b></label>
                                    <hr>
                                    <label class="mb-3"><b>Gender:</b> <?php echo $gender; ?></label><br>
                                    <label class="mb-3"><b>Day of Birth:</b> <?php echo $dob; ?></label><br>
                                    <label class="mb-3"><b>Contact Number:</b> <?php echo $contact; ?></label><br>
                                    <label class="mb-3"><b>Email:</b> <?php echo $email; ?></label><br>
                                </div>
                                <div class="col-md-5 col-sm-4">
                                    <label class="mb-2 mt-4"><b>EMERGENCY PERSON:</b></label>
                                    <hr>
                                    <label class="mb-3"><b>Contact Person:</b> <?php echo $econtact; ?></label><br>
                                    <label class="mb-3"><b>Contact Number Person:</b> <?php echo $econtactno; ?></label><br>
                                    <label class="mb-3"><b>Relation:</b> <?php echo $relation; ?></label><br>
                                </div>
                            </div>
                            <div class="row mb-3">
                                
                            </div>
                            <div class="row">
                                
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse">
                        <button onclick="showDiagnosis()" class="btn border-end border-top border-start">Show Diagnosis</button>
                        <button onclick="showAppointment()" class="btn border-end border-top border-start">Show Appointment</button>
                        </div>

                        <div id="diagnosisContainer" class="border p-3">
                            <div>
                            <div class="bg-white text-dark p-4 rounded-4 border border-4 shadow-sm mb-3">
                                <h2 style="color: 6537AE;">Diagnosis</h2>
                                <?php
                                if (isset($_GET['id'])) {
                                    include "../../db_connect/config.php";
                                    $id = $_GET['id'];
                                    $info_sql = "SELECT * FROM zp_derma_record WHERE patient_id=?";
                                    $info_stmt = mysqli_prepare($conn, $info_sql);
                                    mysqli_stmt_bind_param($info_stmt, "i", $id);
                                    mysqli_stmt_execute($info_stmt);
                                    $info_result = mysqli_stmt_get_result($info_stmt);

                                    if (mysqli_num_rows($info_result) > 0) {
                                        echo '<table class="table table-striped nowrap" id="clientTable">';
                                        echo '  <thead>
                                                    <tr>
                                                        <th style="width:20%">Date:</th>
                                                        <th style="width:20%">History:</th>
                                                        <th>Diagnosis:</th>
                                                        <th>Management:</th>
                                                    </tr>
                                                </thead>';
                                        echo '<tbody>';
                                        while ($info_row = mysqli_fetch_assoc($info_result)) {
                                            $date_diagnosis = $info_row['date_diagnosis'];
                                            $history = $info_row['history'];
                                            $diagnosis = $info_row['diagnosis'];
                                            $management = $info_row['management'];
                                            echo '
                                            <tr>
                                                <td>' . date("F jS Y ", strtotime(strval($date_diagnosis))) . '</td>
                                                <td>' . $history . '</td>
                                                <td>' . $diagnosis . '</td>
                                                <td>' . $management . '</td>
                                            </tr>';
                                        }
                                        echo '</tbody></table>';
                                    } else {
                                        echo '<p>No diagnosis information available for this patient.</p>';
                                    }

                                    mysqli_stmt_close($info_stmt);
                                    mysqli_close($conn);
                                }
                                ?>
                            </div>
                        </div>
                        </div>
                        <div id="appointmentContainer" style="display: none;" class="border p-3">
                            <div style="width: 70%;" class="d-flex justify-content-center">
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
                    // Initialize Summernote on the textarea
                    $(document).ready(function() {
                        $('#calendar').fullCalendar({
                        editable: true,
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        events: './get_schedule.php?id=<?php echo $id; ?>', // Add the user ID
                        eventClick: function(event) {
                            // Handle event click here
                            alert('Event clicked: ' + event.title);
                        }
                    });
                    $('#clientTable').DataTable({
                        responsive: true,
                        rowReorder: {
                            selector: 'td:nth-child(2)'
                        },
                    });
                });
    </script>
    </body>
    </html>
