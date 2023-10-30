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
                        <h2 style="color:6537AE;" class="text-center">Client Profile</h2>
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
                        <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Client Diagnosis</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Appointment Schedule</button>
                        </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div id="diagnosisContainer" class="bg-white p-3 rounded-3">
                        
                            <div>
                            <div class="text-dark border rounded p-3 mb-3">
                                <h2 style="color: 6537AE;" class="text-center">Diagnosis of the Patient</h2>
                                    <table id="clientTable" class="table table table-bordered table-striped nowrap" style="width:100%">
                                        <thead>
                                                    <tr>
                                                        <th>Date:</th>
                                                        <th>Management:</th>
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
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div id="appointmentContainer" class="bg-white p-3 rounded-3">
                            
                            <div class="border rounded p-3 my-3">
                            
                                <div class="d-flex justify-content-center mb-3">
                                    <div id="calendar"></div>
                                </div>

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Upcomming Appointment</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Past Appoinment</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                            
                                            mysqli_close($conn);
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered my-3">
                                        <tr><th colspan='3' class='text-center' style='background-color: #f2f2f2;'>Past Appointment</th></tr>
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
