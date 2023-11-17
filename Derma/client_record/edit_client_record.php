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

    if (isset($_POST['add_diagnosis'])) {
        include "../../db_connect/config.php";
    
        $id = $_POST['id'];
        $diagnosis = $_POST['diagnosis'];
        $history = $_POST['history'];
    
        $date_diagnosis = date_default_timezone_set('Asia/Manila');
        $date_diagnosis = date("Y-m-d");
    
        $management = $_POST['management'];
        $notes = $_POST['notes'];
    
        if ($_FILES['image']['size'] > 0) {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $timestamp = time();
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $unique_image_name = $timestamp . '_' . uniqid() . '.' . $image_extension;
            move_uploaded_file($image_tmp, "../../img/progress/" . $unique_image_name);
        } else {
            $unique_image_name = "";
        }
    
        $info_sql = "INSERT INTO zp_derma_record (patient_id, date_diagnosis, history, management, diagnosis, notes, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $info_stmt = mysqli_prepare($conn, $info_sql);
        mysqli_stmt_bind_param($info_stmt, "issssss", $id, $date_diagnosis, $history, $management,  $diagnosis, $notes, $unique_image_name);
    
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
        $date = $_POST['date'];
        $time = $_POST['time'];
        $services = $_POST['services'];

        $reference = generateReferenceCode();
        $currentTimestamp = date("Y-m-d H:i:s");

        $name_sql = "SELECT client_firstname, client_lastname, client_email FROM zp_client_record WHERE id=?";
        $name_stmt = mysqli_prepare($conn, $name_sql);
        mysqli_stmt_bind_param($name_stmt, "i", $id);
        mysqli_stmt_execute($name_stmt);
        $name_result = mysqli_stmt_get_result($name_stmt);
    
        if ($name_row = mysqli_fetch_assoc($name_result)) {
            $fname = $name_row['client_firstname'];
            $lname = $name_row['client_lastname'];
            $email = $name_row['client_email'];

            $info_sql = "INSERT INTO zp_appointment (client_id, firstname, reference_code, lastname, email, date, time, services, appointment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?,'Pending')";
            $info_stmt = mysqli_prepare($conn, $info_sql);
            mysqli_stmt_bind_param($info_stmt, "isssssss", $id, $fname, $reference, $lname, $email, $date, $time, $services);
    
            if (mysqli_stmt_execute($info_stmt)) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Diagnosis is Added successfully.'
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
        

    if (isset($_POST['update_diagnosis'])) {
        include "../../db_connect/config.php";
        $id = $_POST['id'];
        $editedHistory = $_POST['edit_history'];
        $editedDiagnosis = $_POST['edit_diagnosis'];
        $editedManagement = $_POST['edit_management'];
        $editednotes = $_POST['edit_notes'];
        $imagePath = '';
    
        // Check if a new image file is selected
        if ($_FILES['uploaded_image']['error'] == 0 && $_FILES['uploaded_image']['size'] > 0) {
            $targetDirectory = '../../img/progress/';
            $uniqueFilename = uniqid() . '_' . basename($_FILES['uploaded_image']['name']);
            $targetFile = $targetDirectory . $uniqueFilename;
    
            if (move_uploaded_file($_FILES['uploaded_image']['tmp_name'], $targetFile)) {
                // Unlink (delete) the old image, except for the exception
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
                        text: 'Data Updated successfully.'
                    });
                });
            </script>";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    
        mysqli_stmt_close($update_stmt);
        mysqli_close($conn);
    }

