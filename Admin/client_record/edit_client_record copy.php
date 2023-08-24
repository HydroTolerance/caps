    <?php
    include "../function.php";
    require_once 'classes/ClientRecord.php';
    require_once 'classes/View.php';
    require_once 'classes/Controller.php';
    require_once 'classes/Database.php';
    include '../../db_connect/config.php';
    checklogin();
    
    $clientRecord = new ClientRecord($conn);
    $controller = new Controller($clientRecord);
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
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
        <style>
        </style>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <?php include "../sidebar.php"; ?>
            <div class="col main-content custom-navbar bg-light">
                <?php include "../navbar.php";?>
                <div class="ms-3">
                    <div class="m-2 bg-white text-dark p-4 rounded-4 border border-4 shadow-sm">
                        <h2 style="color:6537AE;" class="text-center">Client Record (Edit)</h2>
                        <form method="post">
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-2">
                                    <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%;">
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-2">First Name:</label>
                                    <input class="form-control" type="text" name="client_firstname" value="<?php echo $fname; ?>" required>
                                    <label class="mb-2">Last Name:</label>
                                    <input class="form-control" type="text" name="client_lastname" value="<?php echo $lname; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <input class="form-label" type="hidden" name="id" value="<?php echo $id; ?>">
                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="mb-3">Gender:</label>
                                    <select class="form-control" name="client_gender" required>
                                        <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-3">Date of Birth:</label>
                                    <input class="form-control" type="date" name="client_birthday" value="<?php echo $dob; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="mb-2 mt-4">EMERGENCY PERSON:</label>
                                <hr>
                                <div class="col-md-6">
                                    <label class="mb-3">Contact Number:</label>
                                    <input class="form-control" type="text" name="client_number" value="<?php echo $contact; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-3">Email:</label>
                                    <input class="form-control" type="email" name="client_email" value="<?php echo $email; ?>" required>
                                </div>
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
                                <input class="btn btn-purple bg-purple text-white" type="submit" name="update_diagnosis" value="Update">
                                <a class="btn btn-warning" href="client_record.php">Cancel</a>
                            </div>
                        </form>
                        <button onclick="showDiagnosis()">Show Diagnosis</button>
                        <button onclick="showAppointment()">Show Appointment</button>

                        <div id="diagnosisContainer">
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="mb-3">
                                    <label class="mb-3">Date of Diagnosis:</label>
                                    <input class="form-control" name="date_diagnosis" type="date"></input>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-3">History of the Patient:</label>
                                    <textarea class="form-control" name="history" id="summernote" rows="4"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-3">Diagnosis of the Patient:</label>
                                    <textarea class="form-control" name="diagnosis" id="summernote" rows="4"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-3">Management</label>
                                    <textarea class="form-control" name="management" id="summernote" rows="4"></textarea>
                                </div>
                                <div class="mb-3">
                                    <input class="btn btn-purple bg-purple text-white" type="submit" name="add_diagnosis" value="Add Diagnosis">
                                </div>
                            </form>
                            <div>
                            <div class="bg-white text-dark p-4 rounded-4 border border-4 shadow-sm mb-3">
                                <h2 style="color: 6537AE;">Diagnosis</h2>
                                <?php $controller->displayDiagnosisData($id); ?>
                            </div>
                        </div>
                        </div>
                        <div id="appointmentContainer" style="display: none;">
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="mb-3">
                                    <label class="mb-3">Date of appointment:</label>
                                    <input class="form-control" name="date_appointment" type="date"></input>
                                </div>
                                <div class="mb-3">
                                    <input class="btn btn-purple bg-purple text-white" type="submit" name="add_appointment" value="Add Appointment">
                                </div>
                            </form>
                            <div>
                                <div id="calendar"></div>
                            </div>
                        </div>
                        
                            
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
                    // Initialize Summernote on the textarea
                    $(document).ready(function() {
                    $('#summernote').summernote({
                        height: 200 // You can adjust the height as needed
                    });
                    $('#calendar').fullCalendar({
                        editable:true,
                        header:{
                        left:'prev,next',
                        center:'title',
                        right:'today'
                        },
                    })
                });
        </script>
        <script>
    const diagnosisContainer = document.getElementById('diagnosisContainer');
    const appointmentContainer = document.getElementById('appointmentContainer');

    function showDiagnosis() {
        diagnosisContainer.style.display = 'block';
        appointmentContainer.style.display = 'none';
    }

    function showAppointment() {
        diagnosisContainer.style.display = 'none';
        appointmentContainer.style.display = 'block';
    }
</script>

    </body>
    </html>
