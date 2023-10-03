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
                        <h2 style="color:6537AE;" class="text-center">View Client Record</h2>
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
                                    <a class="nav-link active" id="diagnosisTab" href="#">Diagnosis</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="appointmentTab" href="#">Appointment</a>
                                </li>
                            </ul>
                        <!-- Container for the Diagnosis -->
                        <div id="diagnosisContainer" class="bg-white p-3 rounded-3">
                            <div class="text-dark rounded-4 mb-3">
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
                                        include "../../db_connect/config.php";
                                        if ($stmt = mysqli_prepare($conn, "SELECT * FROM zp_derma_record WHERE patient_id = ?")) {
                                            mysqli_stmt_bind_param($stmt, "i", $userData['id']);
                                            mysqli_stmt_execute($stmt);
                                            $info_result = mysqli_stmt_get_result($stmt);
                                        while ($info_row = mysqli_fetch_assoc($info_result)) {
                                        echo "<tr>";
                                        echo "<td>" . date('M d, Y', strtotime($info_row['date_diagnosis'])) . "</td>";
                                        echo "<td>" . $info_row['history'] . "</td>";
                                        echo "<td>" . $info_row['diagnosis'] . "</td>";
                                        echo "<td>" . $info_row['management'] . "</td>";
                                        echo "</tr>";
                                        }
                                        mysqli_stmt_close($stmt);
                                        mysqli_close($conn);
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>     
                        </div>
                        <div id="appointmentContainer" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center m-3">
        <h2>Appointments</h2>
        <div class="status-indicator">
            <span class="status pending">Pending</span>
            <span class="status acknowledged">Acknowledged</span>
        </div>
    </div>
                                <div id="calendar"></div>
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
