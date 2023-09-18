<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- Include DataTables CSS and JavaScript -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Include DataTables Buttons and related extensions -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

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
                <th>All Info</th>
                <th>Transaction</th>
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
                    <td><button class="btn btn-primary" onclick="showData('<?php echo $row['id']; ?>')">View Data</button>
                    </td>
                    <td>
                        <select class="form-select" name="status" onchange="updateStatus(<?php echo $row['id']; ?>, this.value)">
                            <option value="Completed" <?php if ($row['appointment_status'] === 'Completed') echo 'selected'; ?>>Rescheduled</option>
                            <option value="Cancelled"<?php if ($row['appointment_status'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>
                <?php
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-Vn539f3m5K/PDweF5IV3b3O+d0bi6b7fV5dw5VlVfj5F5a5/J+76j5U5z6W5O5w5D5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

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
            alert("Reference code not found.");
        }
    }
    
    $(document).ready(function() {
        $('#patientTable').DataTable({
            "dom": 'Bfrtip',
            "buttons": [
                'searchBuilder',
                'copy',
                'csv',
                'excel',
                'pdf',
                'print'
            ]
        });
    });
    
</script>

</body>
</html>
