
<?php
include "../function.php";
checklogin('Client');

$userData = $_SESSION['id'];
$fname = $userData['client_firstname'];
$mname = $userData['client_middle'];
$lname = $userData['client_lastname'];
$sname = $userData['client_suffix'];
$dob = $userData['client_birthday'];
$gender = $userData['client_gender'];
$contact = $userData['client_number'];
$email = $userData['client_email'];
$econtact = $userData['client_emergency_person'];
$relation = $userData['client_relation'];
$econtactno = $userData['client_emergency_contact_number'];
$houseNumber = $userData['client_house_number'];
$streetName = $userData['client_street_name'];
$city = $userData['client_city'];
$barangay = $userData['client_barangay'];
$province = $userData['client_province'];
$postalCode = $userData['client_postal_code'];
$isClientLoggedIn = isset($_SESSION['id']);
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
    </head>
    <style>
        .nav-link{
            color: purple;
        }
        
    </style>
    <body>
        
<nav class="navbar navbar-expand-lg px-3" style="background-color: transparent; background-color: #6537AE; z-index: 9999;" id="s1">
  <div class="container-fluid">
  <a class="navbar-brand mt-1" href="../../index.php">
    <img src="../../t/images/zephyderm.png" alt="" height="30px" width="230px" class="mb-2">
  </a>
    <button class="navbar-toggler text-white custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
        <a class="nav-link active  text-white fs-5" href="../../index.php" id="s5">Home</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="../../t/about.php" id="s5">About</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="../../t/service.php" id="s5">Services</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="../../t/FAQ.php" id="s5">FAQ</a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white fs-5" href="../../t/contact.php" id="s5">Contact</a>
        </li>
      </ul> 
        <?php if ($isClientLoggedIn): ?>
        <div class="dropdown float-start">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../img/avatar/<?php echo $userData['client_avatar']; ?>" class="rounded-circle" height="40px" width="40px">
                    <span class="d-none d-sm-inline mx-1"></span>
                </a>
                <ul class="dropdown-menu text-small shadow dropdown-menu-end" style="left: -10px;" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                </ul>
            </div>
            
        <?php else: ?>
            <a href="../../login.php" class="btn btn-outline-light mx-2" type="submit" id="s5">Login</a>
        <?php endif; ?>
        <a href="../../t/booking.php" class="btn btn-outline-light float-start ms-3" type="submit" id="s5">Book an Appointment</a>
    </div>
  </div>
