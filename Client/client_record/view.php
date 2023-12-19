
<?php
include "../function.php";
checklogin('Client');

if (!isset($_SESSION['client_email'])) {
    header("Location: login.php");
    exit();
}

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
<?php
date_default_timezone_set('Asia/Manila');
include "../../db_connect/config.php";

$currentDate = date("Y-m-d");
$upcomingAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = ? AND date = ?";
$stmt = mysqli_prepare($conn, $upcomingAppointmentsQuery);
mysqli_stmt_bind_param($stmt, "is", $userData['id'], $currentDate);
mysqli_stmt_execute($stmt);
$upcomingAppointmentsResult = mysqli_stmt_get_result($stmt);

$appointmentsToday = [];

while ($appointmentRow = mysqli_fetch_assoc($upcomingAppointmentsResult)) {
    $appointmentsToday[] = [
        'date' => date("F j, Y", strtotime($appointmentRow['date'])),
        'time' => $appointmentRow['time'],
        'service' => $appointmentRow['services']
    ];
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>Client Profile</title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                .status-cancelled {
            background-color: #DC4C64 !important;
            padding: 5px 10px;
            color: white;
            border-radius: 20px;
            margin-top: 2px;
}

    .status-approved {
        background-color: green !important;
        padding: 5px 10px;
        color: white;
        border-radius: 20px;
        margin-top: 2px;
    }

    .status-rescheduled-\(admin\){
    background: linear-gradient(to right, #3B71CA 50%, #6537AE 50%) !important;
    padding: 5px 10px;
    color: white;
    border-radius: 20px;
    margin-top: 2px;
}
.status-rescheduled-\(derma\){
    background: linear-gradient(to right, #3B71CA 50%, #6537AE 50%) !important;
    padding: 5px 10px;
    color: white;
    border-radius: 20px;
    margin-top: 2px;
}
.status-rescheduled-\(client\){
    background-color: #3B71CA !important;
    padding: 5px 10px;
    color: white;
    border-radius: 20px;
    margin-top: 2px;
}

    .status-completed {
        background-color: #14A44D !important;
        padding: 5px 10px;
        color: white;
        border-radius: 20px;
        margin-top: 2px;
    }
    .status-did-not-show {
        background-color: #FA9C1B !important;
        padding: 5px 10px;
        color: white;
        border-radius: 20px;
        margin-top: 2px;
    }
    .status-acknowledged {
        background-color: #6537AE !important;
        padding: 5px 10px;
        color: white;
        border-radius: 20px;
    }
    .status-pending {
        background-color: #9FA6B2 !important;
        padding: 5px 10px;
        color: white;
        border-radius: 20px;
    }
        .nav-link{
            color: purple;
        }
        div.dataTables_wrapper div.dataTables_filter input {
            width: 70%;
        }
                .fc-scroller {
  height: auto !important;
}
.fc-day-grid-event > .fc-content {
       white-space: normal;
   }
   .top-height {
            margin-top: 23px;
            height: -5px;
        }
        .page-item.active .page-link {
    background-color: #6537AE !important;
    color: #fff !important;
    border: #6537AE;
}
th{
        background-color:#6537AE  !important;
        color: #fff  !important;
        text-align: center !important;
        }
        td {
            text-align: center !important;
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
    .custom-toggler.navbar-toggler {
    border-color: #fff;
}
.custom-toggler .navbar-toggler-icon {
    background-image: url(
"data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}

    </style>
    <body style="background-color: #E4E9F7;">
        
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
<?php if (!empty($appointmentsToday)) : ?>
    <script>
        // Wait for the DOM to be ready
        document.addEventListener('DOMContentLoaded', function () {
            <?php foreach ($appointmentsToday as $index => $appointment) : ?>
                var toast<?php echo $index; ?> = new bootstrap.Toast(document.querySelector('.toast-<?php echo $index; ?>'));
                toast<?php echo $index; ?>.show();
            <?php endforeach; ?>
        });
    </script>
<?php endif; ?>

<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-absolute top-0 end-0 p-3">
        <?php foreach ($appointmentsToday as $index => $appointment) : ?>
            <div class="toast toast-<?php echo $index; ?>" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                <div class="toast-header">
                    <div class="rounded me-2"></div>
                    <strong class="me-auto fw-bold">NOTIFICATION</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-light">
                <strong>You have an appointment today!</strong>
                    <div class="mt-2 pt-2 border-top">
                        <p>Date: <?php echo $appointment['date']; ?></p>
                        <p>Time: <?php echo $appointment['time']; ?></p>
                        <p>Service: <?php echo $appointment['service']; ?></p>
                        <!-- Add buttons or actions as needed -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div>
                    <div class="col-lg-12 my-3">
                    <h2 style="color:6537AE;" class="text-center fw-bold">CLIENT PROFILE</h2>
                    <div>
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body">
                            Hello, world! This is a toast message.
                            <div class="mt-2 pt-2 border-top">
                            <button type="button" class="btn btn-primary btn-sm">Take action</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
                            </div>
                        </div>
                    </div>
                        <form method="post" >
                            <div class="container">
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $userData['id']; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xl-3 h-100 mb-3">
                                        <div class="bg-white p-5 text-center rounded border shadow-sm" style="height: 90%; padding-bottom: 25px;">
                                        <img src="../../img/avatar/<?php echo $userData['client_avatar']; ?>" alt="Avatar" style="width: 155px; height: 155px; border-radius: 50%; margin: 0 auto;"><br>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 mb-3">
                                        <div class="bg-white px-5  h-100 border rounded shadow-sm">
                                            <div class="row mt-3">
                                                <div class="row">
                                                    <label class="mb-2" style="color:#6537AE; font-weight: 700; ">CLIENT INFORMATION</label>
                                                    <hr>
                                                </div>
                                                <div class="col-md-5">
                                                    <p class="" style="color:#6537AE; font-weight: 700; ">Full Name </p>
                                                    <p><?php echo ($lname. ", " .$fname. " " .$mname. " " .$sname); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p style="color:#6537AE; font-weight: 700; ">Date of Birth </p>
                                                    <p><?php echo date('F d, Y', strtotime($dob)); ?></p>
                                                </div>
                                                <div class="col-md-3">
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
                        </form>
                        
                        
                        <section>
                            <div class="bg-white rounded">
                            <h2 class="text-center pt-5 fw-bold" style="color: 6537AE;">TRANSACTION HISTORY</h2>
                            <nav class="nowrap">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Services List</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Appointment List</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div id="diagnosisContainer" class="bg-white p-3 rounded-3 shadow-sm">
                        
                            <div>
                            <div class="text-dark border rounded p-3 mb-3">
                                <div class="row">
                                <div class="col-md-4">
                                    <label for="yearFilter">Filter Date</label>
                                    <div id="reportrange" class="form-control form-control-sm">
                                        <i class="bi bi-calendar"></i>&nbsp;
                                        <span class="text-secondary" style="font-size: 14px;"> Start Date - End Date</span> <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="yearFilter">Filter by Services</label>
                                    <select id="yearFilter1" class="form-select form-select-sm select2" multiple="multiple">
                                        <option value="">All Services</option>
                                            <?php
                                            include "../../db_connect/config.php";
                                            $stmt = mysqli_prepare($conn, "SELECT DISTINCT services FROM service");
                                            mysqli_stmt_execute($stmt);
                                            mysqli_stmt_store_result($stmt);
                                            mysqli_stmt_bind_result($stmt, $category);

                                            while (mysqli_stmt_fetch($stmt)) {
                                                echo '<optgroup label="' . $category . '">';
                                                $stmt2 = mysqli_prepare($conn, "SELECT id, services, name, image, description FROM service WHERE services = ?");
                                                mysqli_stmt_bind_param($stmt2, "s", $category);
                                                mysqli_stmt_execute($stmt2);
                                                mysqli_stmt_store_result($stmt2);
                                                mysqli_stmt_bind_result($stmt2, $id, $services, $name, $image, $description);

                                                while (mysqli_stmt_fetch($stmt2)) {
                                                    echo '<option value="' . $name . '">' . $name . '</option>';
                                                }
                                                echo '</optgroup>';
                                            }
                                            ?>
                                    </select>
                                </div>
                                                                    
                                </div>
                                    <table id="clientTable" class="table table table-bordered table-striped nowrap" style="width:100%">
                                        <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Progress Report</th>
                                                        <th>Services</th>
                                                        <th>Notes</th>
                                                        <th>Notes</th>
                                                        <th>Action</th>
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
                                                            <td><?php echo date('F d, Y', strtotime($info_row['date_diagnosis']))?></td>
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
                                                            <td><?php echo $info_row['notes']?></td>
                                                            <td><?php echo strlen($info_row['notes']) > 60 ? substr($info_row['notes'], 0, 60) . '...' : $info_row['notes']; ?></td>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered my-3 w-100" id="diagnosisTable">
                                    <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        date_default_timezone_set('Asia/Manila');
                                        include "../../db_connect/config.php";

                                        // Fetch upcoming appointments (assuming the date is in the future)
                                        $currentDate = date("Y-m-d");
                                        $pastAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = ? AND date >= ?";
                                        $stmt = mysqli_prepare($conn, $pastAppointmentsQuery);
                                        mysqli_stmt_bind_param($stmt, "is", $userData['id'], $currentDate);
                                        mysqli_stmt_execute($stmt);
                                        $pastAppointmentsResult = mysqli_stmt_get_result($stmt);
                                        while ($appointmentRow = mysqli_fetch_assoc($pastAppointmentsResult)) {
                                            $appointmentReference = $appointmentRow['reference_code'];
                                            $appointmentDate = date("F j, Y", strtotime($appointmentRow['date']));
                                            $appointmentTime = $appointmentRow['time'];
                                            $appointmentService = $appointmentRow['services'];
                                            $appointmentStatus = $appointmentRow['appointment_status'];
                                            echo "<tr>";
                                            echo "<td>$appointmentReference</td>";
                                            echo "<td>$appointmentDate</td>";
                                            echo "<td>$appointmentTime</td>";
                                            echo "<td>$appointmentService</td>";
                                            echo "<td>
                                                    <span id='status_" . $userData['id'] . "' class='status-" . strtolower(str_replace(' ', '-', $appointmentStatus)) . " d-flex justify-content-center align-item-center'>" . $appointmentStatus . "</span>
                                                </td>";
                                            echo "<td><a href='http://localhost/caps/t/reschedule.php?reference_code=$appointmentReference' class='btn btn-primary'>Resched/Cancell</a></td>";
                                            echo "</tr>";
                                        }
                                        mysqli_stmt_close($stmt);
                                        ?>
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="table-responsive">
                                <table class="table table-bordered my-3 w-100" id="appointmentTable">
                                    <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        date_default_timezone_set('Asia/Manila');
                                        include "../../db_connect/config.php";

                                        // Fetch upcoming appointments (assuming the date is in the future)
                                        $currentDate = date("Y-m-d");
                                        $pastAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = ? AND date < ?";
                                        $stmt = mysqli_prepare($conn, $pastAppointmentsQuery);
                                        mysqli_stmt_bind_param($stmt, "is", $userData['id'], $currentDate);
                                        mysqli_stmt_execute($stmt);
                                        $pastAppointmentsResult = mysqli_stmt_get_result($stmt);
                                        while ($appointmentRow = mysqli_fetch_assoc($pastAppointmentsResult)) {
                                            $appointmentReference = $appointmentRow['reference_code'];
                                            $appointmentDate = date("F j, Y", strtotime($appointmentRow['date']));
                                            $appointmentTime = $appointmentRow['time'];
                                            $appointmentService = $appointmentRow['services'];
                                            $appointmentStatus = $appointmentRow['appointment_status'];
                                            echo "<tr>";
                                            echo "<td>$appointmentReference</td>";
                                            echo "<td>$appointmentDate</td>";
                                            echo "<td>$appointmentTime</td>";
                                            echo "<td>$appointmentService</td>";
                                            echo "<td>
                                                    <span id='status_" . $userData['id'] . "' class='status-" . strtolower(str_replace(' ', '-', $appointmentStatus)) . " d-flex justify-content-center align-item-center'>" . $appointmentStatus . "</span>
                                                </td>";
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
                        </div>
                        </section>
                        
                        
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="displayAccount" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
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
    <script src="js/record.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
$(document).ready(function () {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month'
        },
        events: './get_schedule.php?id=<?php echo $userData['id']; ?>',

        eventClick: function(event) {
            Swal.fire({
        title: 'Event Clicked!',
        text: 'The Schedule is Around: ' + event.title,
        icon: 'info',
        confirmButtonText: 'OK'
    });
        },
    });

        var dataTable = $('#clientTable').DataTable({
        order: [[0, 'desc']],
        responsive: true,
        dom: '<"row text-center"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end"B>>rtip',
     "columnDefs": [
            { target: 3, visible: false, searchable: false },
            { "orderable": false, "targets": [1,2,3,4] }
        ],
        buttons: [
            {
                "className": 'outline',
                extend: 'pdfHtml5',
                text: '<i class="bi bi-filetype-pdf fs-4"></i> Export PDF',
                title: 'Client Transaction (<?php echo $fname . " " . $mname . " " . $lname . " " . $sname; ?>)',
                exportOptions: {
                        columns: [0, 1, 2, 4],
                    },
                customize: function(doc) {
                    doc.content[1].table.widths = ['25%', '25%', '25%', '25%'];
                    doc.content[0] = {
                text: 'Client Transaction',
                style: 'title',
                margin: [0, 0, 0, 5],
            };
            var imagePaths = $('.img-fluid').map(function () {
                            return this.src;
                        }).get();
                        for (var i = 0, c = 1; i < imagePaths.length; i++, c++) {
                            doc.content[1].table.body[c][2] = {
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
            for (var row = 0; row < doc.content[1].table.body.length; row++) {
                var rowData = doc.content[1].table.body[row];
                for (var col = 0; col < rowData.length; col++) {
                    var cell = rowData[col];
                    cell.border = [0, 0, 0, 1];
                    cell.alignment = 'center'; 
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
    ],
    
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
        initComplete: function () {
        var dateRangePicker = $('#reportrange');
        dateRangePicker.daterangepicker({
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function (start, end) {
            minDateFilter = start.format('MMMM D, YYYY');
            maxDateFilter = end.format('MMMM D, YYYY');
            dataTable.draw();
            dateRangePicker.find('span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });
    },
    
});
            
var minDateFilter = null;
var maxDateFilter = null;
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var min = minDateFilter ? moment(minDateFilter) : null;
    var max = maxDateFilter ? moment(maxDateFilter) : null;
    var date = moment(data[0], 'MMMM D, YYYY');
    if ((min === null || date.isSameOrAfter(min)) && (max === null || date.isSameOrBefore(max))) {
        return true;
    }
    return false;
});
var statusFilter = $('#yearFilter1');

// Apply the status filter on change
$('#yearFilter1').on('change', function () {
            var selectedStatus = $(this).val();
            dataTable.column(2).search(selectedStatus.join('|'), true, false).draw();
        });
$('#reportrange').on('apply.daterangepicker', function () {
        dataTable.draw();
    });

    var diagnosisTable = $('#diagnosisTable').DataTable({
        dom: '<"row text-center"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end">>rtip',
        "columnDefs": [
        { "orderable": false, "targets": [4, 3] }
    ],
    });


diagnosisTable.columns.adjust();
var appointmentTable = $('#appointmentTable').DataTable({
    dom: '<"row text-center"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end">>rtip',
    "columnDefs": [
        { "orderable": false, "targets": [4, 3] }
    ],
});


appointmentTable.columns.adjust();
})
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
        $(document).ready(function(){
        $('.select2').select2({
        placeholder: {
            id: '',
            text: 'Select Status'
        },
        theme: 'bootstrap-5',
    });
    })

</script>
    </body>
    </html>
