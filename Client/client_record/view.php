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
        
    </head>
    <style>
        .nav-link{
            color: purple;
        }
        
    </style>
    <body>
        
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="mx-3">
                        <h2 style="color:6537AE;" class="text-center">Client Record</h2>
                        <form method="post" >
                            <div class="container">
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $userData['id']; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class=" col-xl-3 col-lg-12">
                                        <div class="bg-white pt-5 text-center rounded border mb-3">
                                            <img src="<?php echo $userData['client_avatar']; ?>" alt="Avatar" style="width: 155px; height: 155px; border-radius: 50%; display: block; margin: 0 auto;"><br>
                                            <div class="bg-purple p-2 rounded-bottom">
                                                <label class="text-center text-light"><b><?php echo $userData['id']; ?></b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-12 mb-4">
                                        <div class="bg-white px-5 py-3 border rounded">
                                            <div class="row mb-3">
                                                <div class="row">
                                                    <strong><label class="mb-2">CLIENT INFORMATION:</label></strong>
                                                    <hr>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><p>Full Name: </p></strong>
                                                    <p><?php echo ($userData['client_firstname']. ", " .$userData['client_lastname']. " " .$userData['client_middle']. " " .$userData['client_suffix']); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><label class="mb-3">Email:</label></strong>
                                                    <p><?php echo $userData['client_email'] ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><label class="mb-3">Contact Number:</label></strong>
                                                    <p><?php echo $userData['client_number'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <strong><p>Gender: </p></strong>
                                                    <p><?php echo $userData['client_gender']; ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong><p>Date of Birth: </p></strong>
                                                    <p><?php echo $userData['client_birthday']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white p-5 border rounded mb-3" style="padding: 20px;">
                                <div class="row mb-3">
                                    <strong><label class="mb-2">EMERGENCY CONTACT PERSON:</label></strong>
                                    <hr>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong><label class="mb-3">Contact Person:</label></strong>
                                        <p><?php echo $userData['client_emergency_person'] ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label class="mb-3">Relation:</label></strong>
                                        <p><?php echo $userData['client_relation'] ?></p>
                                    </div>
                                    <div class="col-md-5">
                                        <strong><label class="mb-3">Relation:</label></strong>
                                        <p><?php echo $userData['client_emergency_contact_number'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <div class="bg-white p-3 rounded-3 border">
                            <ul class="nav nav-tabs" >
                                <li class="nav-item">
                                    <a class="nav-link active" id="appointmentTab" href="#">Appointment</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sessionTab" href="#">Session</a>
                                </li>
                            </ul>
                            <div id="appointmentContainer" >
                            <div class="d-flex justify-content-between align-items-center m-3">
                                <h2>Appointments</h2>
                            </div>
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

                                            include "../../db_connect/config.php";
                                            $currentDate = date("Y-m-d");
                                            $upcomingAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = ? AND date >= ?";
                                            $stmt = mysqli_prepare($conn, $upcomingAppointmentsQuery);
                                            mysqli_stmt_bind_param($stmt, "ss", $userData['id'], $currentDate);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            while ($appointmentRow = mysqli_fetch_assoc($result)) {
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

                                            $pastAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = ? AND date < ?";
                                            $stmt = mysqli_prepare($conn, $pastAppointmentsQuery);
                                            mysqli_stmt_bind_param($stmt, "ss", $userData['id'], $currentDate);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            while ($appointmentRow = mysqli_fetch_assoc($result)) {
                                                $appointmentDate = $appointmentRow['date'];
                                                $appointmentTime = $appointmentRow['time'];
                                                $appointmentService = $appointmentRow['services'];
                                                echo "<tr>";
                                                echo "<td>$appointmentDate</td>";
                                                echo "<td>$appointmentTime</td>";
                                                echo "<td>$appointmentService</td>";
                                                echo "</tr>";
                                            }

                                            // Close the prepared statement and database connection
                                            mysqli_stmt_close($stmt);
                                            mysqli_close($conn);
                                        ?>
                                    </table>
                                </div>

                                </div>
                            </div>
                            <div id="sessionContainer" class="bg-white p-3" style="display: none;">
                        <div class="container border rounded p-3">
                        <div class="border rounded p-3 my-3">
            <h2 class="my-3 text-center" style="color:#6537AE;">Session of the Client</h2>
        </div>
        <?php
            include "../../db_connect/config.php";
            $sessionsQuery = "SELECT * FROM zp_sessions WHERE client_id = ?";
            $stmt = mysqli_prepare($conn, $sessionsQuery);
            mysqli_stmt_bind_param($stmt, "i", $userData['id']);
            mysqli_stmt_execute($stmt);
            $sessionsResult = mysqli_stmt_get_result($stmt);

            if ($sessionsResult) {
                while ($sessionRow = mysqli_fetch_assoc($sessionsResult)) {
                    $sessionId = $sessionRow['id'];
                    $sessionName = $sessionRow['session_name'];
                    ?>

                    <div class="container rounded border my-3">
                        <div class="row my-3">
                            <div>
                                <h2>Services: <?= $sessionName ?></h2>
                                <div>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Number of Session</th>
                                            <th>Time Start of Session</th>
                                            <th>Time end of Session</th>
                                            <th>Date of Session</th>
                                        </tr>
                                        <?php
                                        $diagnosesQuery = "SELECT * FROM zp_diagnoses WHERE session_id = ?";
                                        $stmt = mysqli_prepare($conn, $diagnosesQuery);
                                        mysqli_stmt_bind_param($stmt, "i", $sessionId);
                                        mysqli_stmt_execute($stmt);
                                        $diagnosesResult = mysqli_stmt_get_result($stmt);

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
                    </div>
                    <?php
                }
            } else {
                echo "Error fetching sessions: " . mysqli_error($conn);
            }

            // Close the prepared statement and database connection
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        ?>
    </div>
                        </div>
                        
                            
                        </div>
                        
                        </div>
                        
                        <!-- Container for Appointment -->


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
                        events: './get_schedule.php?id=<?php echo $userData['id']; ?>',
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
<script>
    function showDiagnosisSection() {
        document.getElementById('diagnosisContainer').style.display = 'block';
        document.getElementById('appointmentContainer').style.display = 'none';
        document.getElementById('diagnosisTab').classList.add('active');
        document.getElementById('appointmentTab').classList.remove('active');
    }
    function showAppointmentSection() {
        document.getElementById('diagnosisContainer').style.display = 'none';
        document.getElementById('appointmentContainer').style.display = 'block';
        document.getElementById('appointmentTab').classList.add('active');
        document.getElementById('diagnosisTab').classList.remove('active');
    }
    document.getElementById('diagnosisTab').addEventListener('click', showDiagnosisSection);
    document.getElementById('appointmentTab').addEventListener('click', showAppointmentSection);
</script>

    </body>
    </html>
