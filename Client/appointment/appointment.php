<?php
include "../function.php";
checklogin();
$userData = $_SESSION['clinic_number'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Appointment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="../appointment/js/appointment.js"></script>
    
    <style>
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-buttons a {
            margin-right: 10px;
            color: #222;
            text-decoration: none;
        }

        .action-buttons a:hover {
            color: #777;
        }

        .dataTables_filter input {
            margin-top: 10px;
            margin-right: 10px;
            margin-bottom: 20px;
        }
        .status-cancelled {
    color: red;
}

.status-approved {
    color: green;
}

.status-rescheduled {
    color: blue;
}
.content {
  display: flex;
  justify-content: center;
  align-items: center;
  width:100%;
  height:100%;
}

    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include "../sidebar.php"; ?>
        <div class="col main-content custom-navbar bg-light">
        <?php include "../navbar.php"?>
        <div class="mx-3">
                <h1 class="text-purple">Appointment</h1>
                <div class="bg-white p-3 rounded-3 border w-100 mb-3">
                <table id="patientTable" class="display nowrap responsive" style="width:100%">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Full Name</th>
                    <th>Services</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Reference Code</th>
                    <th>Status</th>
                    <th>View All</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "../../db_connect/config.php";
                $stmt = mysqli_prepare($conn, "SELECT * FROM book1");
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['appointment_id']?></td>
                        <td><?php echo $row['firstname']. ' ' .$row['lastname']?></td>
                        <td><?php echo $row['services']?></td>
                        <td><?php echo date('M d, Y', strtotime($row['date'])) ?></td>
                        <td><?php echo $row['time']?></td>
                        <td><?php echo $row['reference_code']?></td>
                        <td id="status_<?php echo $row['id']; ?>" class="status-<?php echo strtolower(str_replace(' ', '-', $row['appointment_status'])); ?>">
                            <?php echo $row['appointment_status']; ?>
                        </td>
                        <td><button class="btn btn-link" onclick="showData('<?php echo $row['id']; ?>')"> <i class="bi bi-eye-fill text-center dark text-dark fs-4"></i></button></td>
                    </tr>
                    <?php
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
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


</div>
                
        
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        $(window).on("load",function(){
          $(".loader-wrapper").fadeOut("slow");
        });
    </script>
        </div>
    </div>
</div>
        

</body>
</html>
