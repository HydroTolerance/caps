<?php 
include "../function.php";
checklogin('Derma');
$userData = $_SESSION['id'];
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>Edit Client Record</title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

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
    #pageloader {
        background: rgba(255, 255, 255, 0.9);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    .custom-loader1 {

        margin: 0 auto;
        margin-top: 35vh;
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
    

    if (isset($_POST['update_diagnosis'])) {
        include "../../db_connect/config.php";
        $id = $_POST['id'];
        $editedHistory = $_POST['edit_history'];
        $editedDiagnosis = $_POST['edit_diagnosis'];
        $editedManagement = $_POST['edit_management'];
        $editednotes = $_POST['edit_notes'];
        $imagePath = '';
    
        if ($_FILES['uploaded_image']['error'] == 0 && $_FILES['uploaded_image']['size'] > 0) {
            $targetDirectory = '../../img/progress/';
            $uniqueFilename = uniqid() . '_' . basename($_FILES['uploaded_image']['name']);
            $targetFile = $targetDirectory . $uniqueFilename;
    
            if (move_uploaded_file($_FILES['uploaded_image']['tmp_name'], $targetFile)) {
                $oldImagePathQuery = "SELECT image FROM zp_derma_record WHERE id=?";
                $oldImagePathStmt = mysqli_prepare($conn, $oldImagePathQuery);
                mysqli_stmt_bind_param($oldImagePathStmt, "i", $id);
                mysqli_stmt_execute($oldImagePathStmt);
                mysqli_stmt_bind_result($oldImagePathStmt, $oldImagePath);
                mysqli_stmt_fetch($oldImagePathStmt);
                mysqli_stmt_close($oldImagePathStmt);
    
                if (!empty($oldImagePath) && $oldImagePath !== "../../img/progress/white.jpg") {
                    unlink($oldImagePath);
                }
    
                // Update the new image path in the database
                $imagePath = $targetFile;
            } else {
                echo "Error uploading image.";
                exit;
            }
        } else {
            // No new image uploaded, retain the existing image path
            $existingImagePathQuery = "SELECT image FROM zp_derma_record WHERE id=?";
            $existingImagePathStmt = mysqli_prepare($conn, $existingImagePathQuery);
            mysqli_stmt_bind_param($existingImagePathStmt, "i", $id);
            mysqli_stmt_execute($existingImagePathStmt);
            mysqli_stmt_bind_result($existingImagePathStmt, $existingImagePath);
            mysqli_stmt_fetch($existingImagePathStmt);
            mysqli_stmt_close($existingImagePathStmt);
    
            // Retain the existing image path
            $imagePath = $existingImagePath;
        }
    
        // Update SQL
        $update_sql = "UPDATE zp_derma_record SET history=?, diagnosis=?, management=?, notes=?, image=? WHERE id=?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "sssssi", $editedHistory, $editedDiagnosis, $editedManagement, $editednotes, $imagePath, $id);
    
        if ($update_stmt->execute()) {
            echo "<script>
                window.addEventListener('DOMContentLoaded', (event) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Client Diagnosis Updated Successfully.'
                    });
                });
            </script>";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    
        mysqli_stmt_close($update_stmt);
        mysqli_close($conn);
    }
    

    
    
    ?>
    <?php
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    logActivity($conn, $userData['id'], $userData['clinic_lastname'], 'Add Client Diagnosis', $userData['clinic_role'], 'Add Client Diagnosis');
    echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Client Diagnosis Added successfully.'
                }).then(function() {
                    window.location.href = 'edit_client_record.php?id=" . $id . "';
                });
          </script>";
          exit();
}
if (isset($_GET['insert']) && $_GET['insert'] === 'true') {
    logActivity($conn, $userData['id'], $userData['clinic_lastname'], 'Add Client Appointment', $userData['clinic_role'], 'Add Client Appointment for next session');
    echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Client Appointment Added Successfully.'
                }).then(function() {
                    window.location.href = 'edit_client_record.php?id=" . $id . "';
                });
          </script>";
          exit();
}
// Check for error parameter
if (isset($_GET['error']) && $_GET['error'] === 'true') {

    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Client Diagnosis Added successfully.'
            }).then(function() {
                window.location.href = 'edit_client_record.php?id=" . $id . "';
            });
          </script>";
          exit();
}
function logActivity($conn, $userId, $name, $actionType, $role, $actionDescription) {
    include "../../db_connect/config.php";
    $timezone = new DateTimeZone('Asia/Manila');
    $dateTime = new DateTime('now', $timezone);
    $timestamp = $dateTime->format('Y-m-d H:i:s');
    $sql = "INSERT INTO activity_log (user_id, name, action_type, role, action_description, timestamp) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isssss', $userId, $name, $actionType, $role, $actionDescription, $timestamp);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
}
}
?>
<!-- The rest of your HTML content goes here -->
<div class="loader">
<div class="custom-loader flipX-animation"></div>
    <div class="text-center">
        <img src="../../t/images/iconwhite.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
    </div>