</nav>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row">
                    
                    <div class="col-lg-12 my-5">
                    <h2 style="color:6537AE;" class="text-center">Client Profile</h2>
                    <div class="mx-3">
                        
                        <form method="post" >
                            <div class="container">
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $userData['id']; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="bg-white mb-4 p-5 text-center rounded border" style="height: 90%; padding-bottom: 25px;">
                                            <img src="../../img/avatar/<?php echo $userData['client_avatar']; ?>" alt="Avatar" style="width: 155px; height: 155px; border-radius: 50%; margin: 0 auto;"><br>
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
                                                    <strong><p>Full Name </p></strong>
                                                    <p><?php echo ($userData['client_lastname']. ", " .$userData['client_firstname']. " " .$userData['client_middle']. " " .$userData['client_suffix']); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><label class="mb-3">Email</label></strong>
                                                    <p><?php echo $userData['client_email'] ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><label class="mb-3">Contact Number</label></strong>
                                                    <p><?php echo $userData['client_number'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <strong><p>Gender </p></strong>
                                                    <p><?php echo $userData['client_gender']; ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong><p>Date of Birth </p></strong>
                                                    <p><?php echo date('F, m Y', strtotime($userData['client_birthday'])); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white p-5 border rounded mb-3" style="padding: 20px;">
                                <div class="row mb-3">
                                    <strong><label class="mb-2">ADDRESS</label></strong>
                                    <hr>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong><label class="mb-3">House Number</label></strong>
                                        <p><?php echo $houseNumber ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label class="mb-3">Street Name</label></strong>
                                        <p><?php echo $streetName?></p>
                                    </div>
                                    <div class="col-md-5">
                                        <strong><label class="mb-3">Barangay</label></strong>
                                        <p><?php echo $barangay?></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong><label class="mb-3">City</label></strong>
                                        <p><?php echo $city?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label class="mb-3">Province</label></strong>
                                        <p><?php echo $province?></p>
                                    </div>
                                    <div class="col-md-5">
                                        <strong><label class="mb-3">Postal Code</label></strong>
                                        <p><?php echo $postalCode?></p>
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
                                        <strong><label class="mb-3">Contact Person</label></strong>
                                        <p><?php echo $userData['client_emergency_person'] ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label class="mb-3">Relation</label></strong>
                                        <p><?php echo $userData['client_relation'] ?></p>
                                    </div>
                                    <div class="col-md-5">
                                        <strong><label class="mb-3">Relation:</label></strong>
                                        <p><?php echo $userData['client_emergency_contact_number'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        
                        <section>
                            <div class="bg-white rounded">
                            <h1 class="text-center pt-5" style="color: 6537AE;">Transaction History</h1>
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
                                <h2 style="color: 6537AE;" class="text-center">Diagnosis of Patient</h2>
                                    <table id="clientTable" class="table table table-bordered table-striped nowrap" style="width:100%">
                                        <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Management</th>
                                                    </tr>
                                                </thead>
                                        <tbody>
                                        <?php
                                                include "../../db_connect/config.php";
                                                $stmt = mysqli_prepare($conn, "SELECT * FROM zp_derma_record WHERE patient_id=? AND archive != '1'");
                                                mysqli_stmt_bind_param($stmt, "i", $userData['id']);
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
                                    <table class="table table-bordered my-3" id="diagnosisTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            include "../../db_connect/config.php";
                                            $currentDate = date("Y-m-d");
                                                $upcomingAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = ? AND date >= ?";
                                                $stmt = mysqli_prepare($conn, $upcomingAppointmentsQuery);
                                                mysqli_stmt_bind_param($stmt, "is", $userData['id'], $currentDate);
                                                mysqli_stmt_execute($stmt);
                                                $upcomingAppointmentsResult = mysqli_stmt_get_result($stmt);

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

                                                mysqli_stmt_close($stmt);
                                            ?>

                                    </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered my-3" id="appointmentTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include "../../db_connect/config.php";

                                        // Fetch upcoming appointments (assuming the date is in the future)
                                        $currentDate = date("Y-m-d");
                                            $pastAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = ? AND date < ?";
                                            $stmt = mysqli_prepare($conn, $pastAppointmentsQuery);
                                            mysqli_stmt_bind_param($stmt, "is", $userData['id'], $currentDate);
                                            mysqli_stmt_execute($stmt);
                                            $pastAppointmentsResult = mysqli_stmt_get_result($stmt);

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

                                            mysqli_stmt_close($stmt);
                                        ?>

                                    </tbody>
                                    </table>
                            </div>
                                

                            </div>
                            </div>
                            
                            </div>
                        </div>
                        </section>
                        
                        
                </div>
            </div>
        </div>
    </div>
    <script src="js/record.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
    $(document).ready(function() {
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
            alert('Event clicked: ' + event.title);
        }
        });
    });
        var table = $('#clientTable').DataTable({
        order: [[0, 'desc']],
        responsive: true,
        dom: "<'row'<'col-sm-1 mt-2 text-center'B><'col-md-1 mt-2 ' l><'col-md-10'f>>" +
     "<'row'<'col-md-12'tr>>" +
     "<'row'<'col-md-12'i><'col-md-12'p>>",
     "columnDefs": [
            { "orderable": false, "targets": [1] } // Disable sorting for the 2nd and 3rd columns (0-based index)
        ],
        buttons: [
            {
                header: {
                    image: 'https://i.kym-cdn.com/photos/images/newsfeed/002/440/417/671'
                },
                extend: 'pdfHtml5',
                text: 'PDF',
                title: 'Z-Skin Care Report',
                customize: function(doc) {
                    doc.content[1].table.widths = ['50%', '50%'];
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
          text: 'Date of Birth: ' + '<?php echo $dob; ?>',
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
        ],
        
        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        select: true,
    },

    );

    var diagnosisTable = $('#diagnosisTable').DataTable({
    "columnDefs": [
            { "orderable": false, "targets": [1, 2] } // Disable sorting for the 2nd and 3rd columns (0-based index)
        ]
});

var appointmentTable = $('#appointmentTable').DataTable({
"columnDefs": [
            { "orderable": false, "targets": [1, 2] } // Disable sorting for the 2nd and 3rd columns (0-based index)
        ]
});
})
</script>

    </body>
    </html>
