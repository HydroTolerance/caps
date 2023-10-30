<?php 
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
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
.page-item.active .page-link {
    background-color: #6537AE !important;
    color: #fff !important;
    border: #6537AE;
}   

#pageloader {
    background: rgba(255, 255, 255, 0.8);
    display: none;
    height: 100%;
    position: fixed;
    width: 100%;
    z-index: 9999;
}

.custom-loader {
    border: 5px solid #6537AE;
    border-top: 5px solid transparent;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation-name: spin;
    animation-duration: 1s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    margin: 0 auto;
    margin-top: 50vh;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.page-link {
    color: black !important;
}
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
    color: red !important;
}

.status-approved {
    color: green !important;
}

.status-rescheduled {
    color: blue !important;
}
.status-completed {
    color: green !important;
}
.status-did-not-show {
    color: #F9A603 !important;
}
.status-acknowledged {
    color: orange !important;
}
.custom-width {
    width: 150px;
}
    </style>
</head>

<body>
<div id="pageloader">
    <div class="custom-loader"></div>
</div>
<div id="wrapper">
    <?php include "../sidebar.php"; ?>
        <section id="content-wrapper">
            <div class="row mx-1">
                <div class="col-lg-12">
                <h1 class="text-purple" style="color:6537AE;">Appointment</h1>
                <div class="bg-white p-3 rounded-3 border mb-1" >
                <div class="row">
                <div class="col-md-6">
                    <label for="yearFilter">Filter Date:</label>
                    <div id="reportrange" class="form-control">
                        <i class="bi bi-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="statusFilter">Filter Status:</label>
                    <select id="statusFilter" class="form-control">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Acknowledged">Acknowledged</option>
                        <option value="Rescheduled">Rescheduled</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Did not show">Did not Show</option>
                    </select>
                </div>
            </div>
            <table id="example" class="table table-bordered  table-striped nowrap" cellspacing="0" style="width: 100%;" >
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Services</th>
                    <th class="text-nowrap">Appointment Date</th>
                    <th class="text-nowrap">Appointment Time</th>
                    <th class="text-nowrap">Reference Code</th>
                    <th>Status</th>
                    <th>Transaction</th>
                    <th>All Info</th>
                </tr>
            </thead>
            <tbody>
            <?php
include "../../db_connect/config.php";
$stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment ORDER BY date DESC");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_array($result)) {
    $isCompleted = ($row['appointment_status'] === 'Completed' || $row['appointment_status'] === 'Cancelled' || $row['appointment_status'] === 'Did not show');
    ?>
    <tr>
        <td><?php echo $row['firstname']. ' ' .$row['lastname']?></td>
        <td><?php echo $row['services']?></td>
        <td data-order="<?php echo date('Y-m-d', strtotime($row['date'])); ?>"><?php echo date('F d, Y', strtotime($row['date'])); ?></td>
        <td><?php echo $row['time']?></td>
        <td class="text-center"><?php echo $row['reference_code']?></td>
        <td id="status_<?php echo $row['id']; ?>" class="status-<?php echo strtolower(str_replace(' ', '-', $row['appointment_status'])); ?>">
            <?php echo $row['appointment_status']; ?>
        </td>
        <td class="text-center"><button class="btn bg-purple text-white status-select" onclick="showData('<?php echo $row['id']; ?>')">View</button></td>
        <td>
            <select class="form-select  custom-width text-nowrap" data-id="<?php echo $row['id']; ?>" name="status" <?php echo $isCompleted ? 'disabled' : ''; ?> onchange="updateStatus(<?php echo $row['id']; ?>, this.value)">
                <option <?php if ($row['appointment_status'] === 'Pending') echo 'selected'; ?> value="Pending" selected="true" disabled>Pending</option>
                <option value="Completed" <?php if ($row['appointment_status'] === 'Completed') echo 'selected'; ?> value="Completed">Completed</option>
                <option value="Acknowledged" <?php if ($row['appointment_status'] === 'Acknowledged') echo 'selected'; ?>>Acknowledged</option>
                <option value="Rescheduled" <?php if ($row['appointment_status'] === 'Rescheduled') echo 'selected'; ?>>Rescheduled</option>
                <option value="Cancelled" <?php if ($row['appointment_status'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                <option value="Did not show" <?php if ($row['appointment_status'] === 'Did not show') echo 'selected'; ?>>Did not Show</option>
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

<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Center the modal title -->
                <h5 class="modal-title" id="rescheduleModalLabel">Reschedule Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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

            </div>
        </section>
    </div>
</div>
                
        
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    var table = $('#example').DataTable({
        responsive: true,
        dom: "<'row'<'col-sm-1 mt-2'B><'col-md-1 mt-2' l><'col-md-10'f>>" +
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
                title: 'Z-Skin Care Report',
                customize: function (doc) {

                            doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto'];
                            doc.content[1].table.body.forEach(function(row) {
                                row.splice(7, 2);
                            });
                        }
                    },
            'copy',
            'excel',
            'print'
        ]
    }
],

        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        order: [[2, 'desc']],
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
            }, function(start, end) {
                minDateFilter = start.format('MMMM D, YYYY');
        maxDateFilter = end.format('MMMM D, YYYY');
        table.draw();
        dateRangePicker.find('span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
        },
        
    });
    
    var minDateFilter = null;
    var maxDateFilter = null;
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
    var min = minDateFilter ? moment(minDateFilter) : null;
    var max = maxDateFilter ? moment(maxDateFilter) : null;
    var date = moment(data[2], 'MMMM D, YYYY'); // Update the format to match your actual date format
    if ((min === null || date.isSameOrAfter(min)) && (max === null || date.isSameOrBefore(max))) {
        return true;
    }
    return false;
});

    $('#reportrange').on('apply.daterangepicker', function() {
        table.draw();
    });
    $('#yearFilter').on('change', function() {
        var selectedYear = $(this).val();
        table.column(2).search(selectedYear, true, false).draw();
    });
    var statusFilter = $('#statusFilter');

// Apply the status filter on change
statusFilter.on('change', function() {
    var selectedStatus = $(this).val();
    table.column(5).search(selectedStatus).draw();
});
});
</script>
</body>
</html>