if (isset($_POST['archive'])) {
    $id = $_POST['id'];
    include "../../db_connect/config.php";
    $archive_sql = "UPDATE zp_derma_record SET archive = 1 WHERE id = ?";
    $archive_stmt = mysqli_prepare($conn, $archive_sql);
    mysqli_stmt_bind_param($archive_stmt, "i", $id);

    if ($archive_stmt->execute()) {
        echo "Record archived successfully";
    } else {
        echo "Error archiving record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($archive_stmt);
    mysqli_close($conn);
}


function generateServiceDropdown($conn)
    {
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
}

    
    function generateReferenceCode() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $reference = '';
        $length = 6;
    
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $reference .= $characters[$randomIndex];
        }
    
        return $reference;
    }
    
    
    ?>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="mx-3">
                    <form method="post" >
                            <div class="container">
                            <a class="btn btn-secondary" href="client_record.php"><i class="bi bi-arrow-left"></i></a>
                            <h2 style="color:6537AE;" class="text-center fw-bold">EDIT CLIENT RECORD</h2>
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
                                        <div class="bg-white px-5 py-3 border rounded">
                                            <div class="row mb-3">
                                                <div class="row">
                                                    <strong><label class="mb-2">CLIENT INFORMATION:</label></strong>
                                                    <hr>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><p>Full Name: </p></strong>
                                                    <p><?php echo ($lname. ", " .$fname. " " .$mname. " " .$sname); ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><label class="mb-3">Email:</label></strong>
                                                    <p><?php echo $email ?></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <strong><label class="mb-3">Contact Number:</label></strong>
                                                    <p><?php echo $contact ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <strong><p>Gender: </p></strong>
                                                    <p><?php echo $gender; ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong><p>Date of Birth: </p></strong>
                                                    <p><?php echo date('F m, Y', strtotime($dob)); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white px-5 border rounded mb-3" style="padding: 20px;">
                                <div class="row">
                                    <strong><label class="mb-2">ADDRESS</label></strong>
                                    <hr>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <p><?php echo $houseNumber . " " . $streetName . " " . $barangay . ", " . $city . " " . $province . " " . $postalCode?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">
                                <div class="row">
                                    <strong><label class="mb-2">EMERGENCY CONTACT PERSON</label></strong>
                                    <hr>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <strong><label class="mb-3">Contact Person</label></strong>
                                        <p><?php echo $econtact ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong><label class="mb-3">Relation</label></strong>
                                        <p><?php echo $relation ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label class="mb-3">Contact Person Number</label></strong>
                                        <p><?php echo $econtactno ?></p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-12">

                            </div>
                        </form>
                        <div class="bg-white pt-4">
                            <h2 class="text-center">DIAGNOSIS OF THE PATIENT</h2>
                        <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">List Diagnosis</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Create Diagnosis</button>
                        </div>
                        </nav>
                        
                        <div class="bg-white mb-4">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                
                            <div id="diagnosisContainer" class="bg-white p-3">
                            <table id="clientTable" class="table table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>History</th>
                                                <th>Diagnosis</th>
                                                <th>Diagnosis</th>
                                                <th>Progress Report</th>
                                                <th>Management</th>
                                                <th>Notes</th>
                                                <th>All Information</th>
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
                                                            <td><?php echo strlen($info_row['history']) > 50 ? substr($info_row['history'], 0, 50) . '...' : $info_row['history']; ?></td>
                                                            <td><?php echo strlen($info_row['diagnosis']) > 50 ? substr($info_row['diagnosis'], 0, 50) . '...' : $info_row['diagnosis']; ?></td>
                                                            <td><?php echo strlen($info_row['diagnosis']) > 50 ? substr($info_row['diagnosis'], 0, 50) . '...' : $info_row['diagnosis']; ?></td>
                                                            <td>
                                                                <?php
                                                                $imagePath = "../../img/progress/{$info_row['image']}";

                                                                if (file_exists($imagePath) && is_file($imagePath)) {
                                                                    $type = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                                    $data = file_get_contents($imagePath);
                                                                    $imgData = base64_encode($data);
                                                                    $src = 'data:image/' . $type . ';base64,' . $imgData;
                                                                    echo "<img class='img-fluid' src='{$src}' alt='' height='200px' width='200px'>";
                                                                } else {
                                                                    $defaultImagePath = "../../img/progress/white.jpg";
                                                                    $defaultType = pathinfo($defaultImagePath, PATHINFO_EXTENSION);
                                                                    $defaultData = file_get_contents($defaultImagePath);
                                                                    $defaultImgData = base64_encode($defaultData);
                                                                    $defaultSrc = 'data:image/' . $defaultType . ';base64,' . $defaultImgData;
                                                                    
                                                                    echo "<img class='img-fluid' src='{$defaultSrc}' alt='' height='200px' width='200px'>";
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
                                    <div class="text-dark border rounded p-3 mb-3">
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                                            <div class="mb-3">
                                                <label class="form-label">Insert Progress</label>
                                                <input type="file" name="image" id="image" class="form-control" accept="image/jpeg, image/jpg, image/png">
                                            </div>

                                            <div class="mb-3" id="history_div">
                                                <label class="form-label">History of the Patient</label>
                                                <textarea class="form-control" name="history" id="summernote" rows="4"></textarea>
                                            </div>

                                            <div class="mb-3" id="diagnosis_div">
                                                <label class="form-label">Diagnosis of the Patient <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="diagnosis" id="summernote" rows="4" required></textarea>
                                            </div>

                                            <div class="mb-3" id="management_div">
                                                <label class="form-label">Management <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="management" style="width: 100%;" required>
                                                    <option value=""></option>
                                                    <?php generateServiceDropdown($conn); ?>
                                                </select>
                                            </div>

                                            <div class="mb-3" id="session_notes_div">
                                                <label class="form-label">Session Notes <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="notes" rows="4" required></textarea>
                                            </div>

                                            <div class="mb-3 mt-md-3 text-end">
                                                <input class="btn bg-purple text-white" type="submit" name="add_diagnosis" value="Add Diagnosis">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            </div>
                            
                            </div>
                        </div>
                        
                            
                            <!-- Another Tab-->
                            <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-diagnosis-tab" data-bs-toggle="tab" data-bs-target="#nav-diagnosis" type="button" role="tab" aria-controls="nav-diagnosis" aria-selected="true">Appointment Schedule</button>
                            <button class="nav-link" id="nav-appointment-tab" data-bs-toggle="tab" data-bs-target="#nav-appointment" type="button" role="tab" aria-controls="nav-appointment" aria-selected="false">Create Appointment</button>
                        </div>
                        </nav>
                        <div class="bg-white">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-diagnosis" role="tabpanel" aria-labelledby="nav-diagnosis-tab">
                            <div id="diagnosisContainer" class="bg-white p-3">
                            
                            <div class="text-dark border rounded p-3 mb-3">
                                <div class="d-flex justify-content-center">
                                    <div id="calendar"></div>
                                </div>
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
                            <div class="tab-pane fade" id="nav-appointment" role="tabpanel" aria-labelledby="nav-appointment-tab">
                            <div class="rounded p-5 bg-white">
                                <h2 style="color: #6537AE;" class="text-center mb-5">Next Appointment for Client</h2>
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Select Date Appointment<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" value="<?php echo isset($date) ? $date : ''; ?>" required autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Select Time Appointment <span class="text-danger">*</span></label>
                                            <select class="form-control" name="time" id="time" required>
                                                <option value="" disabled>-- Select Time --</option>
                                                <?php if (isset($time)): ?>
                                                    <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                            <div class="col-md-4">
                                                <label> Services <span class="text-danger">*</span></label>
                                                <div>
                                                    
                                                </div>
                                                <select class="select2 form-select" name="services" required>
                                                    <?php generateServiceDropdown($conn); ?>
                                                </select>
                                            </div>
                                        <div class="mb-3 mt-3 ">
                                            <input type="submit" name="add_appointment" class="btn btn-purple bg-purple text-white float-end" value="Add Appointment">
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
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
                    <h5 class="modal-title" id="dataModalLabel">Edit Diagnosis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="displaydata" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
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
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: 'get_schedule.php?id=<?php echo $id; ?>',
                eventClick: function(event) {
                    alert('Event clicked: ' + event.title);
                }
            });
        });
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
   document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('clearFormButton').addEventListener('click', function () {
            document.getElementById('sessionForm').reset();
        });
    });
</script>
<script>
function showData(id) {
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
</script>
<script>
    $(document).ready(function() {
    var table = $('#clientTable').DataTable({
        order: [[0, 'desc']],
        responsive: true,
        dom: "<'row'<'col-sm-1 mt-2 text-center'B><'col-md-1 mt-2 ' l><'col-md-10'f>>" +
     "<'row'<'col-md-12'tr>>" +
     "<'row'<'col-md-12'i><'col-md-12'p>>",
     buttons: [
    {
        extend: 'collection',
        text: '<i class="bi bi-box-arrow-up"></i>',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                title: 'Z Skin Care Report (<?php echo $fname . " " . $mname . " " . $lname . " " . $sname; ?>)',
                exportOptions: {
                    columns: [0, 1, 3, 4, 5],
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



        },
    },
            'copy',
            {
                extend: 'excelHtml5',
                text: 'Excel',
                title: 'Z-Skin Care Report',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 3, 5],
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
        "columnDefs": [
            {"targets": [2],"visible": false, "searchable": false},
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
    </body>
    </html>