</div>
<div id="pageloader">
    <div class="custom-loader1 flipX-animation"></div>
    <div class="text-center">
        <img src="../../t/images/6.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
    </div>
    <h4 class="text-center" style="font-family: Lora;"> Please Wait</h4>
</div>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div>
                    <div class="col-lg-12">
                    <div class="mx-3">
                    <form method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="container">
                            <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i></a>
                            <h2 style="color:6537AE;" class="text-center fw-bold">EDIT CLIENT RECORD</h2>
                                <div class="row mb-3">
                                    <input class="form-label" type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="bg-white mb-4 p-5 text-center rounded border" style="height: 90%; padding-bottom: 25px;">
                                            <img src="../../img/avatar/<?php echo $avatar; ?>" alt="Avatar" style="width: 155px; height: 155px; border-radius: 50%; margin: 0 auto;"><br>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-12 mb-4">
                                        <div class="bg-white px-5 py-3 border rounded">
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
                                                    <p><?php echo date('F d, Y', strtotime($dob)); ?></p>
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
                                <div class="col-md-12 bg-white px-5 border rounded mb-3" style="padding: 20px;">
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
                        <div class="pt-3">
                        <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Diagnosis List</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Appointment List</button>
                        </div>
                        </nav>
                        
                        <div class="bg-white mb-4">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                
                            <div id="diagnosisContainer" class="bg-white p-3">
                                <div class="bg-white py-3 mb-3 border border-bottom">
                                    <div class="d-flex justify-content-between mx-4">
                                        <div>
                                            <h2 style="color:6537AE;" class="fw-bold">CLIENT DIAGNOSIS</h2>
                                        </div>
                                        <div class="align-items-center">
                                        <?php
                                            include "../../db_connect/config.php";
                                            $id = $_GET['id'];
                                            $stmt = mysqli_prepare($conn, "SELECT * FROM zp_client_record WHERE id=?");
                                            mysqli_stmt_bind_param($stmt, "i", $id);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            if (mysqli_num_rows($result) > 0) {
                                                $info_row = mysqli_fetch_assoc($result);
                                                ?>
                                                <a class="btn bg-purple text-white" onclick="addDiagnosisModal('<?php echo $info_row['id']; ?>')">CREATE</a>
                                                <form method="post" action="">
                                                    <input type="hidden" name="id" value="<?php echo $info_row['id']; ?>">
                                                </form>
                                                <?php
                                            } else {
                                                echo "Record not found";
                                            }
                                            mysqli_stmt_close($stmt);
                                            mysqli_close($conn);
                                        ?>

                                        </div>
                                    </div>
                                </div>
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
                                                <th class="text-nowrap">Action</th>
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
                                                            <td class="text-nowrap"><?php echo date('F d, Y', strtotime($info_row['date_diagnosis']))?></td>
                                                            <td><?php echo $info_row['history']; ?></td>
                                                            <td><?php echo strlen($info_row['history']) > 50 ? substr($info_row['history'], 0, 50) . '...' : $info_row['history']; ?></td>
                                                            <td><?php echo $info_row['diagnosis']; ?></td>
                                                            <td><?php echo strlen($info_row['diagnosis']) > 50 ? substr($info_row['diagnosis'], 0, 50) . '...' : $info_row['diagnosis']; ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                    $imagePath = "../../img/progress/{$info_row['image']}";
                                                                    if (file_exists($imagePath) && is_file($imagePath)) {
                                                                        echo "<img class='img-fluid' src='{$imagePath}' alt='' height='100px' width='100px'>";
                                                                    } else {
                                                                        $defaultImagePath = "../../img/progress/white.jpg";
                                                                        echo "<img class='img-fluid' src='{$defaultImagePath}' alt='' height='100px' width='100px'>";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $info_row['management']?></td>
                                                            <td><?php echo strlen($info_row['notes']) > 50 ? substr($info_row['notes'], 0, 50) . '...' : $info_row['notes']; ?></td>
                                                            
                                                            
                                                            <td>
                                                                <div style="display: flex; gap: 10px;">
                                                                    <button type="button" onclick="showData('<?php echo $info_row['id']; ?>')" class="btn btn-purple bg-purple text-white" data-zep-acc="<?php echo $info_row['id']; ?>">Edit</button>
                                                                    <button type="button" onclick="showDiagnosis('<?php echo $info_row['id']; ?>')" class="btn btn-purple bg-purple text-white" data-zep-acc="<?php echo $info_row['id']; ?>">View</button>
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
                            
                            <div>
                            
                        </div>
                        </div>
                        </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="rounded p-3 bg-white">
                                    <div class="text-dark border p-3 mb-3">
                                    <div class="d-flex justify-content-between mx-2">
                                        <div>
                                            <h2 style="color:6537AE;" class="fw-bold">CLIENT APPOINTMENT</h2>
                                        </div>
                                        <div class="align-items-center">
                                        <?php
                                            include "../../db_connect/config.php";
                                            $id = $_GET['id'];
                                            $stmt = mysqli_prepare($conn, "SELECT * FROM zp_client_record WHERE id=?");
                                            mysqli_stmt_bind_param($stmt, "i", $id);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            if (mysqli_num_rows($result) > 0) {
                                                $info_row = mysqli_fetch_assoc($result); // Fetch the data
                                                ?>
                                                <a class="btn bg-purple text-white" onclick="addAppointmentModal('<?php echo $info_row['id']; ?>')">CREATE</a>
                                                <form method="post" action="">
                                                    <input type="hidden" name="id" value="<?php echo $info_row['id']; ?>">
                                                </form>
                                                <?php
                                            } else {
                                                echo "Record not found";
                                            }
                                            mysqli_stmt_close($stmt);
                                            mysqli_close($conn);
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            <div class="text-dark border rounded p-3 mb-3">
                                <div class="d-flex justify-content-center">
                                    <div id="calendar"></div>
                                </div>
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
                                            $currentDate = date("Y-m-d");
                                            $upcomingAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = '$id' AND date >= '$currentDate'";
                                            $upcomingAppointmentsResult = mysqli_query($conn, $upcomingAppointmentsQuery);
                                            while ($appointmentRow = mysqli_fetch_assoc($upcomingAppointmentsResult)) {
                                                $appointmentDate = $appointmentRow['date'];
                                                $appointmentTime = $appointmentRow['time'];
                                                $appointmentService = $appointmentRow['services'];
                                                echo "<tr>";
                                                $appointmentDate = date("F j, Y", strtotime($appointmentRow['date']));
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
                                            $currentDate = date("Y-m-d");
                                            $pastAppointmentsQuery = "SELECT * FROM zp_appointment WHERE client_id = '$id' AND date < '$currentDate'";
                                            $pastAppointmentsResult = mysqli_query($conn, $pastAppointmentsQuery);
                                            while ($appointmentRow = mysqli_fetch_assoc($pastAppointmentsResult)) {
                                                $appointmentDate = $appointmentRow['date'];
                                                $appointmentTime = $appointmentRow['time'];
                                                $appointmentService = $appointmentRow['services'];
                                                echo "<tr>";
                                                $appointmentDate = date("F j, Y", strtotime($appointmentRow['date']));
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:6537AE" id="dataModalLabel">EDIT DIAGNOSIS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="displaydata" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:6537AE" id="dataModalLabel">FULL DATA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Popper.js -->
    <div class="modal fade" id="insertDiagnosis" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:6537AE" id="insertModalLabel">CREATE DIAGNOSIS</h5>
                    <div class="modal-footer">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="insertAppointment" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:6537AE" id="insertModalLabel">CREATE APPOINTMENT</h5>
                    <div class="modal-footer">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/record.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
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
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: './get_schedule.php?id=<?php echo $id; ?>',
        eventClick: function(event) {
            Swal.fire({
                title: 'Event Clicked!',
                html: '<p>Service:</p>' +
                      '<p>' + event.title + '</p>' +
                      '<p>Time:</p>' +
                      '<p>' + event.time + '</p>',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    });
});

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
    console.log(id);
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
function showDiagnosis(id) {
    console.log(id);
$.ajax({
    
    url: 'get_diagnosis.php',
    type: 'POST',
    data: { id: id },
    success: function (response) {
        $('#displaydata .modal-body').html(response);
        $('#displaydata').modal('show');
    }
})
}
function addDiagnosisModal(id) {
    console.log(id); 
    $.ajax({
        url: 'create_diagnosis.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
            $('#insertDiagnosis .modal-body').html(response);
            $('#insertDiagnosis').modal('show');
        }
    });
}
function addAppointmentModal(id) {
    console.log(id);
    $.ajax({
        url: 'create_appointment.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
            $('#insertAppointment .modal-body').html(response);
            $('#insertAppointment').modal('show');
        }
    });
}
</script>
<script>
    $(document).ready(function() {
    var table = $('#clientTable').DataTable({
        order: [[0, 'desc']],
        responsive: true,
        dom: '<"row  text-end"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end">>rtip',
        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        select: true,
        "columnDefs": [
            {"targets": [1],"visible": false, "searchable": false},
            {"targets": [3],"visible": false, "searchable": false},
            { "orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7] },
        { "orderable": true, "targets": [0] }
    ],
    });
})
</script>
<script>
    $(document).ready(function(){
        $('.select2').select2({
        placeholder: {
            id: '',
            text: 'None Selected'
        },
        theme: 'bootstrap-5',
    });
    })

</script>
<script>
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