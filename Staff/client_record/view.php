<?php
include "../function.php";
checklogin('Staff');
$userData = $_SESSION['id'];
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>View Record</title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
        <style>
        th{
        background-color:#6537AE  !important;
        color: #fff  !important;
        }
        
        .outline {
        border: #6537AE 2px solid;
        background-color: white;
        color: #6537AE;
        padding: 7px 15px;
        }
        .outline:hover {
            border: #6537AE 2px solid;
            background-color: #6537AE;
            color: white;
            padding: 7px 15px;
        }
        .top-height {
            margin-top: 22px;
            height: -5px;
        }
        .page-item.active .page-link {
    background-color: #6537AE !important;
    color: #fff !important;
    border: #6537AE;
}   
        </style>
    </head>
    <style>
        .nav-link{
            color: purple;
        }
        .fc-day-grid-event > .fc-content {
       white-space: normal;
   }
              .loader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #6537AE;
  transition: opacity 3s, visibility 0.75s;
  z-index: 999999;
}

.loader--hidden {
  opacity: 0.90;  
  visibility: hidden;
}


@keyframes loading {
  from {
    transform: rotate(0turn);
  }
  to {
    transform: rotate(1turn);
  }
}
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
    </style>
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
    <div class="loader">
<div class="custom-loader flipX-animation"></div>
    <div class="text-center">
        <img src="../../t/images/iconwhite.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
    </div>
