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
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="mx-3">
                        <form method="post"  id="updateForm">
                            <div class="container">
                            <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i> </a>
                            <h2 style="color:6537AE;" class="text-center fw-bold">Edit Client Record</h2>
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="bg-white mb-4 p-5 text-center rounded border" style="height: 90%; padding-bottom: 25px;">
                                            <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 155px; height: 155px; border-radius: 50%; margin: 0 auto;"><br>
                                        </div>
                                    </div>

                                    <div class="col-xl-9 col-lg-12 mb-4">
                                        <div class="bg-white h-100 p-4 border rounded">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="mb-3 ">First Name:</label>
                                                    <input class="form-control" type="text" name="client_firstname" value="<?php echo $fname; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Middle Name:</label>
                                                    <input class="form-control" type="text" name="client_middle" value="<?php echo $mname; ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Last Name:</label>
                                                    <input class="form-control" type="text" name="client_lastname" value="<?php echo $lname; ?>"  required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="" class="mb-3">Suffix</label>
                                                    <input type="text" class="form-control" name="client_suffix" value="<?php echo $sname; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="mb-3">Gender:</label>
                                                    <select class="form-control" name="client_gender" required>
                                                        <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                                                        <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Date of Birth:</label>
                                                    <input class="form-control" type="date" name="client_birthday" value="<?php echo $dob; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="mb-3">Contact Number:</label>
                                                    <input class="form-control" type="text" name="client_number" value="<?php echo $contact; ?>" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="mb-3">Email:</label>
                                                    <input class="form-control" type="email" name="client_email" value="<?php echo $email; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white p-5 border rounded mb-3" style="padding: 20px;">
                                    <div class="row mb-3">
                                        <label class="mb-2">CLIENT ADDRESS:</label>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom07" class="form-label mb-3">House Number</label>
                                            <input class="form-control" id="validationCustom07" type="text" value="<?php echo $houseNumber; ?>" name="client_house_number" required>
                                            <div class="invalid-feedback">Please enter the house number.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom08" class="form-label mb-3">Street Name</label>
                                            <input class="form-control" id="validationCustom08" type="text" value="<?php echo $streetName; ?>" name="client_street_name" required>
                                            <div class="invalid-feedback">Please enter the street name.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom09" class="form-label mb-3">Barangay</label>
                                            <input class="form-control" id="validationCustom09" type="text" value="<?php echo $barangay; ?>" name="client_barangay" required>
                                            <div class="invalid-feedback">Please enter the barangay.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom10" class="form-label mb-3">City</label>
                                            <input class="form-control" id="validationCustom10" type="text" value="<?php echo $city; ?>" name="client_city" required>
                                            <div class="invalid-feedback">Please enter the city.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom11" class="form-label mb-3">Province</label>
                                            <input class="form-control" id="validationCustom11" type="text" value="<?php echo $province; ?>" name="client_province" required>
                                            <div class="invalid-feedback">Please enter the province.</div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="validationCustom12" class="form-label mb-3">Postal Code</label>
                                            <input class="form-control" id="validationCustom12" type="text" value="<?php echo $postalCode ?>" name="client_postal_code" required>
                                            <div class="invalid-feedback">Please enter the postal code.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white p-5 border rounded mb-3" style="padding: 20px;">
                                    <div class="row mb-3">
                                        <label class="mb-2">EMERGENCY PERSON:</label>
                                        <hr>
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
                                    <button class="btn btn-purple bg-purple text-white" type="submit" id="submitBtn" name="update_client">Submit</button>
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
                                                        <th>History:</th>
                                                        <th>Diagnosis:</th>
                                                        <th>Diagnosis:</th>
                                                        <th>Management:</th>
                                                        <th>Notes:</th>
                                                        <th>All Information</th>
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
                                                            <td><?php echo date('F d, Y', strtotime($info_row['date_diagnosis']))?></td>
                                                            <td><?php echo $info_row['history'], 0, 60?></td>
                                                            <td><?php echo substr($info_row['diagnosis'], 0, 60) . "..." ?></td>
                                                            <td><?php echo $info_row['diagnosis']; ?></td>
                                                            <td><?php echo $info_row['management']?></td>
                                                            <td><?php echo strlen($info_row['notes']) > 50 ? substr($info_row['notes'], 0, 50) . '...' : $info_row['notes']; ?></td>
                                                            <td>
                                                                <div style="display: flex; gap: 10px;">
                                                                    <button type="button" onclick="showData('<?php echo $info_row['id']; ?>')" class="btn btn-purple bg-purple text-white btn-sm" data-zep-acc="<?php echo $info_row['id']; ?>">View</button>
                                                                    <form method="post" action="">
                                                                        <input type="hidden" name="id" value="<?php echo $info_row['id']; ?>">
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
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
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
</script>
<script>
    $(document).ready(function() {
    var table = $('#clientTable').DataTable({
        order: [[0, 'desc']],
        responsive: true,
     buttons: [
    {
        extend: 'collection',
        text: '<i class="bi bi-funnel"></i>',
        buttons: [
            {
                header: {
                    image: 'https://i.kym-cdn.com/photos/images/newsfeed/002/440/417/671'
                },
                extend: 'pdfHtml5',
                text: 'PDF',
                title: 'Z-Skin Care Report',
                exportOptions: {
                    columns: [0, 1, 3, 4]
                },
                customize: function(doc) {
            doc.content[1].table.widths = ['25%', '25%', '25%', '25%'];
            doc.styles.title = {
                color: '#2D1D10',
                fontSize: '16',
                alignment: 'center'
            };
            doc.content[1].table.headerRows = 1;
            doc.content[1].table.body[0].forEach(function(cell) {
                cell.fillColor = '#6537AE';
                cell.color = '#fff';
            });
            for (var row = 0; row < doc.content[1].table.body.length; row++) {
                var rowData = doc.content[1].table.body[row];
                for (var col = 0; col < rowData.length; col++) {
                    var cell = rowData[col];
                    cell.border = [0, 0, 0, 1];
                }
            }
            doc.content.splice(1, 0, {
  layout: 'noBorders',
  table: {
    widths: ['*', '*'],
    body: [
      [
        {
          text: 'Name: ' + '<?php echo $fname . " " . $mname . " " . $lname . " " . $sname; ?>',
          margin: [10, 0, 0, 5],
          alignment: 'left'
        },
        {
          text: 'DOB: ' + '<?php echo $dob; ?>',
          margin: [0, 0, 10, 5],
          alignment: 'right'
        }
      ],
      [
        {
          text: 'Gender: ' + '<?php echo $gender; ?>',
          margin: [10, 0, 0, 5],
          alignment: 'left'
        },
        {
          text: 'Contact: ' + '<?php echo $contact; ?>',
          margin: [0, 0, 10, 5],
          alignment: 'right'
        }
      ],
      [
        {
          text: 'Email: ' + '<?php echo $email; ?>',
          margin: [10, 0, 0, 5],
          alignment: 'left'
        },
        {
          text: 'Emergency Contact: ' + '<?php echo $econtact; ?>',
          margin: [0, 0, 10, 5],
          alignment: 'right'
        }
      ],
      [
        {
          text: 'Relation: ' + '<?php echo $relation; ?>',
          margin: [10, 0, 0, 5],
          alignment: 'left'
        },
        {
          text: 'Emergency Contact No: ' + '<?php echo $econtactno; ?>',
          margin: [0, 0, 10, 5],
          alignment: 'right'
        }
      ],
      [
        {
          text: 'Address: ' + '<?php echo $houseNumber . " " . $streetName  . " " . $barangay . " " . $province; ?>',
          margin: [10, 0, 0, 5],
          alignment: 'left'
        },
        {
          text: 'Postal Code: ' + '<?php echo $postalCode; ?>',
          margin: [0, 0, 10, 5],
          alignment: 'right'
        }
      ],
    ]
  }
});



        },
    },
            'copy',
            {
                extend: 'excelHtml5',
                text: 'Excel',
                title: 'Z-Skin Care Report',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 3, 4,],
                }
            },
            {
                    extend: 'print',
                    text: 'Print',
                    customize: function (win) {
                        $(win.document.body)
                            .find('table')
                            .addClass('compact-print-table');
                    }
                }
        ]
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

</script>
<script>
document.getElementById('updateForm').addEventListener('submit', function (event) {
    event.preventDefault();
    document.getElementById('submitBtn').disabled = true;

    Swal.fire({
        title: 'Confirm Update',
        text: 'Are you sure you want to update this data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        document.getElementById('submitBtn').disabled = false;

        if (result.isConfirmed) {
            const form = event.target;
            const formData = new FormData(form);

            fetch('arola.php', {
                method: 'POST',
                body: formData,
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update data.'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data Updated successfully.'
                    }).then(function() {
                        window.location.href = 'view.php?id=<?php echo $id; ?>';
                    });
                }
            });
        }
    });
});

</script>
    </body>
    </html>