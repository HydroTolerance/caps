<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <title>Document</title>
</head>
<body>
<div class="container mt-5">
    <div class="mb-3">
        <label for="searchReference" class="form-label">Search by Reference Code:</label>
        <input type="text" class="form-control" id="searchReference" placeholder="Enter Reference Code">
        <button class="btn btn-primary mt-2" onclick="searchAppointment()">Search</button>
    </div>
    <table id="patientTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Services</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reference Code</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../db_connect/config.php";
            $stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr class="patient-row" style="display: none;">
                    <td><?php echo $row['appointment_id'] ?></td>
                    <td><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></td>
                    <td><?php echo $row['services'] ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['date'])) ?></td>
                    <td><?php echo $row['time'] ?></td>
                    <td><?php echo $row['reference_code'] ?></td>
                    <td id="status_<?php echo $row['id']; ?>"
                        class="status-<?php echo strtolower(str_replace(' ', '-', $row['appointment_status'])); ?>">
                        <?php echo $row['appointment_status']; ?>
                    </td>
                    <td>
                        <?php
                        if ($row['appointment_status'] !== 'Rescheduled' && $row['appointment_status'] !== 'Cancelled' && $row['appointment_status'] !== 'Completed' && $row['appointment_status'] !== 'Did not show' && $row['appointment_status'] !== 'Acknowledge') {
                        ?>
                            <button class="btn btn-primary" onclick="showRescheduleModal(<?php echo $row['id']; ?>, 'Reschedule')">Reschedule Appointment</button>
                            <button class="btn btn-danger" onclick="showCancelledModal(<?php echo $row['id']; ?>, 'Cancelled')">Cancel Appointment</button>
                        <?php
                        } else {
                        ?>
                            <button class="btn btn-primary" disabled>Reschedule Appointment</button>
                            <button class="btn btn-danger" disabled>Cancel Appointment</button>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            mysqli_close($conn);    
            ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Cancelled appointment details will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelledModal" tabindex="-1" aria-labelledby="cancelledLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelledLabel">Cancelled Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Cancelled appointment details will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-Vn539f3m5K/PDweF5IV3b3O+d0bi6b7fV5dw5VlVfj5F5a5/J+76j5U5z6W5O5w5D5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    function searchAppointment() {
        var inputReference = document.getElementById("searchReference").value.trim().toUpperCase();
        var rows = document.getElementsByClassName("patient-row");
        var found = false;
        for (var i = 0; i < rows.length; i++) {
            var referenceCell = rows[i].getElementsByTagName("td")[5];
            if (referenceCell) {
                var referenceText = referenceCell.textContent || referenceCell.innerText;
                if (referenceText.toUpperCase() === inputReference) {
                    rows[i].style.display = "";
                    found = true;
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
        if (!found) {
            Swal.fire({
            icon: 'error',
            title: 'Incorrect Reference Code',
            text: 'Please Try Again!',
            });
        }
    }
    
    $(document).ready(function() {
        $('#patientTable').DataTable({
        });
    });
    $(document).ready(function() {
    $('#patientTable').DataTable({
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        "buttons": [
          'searchBuilder',
          'copy',
          'csv',
          'excel',
          'pdf',
          'print'
      ],
    });
});


function showRescheduleModal(id) {
$.ajax({
    url: 'get_reschedule.php',
    type: 'POST',
    data: { id: id, secret_key: 'helloimjaycearon' },
    success: function (response) {
        $('#rescheduleModal .modal-body').html(response);
        $('#rescheduleModal').modal('show');
    }
});
}

function showCancelledModal(id) {
$.ajax({
    url: 'get_cancelled.php',
    type: 'POST',
    data: { id: id, secret_key: 'helloimjaycearon' },
    success: function (response) {
        $('#cancelledModal .modal-body').html(response);
        $('#cancelledModal').modal('show');
    }
});
}
</script>

</body>
</html>