</div>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div>
                    <div class="col-lg-12">
                    <div class="mx-3">
                        <form method="post" >
                            <div class="container">
                            <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i></a>
                            <h2 style="color:6537AE;" class="text-center fw-bold">VIEW CLIENT RECORD</h2>
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xl-3 h-100 mb-3">
                                        <div class="bg-white p-5 text-center rounded border shadow-sm" style="height: 90%; padding-bottom: 25px;">
                                            <img src="../../img/avatar/<?php echo $avatar; ?>" alt="Avatar" class="image-fluid" style="width: 155px; height: 155px; border-radius: 50%; margin: 0 auto;"><br>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 mb-3">
                                        <div class="bg-white px-5  h-100 border rounded shadow-sm">
                                            <div class="row mt-3">
                                                <div class="row">
                                                    <label class="mb-2" style="color:#6537AE; font-weight: 700; ">CLIENT INFORMATION</label>
                                                    <hr>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="" style="color:#6537AE; font-weight: 700; ">Full Name </p>
                                                    <p><?php echo ($lname. ", " .$fname. " " .$mname. " " .$sname); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p style="color:#6537AE; font-weight: 700; ">Date of Birth </p>
                                                    <p><?php echo date('F m, Y', strtotime($dob)); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p style="color:#6537AE; font-weight: 700; ">Gender </p>
                                                    <p><?php echo $gender; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                    <label class="mb-3" style="color:#6537AE; font-weight: 700; ">Email</label>
                                                    <p><?php echo $email ?></p>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="mb-3" style="color:#6537AE; font-weight: 700; ">Contact Number</label>
                                                    <p><?php echo $contact ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-12 bg-white px-5 border rounded mb-3 shadow-sm" style="padding: 20px;">
                                <div class="row">
                                    <label class="mb-2" style="color:#6537AE; font-weight: 700; ">ADDRESS</label>
                                    <hr>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <p ><?php echo $houseNumber . " " . $streetName . " " . $barangay . ", " . $city . " " . $province . " " . $postalCode?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">
                                <div class="row">
                                    <label class="mb-2" style="color:#6537AE; font-weight: 700; ">EMERGENCY CONTACT PERSON</label>
                                    <hr>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <label class="mb-3" style="color:#6537AE; font-weight: 700; ">Contact Person</label>
                                        <p><?php echo $econtact ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="mb-3" style="color:#6537AE; font-weight: 700; ">Relation</label>
                                        <p><?php echo $relation ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="mb-3" style="color:#6537AE; font-weight: 700; ">Contact Person Number</label>
                                        <p><?php echo $econtactno ?></p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-12">

                            </div>
                        </form>
                        <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Diagnosis List</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Appointment List</button>
                        </div>
                        </nav>
                        <div class="tab-content bg-white" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div id="diagnosisContainer" class="bg-white p-3 ">
                        
                            <div>
                            <div class="text-dark border rounded p-3 mb-3">
                                <table id="clientTable" class="table table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>History/Physical Examination</th>
                                                <th>History/Physical Examination</th>
                                                <th>Diagnosis</th>
                                                <th>Diagnosis</th>
                                                <th class="text-nowrap">Progress Report</th>
                                                <th>Management</th>
                                                <th>Notes</th>
                                                <th class="text-nowrap">All Information</th>
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
                                                            <td><?php echo date('F d, Y', strtotime($info_row['date_diagnosis']))?></td>
                                                            <td><?php echo $info_row['history']; ?></td>
                                                            <td><?php echo strlen($info_row['history']) > 50 ? substr($info_row['history'], 0, 50) . '...' : $info_row['history']; ?></td>
                                                            <td><?php echo $info_row['diagnosis']; ?></td>
                                                            <td><?php echo strlen($info_row['diagnosis']) > 50 ? substr($info_row['diagnosis'], 0, 50) . '...' : $info_row['diagnosis']; ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                $imagePath = "../../img/progress/{$info_row['image']}";

                                                                if (file_exists($imagePath) && is_file($imagePath)) {
                                                                    $type = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                                    $data = file_get_contents($imagePath);
                                                                    $imgData = base64_encode($data);
                                                                    $src = 'data:image/' . $type . ';base64,' . $imgData;
                                                                    echo "<img class='img-fluid' src='{$src}' alt='' height='100px' width='100px'>";
                                                                } else {
                                                                    $defaultImagePath = "../../img/progress/white.jpg";
                                                                    $defaultType = pathinfo($defaultImagePath, PATHINFO_EXTENSION);
                                                                    $defaultData = file_get_contents($defaultImagePath);
                                                                    $defaultImgData = base64_encode($defaultData);
                                                                    $defaultSrc = 'data:image/' . $defaultType . ';base64,' . $defaultImgData;
                                                                    
                                                                    echo "<img class='img-fluid' src='{$defaultSrc}' alt='' height='100px' width='100px'>";
                                                                }
                                                                
                                                                ?>
                                                            </td>
                                                            <td><?php echo $info_row['management']?></td>
                                                            <td><?php echo strlen($info_row['notes']) > 50 ? substr($info_row['notes'], 0, 50) . '...' : $info_row['notes']; ?></td>
                                                            
                                                            
                                                            <td >
                                                                <div class="d-flex justify-content-center align-item-center">
                                                                    <button type="button" onclick="showData('<?php echo $info_row['id']; ?>')" class="btn btn-purple bg-purple text-white text-center" data-zep-acc="<?php echo $info_row['id']; ?>">View</button>
                                                                    
                                                                    <form method="post" action="">
                                                                        <input type="hidden" name="id" value="<?php echo $info_row['id']; ?>">
                                                                    </form>
                                                                </div>
                                                                <div style="display: flex; gap: 10px;">
                                                                    
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
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Upcoming Appointment</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Past Appoinment</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <table class="table table-bordered my-3" >
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                        </tr>
                                        <?php
                                        
                                        if (isset($_GET['id'])) {
                                            $id = $_GET['id'];
                                            date_default_timezone_set('Asia/Manila');
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
                                                echo "<td>" . date('F d, Y', strtotime($appointmentDate)) . "</td>";
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
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                        </tr>
                                        <?php
                                        if (isset($_GET['id'])) {
                                            $id = $_GET['id'];
                                            date_default_timezone_set('Asia/Manila');
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
                                                echo "<td>" . date('F d, Y', strtotime($appointmentDate)) . "</td>";
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

    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
        var table = $('#clientTable').DataTable({
            order: [[0, 'desc']],
            responsive: true,
            processing: true,
            dom: '<"row text-center"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end"B>>rtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-filetype-pdf fs-4"></i> PDF',
                    className: 'outline',
                    title: 'Z Skin Care Report (<?php echo $fname . " " . $mname . " " . $lname . " " . $sname; ?>)',
                    exportOptions: {
                        columns: [0, 1, 3, 5, 6],
                        stripHtml: true
                    },
                    customize: function(doc) {
                        doc.content[1].table.widths = ['20%', '20%', '20%', '20%', '20%'];
                        doc.content[0] = {
                            text: 'Z Skin Care Report',
                            style: 'title',
                            margin: [0, 0, 0, 5],
                        };
                        var imagePaths = $('.img-fluid').map(function () {
                            return this.src;
                        }).get();
                        for (var i = 0, c = 1; i < imagePaths.length; i++, c++) {
                            doc.content[1].table.body[c][3] = {
                                image: imagePaths[i],
                                width: 100
                            };
                        }
                        doc.styles.title = {
                            color: '#2D1D10',
                            fontSize: '16',
                            alignment: 'center',
                        };
                        doc.content[1].table.headerRows = 1;
                        doc.content[1].table.body[0].forEach(function(cell) {
                            cell.fillColor = '#6537AE';
                            cell.color = '#fff';
                        });
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
logActivityForFileDownload('pdf');
        }
    }
],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: true,
            select: true,
            columnDefs: [
                {
                    target: 1,
                    visible: false,
                    searchable: false
                },
                {
                    target: 3,
                    visible: false,
                    searchable: false
                },
                { "orderable": false, "targets": [1, 2, 4, 5, 6, 7] },
                { "orderable": true, "targets": [0] }
            ],
        });
    });
    function logActivityForFileDownload(fileType) {
    var userData = <?php echo json_encode($_SESSION['id']); ?>;
    var clinicRole = userData['clinic_role'];
    var name = userData['clinic_lastname'];
    var actionDescription = "Downloaded Client Record";
    actionDescription += " (" + fileType.toUpperCase() + ")";

    logActivity(userData['id'], name, clinicRole, actionDescription);
}
function logActivity(userId, name, role, actionDescription) {
    $.ajax({
        url: '../appointment/log_activity.php',
        type: 'POST',
        data: {
            user_id: userId,
            name: name,
            action_type: 'Download Client Record',
            role: role,
            action_description: actionDescription
        },
        success: function (response) {

        },
        error: function (error) {
            console.error("Error logging activity: ", error);
        }
    });
}
    </script>
    <script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: './get_schedule.php?id=<?php echo $id; ?>', // Add the user ID
        eventClick: function(event) {
            Swal.fire({
        title: 'Event Clicked!',
        text: 'The Schedule is Around: ' + event.title,
        icon: 'info',
        confirmButtonText: 'OK'
    });
        }
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
    window.addEventListener("load", () => {
  const loader = document.querySelector(".loader");

  loader.classList.add("loader--hidden");

  loader.addEventListener("transitionend", () => {
    document.body.removeChild(loader);
  });
});
</script>
    </body>
    </html>
