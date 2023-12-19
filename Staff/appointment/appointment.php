<?php 
include "../function.php";
checklogin('Staff');
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
             body{
            padding-right: 0 !important;
        }
.page-item.active .page-link {
    background-color: #6537AE !important;
    color: #fff !important;
    border: #6537AE;
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

        th{
   background-color:#6537AE  !important;

   color: #fff  !important;
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
#statusFilter::-webkit-select-button {
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16"><path d="M2 3a1 1 0 011-1h10a1 1 0 110 2H3a1 1 0 01-1-1z"/><path d="M2 7a1 1 0 011-1h10a1 1 0 010 2H3a1 1 0 01-1-1z"/><path d="M2 11a1 1 0 011-1h10a1 1 0 010 2H3a1 1 0 01-1-1z"/></svg>');
  }
  .top-height {
    margin-top: 14px;
    height: -10px;
  }
  .custom-width{
    width: 150px;
  }
  #pageloader {
        background: rgba(255, 255, 255, 0.9);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    .custom-loader {

        margin: 0 auto;
        margin-top: 35vh;
    }

    /* FlipX animation for the custom-loader and the image */
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
    
<div id="pageloader">
    <div class="custom-loader flipX-animation"></div>
    <div class="text-center">
        <img src="../../t/images/6.png" style="width: 125px;" alt="logo" class="mb-4 flipX-animation animate__animated">
    </div>
    <h4 class="text-center" style="font-family: Lora;"> Please Wait</h4>
</div>

<div id="wrapper">
    <?php include "../sidebar.php"; ?>
        <section id="content-wrapper">
            <div class="bg-white py-3 mb-3 border border-bottom">
                <div class="d-flex justify-content-between mx-4">
                    <div>
                        <h2 style="color:6537AE;" class="fw-bold">APPOINTMENT</h2>
                    </div>
                    <div class="align-items-center">
                        <a class="btn bg-purple text-white" onclick="addAppointmentModal()">CREATE</a>
                    </div>
                </div>
            </div>
            <div class="row mx-1">
                <div class="col-lg-12">
                <div class="bg-white p-3 rounded-3 border mb-1" >
                <div class="row">
                <div class="col-md-3">
                    <label for="yearFilter">Filter Date</label>
                    <div id="reportrange" class="form-control form-control-sm">
                        <i class="bi bi-calendar"></i>&nbsp;
                        <span class="text-secondary" style="font-size: 14px;"> Start Date - End Date</span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="yearFilter">Filter by Time</label>
                    <select id="yearFilter" class="form-select form-select-sm">
                        <option value="">All Time</option>
                        <?php
                        $query = "SELECT DISTINCT slots AS slots FROM appointment_slots ORDER BY slots ASC";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $year = $row['slots'];
                            echo '<option value="' . $year . '">' . $year . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="yearFilter">Filter by Services</label>
                    <select id="yearFilter1" class="form-select form-select-sm">
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
                <div class="col-md-2">
                    <label for="yearFilter">Status</label>
                    <select id="statusFilter" class="form-control form-control-sm" >
                        <option hidden>Status</option>
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
                    <th class="text-nowrap">Reference Code</th>
                    <th>Full Name</th>
                    <th>Services</th>
                    <th class="text-nowrap" data-bs-toggle="popover" data-bs-placement="Right" data-bs-content="Descending">Appointment Date</th>
                    <th class="text-nowrap" data-bs-toggle="popover" data-bs-placement="Right" data-bs-content="Descending">Appointment Time</th>
                    <th>Health Concern</th>
                    <th>Health Concern</th>
                    <th>Status</th>
                    <th>Status</th>
                    <th>View Information</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
</div>
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
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
<div class="modal fade" id="insertAppointment" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:6537AE" id="insertModalLabel">Create Appointment</h5>
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
            </div>
        </section>
    </div>
</div>
                
        
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    
</script>
<script>
    
var urlParams = new URLSearchParams(window.location.search);
    var appointmentId = urlParams.get('appointment_id');

    var ajaxConfig = {
        "url": "reload.php",
        "type": "GET",
        "dataSrc": "data"
    };
    if (appointmentId) {
        ajaxConfig.data = { "appointment_id": appointmentId };
    }
$(document).ready(function() {
    var dataTable = $('#example').DataTable({
    responsive: true,
    
    dom: '<"row mx-auto"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end"B>>rtip',
    "ajax": ajaxConfig,
                columns: [
            { data: 'reference_code' },
            { 
                data: null,
                render: function(data, type, row) {
                    return row.firstname + ' ' + row.lastname;
                }
            },
            { data: 'services' },
            {
                data: null,
                render: function(data, type, row) {
                    var formattedDate = new Date(row.date);  // Assuming 'date' is the name of your date column
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    var formattedDateString = formattedDate.toLocaleDateString('en-US', options);
                    
                    return '<span data-order="' + row.date + '">' + formattedDateString + '</span>';
                }
            },

            { data: 'time' },
            { data: 'health_concern' },
            { data: 'health_concern' },
            { 
                data: null,
                render: function(data, type, row) {
                    return '<span id="status_' + row.id + '" class="status-' + row.appointment_status.toLowerCase().replace(' ', '-') + '">' + row.appointment_status + '</span>';
                }
            },
            {
    data: null,
    render: function(data, type, row) {
        var statusClass = 'status-' + row.appointment_status.toLowerCase().replace(/\s+/g, '-');
        return '<span id="status_' + row.id + '" class="' + statusClass + ' d-flex justify-content-center align-item-center"> ' + row.appointment_status + '</span>';
    }
},
            { 
                data: null,
                render: function(data, type, row) {
                    return '<div class="text-center"><button class="btn bg-purple text-white status-select text-center" onclick="showData(' + row.id + ')">View</button></div>';
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    var isCompleted = (row.appointment_status === 'Completed' || row.appointment_status === 'Cancelled' || row.appointment_status === 'Did not show');
                    return '<select class="form-select custom-width text-nowrap" data-id="' + row.id + '" name="status" ' + (isCompleted ? 'disabled' : '') + ' onchange="updateStatus(' + row.id + ', this.value)">' +
                        '<option ' + (row.appointment_status === 'Pending' ? 'selected' : '') + ' value="Pending" hidden>Pending</option>' +
                        '<option ' + (row.appointment_status === 'Completed' ? 'selected' : '') + ' value="Completed">Completed</option>' +
                        '<option ' + (row.appointment_status === 'Acknowledged' ? 'selected' : '') + ' value="Acknowledged">Acknowledged</option>' +
                        '<option ' + (row.appointment_status === 'Rescheduled (Admin)' ? 'selected' : '') + ' value="Rescheduled (Admin)">Rescheduled</option>' +
                        '<option ' + (row.appointment_status === 'Rescheduled (Derma)' ? 'selected' : '') + ' value="Rescheduled (Derma)" hidden>Rescheduled</option>' +
                        '<option ' + (row.appointment_status === 'Rescheduled (Client)' ? 'selected' : '') + ' value="Rescheduled (Client)" hidden>Rescheduled</option>' +
                        '<option ' + (row.appointment_status === 'Cancelled' ? 'selected' : '') + ' value="Cancelled">Cancelled</option>' +
                        '<option ' + (row.appointment_status === 'Did not show' ? 'selected' : '') + ' value="Did not show">Did not Show</option>' +
                        '</select>';
                }
            }
        ],

    buttons: [
        {
            extend: 'pdfHtml5',
            text: '<i class="bi bi-filetype-pdf fs-6"></i> PDF',
            title: 'Z-Skin Care Report',
            orientation: 'landscape',
            className: 'outline',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 7],
            },
            customize: function (doc) {
                doc.content[1].table.widths = ['10%', '11%', '12%', '12%', '15%', '25%', '10%'];
                doc.styles.title = {
                    color: '#2D1D10',
                    fontSize: '16',
                    alignment: 'center'
                };
                doc.content[1].table.headerRows = 1;
                doc.content[1].table.body[0].forEach(function (cell) {
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
                logActivityForFileDownload('pdf');
            },
        },
        {
            extend: 'excelHtml5',
            text: '<i class="bi bi-file-earmark-spreadsheet fs-6"> </i>Excel',
            title: 'Z Skin Care Report',
            orientation: 'landscape',
            className: 'outline',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 7],
            },
            customize: function (xlsx) {
        logActivityForFileDownload('excel');  // Specify the file type as 'excel'
    }
        },
        {
            extend: 'print',
            text: '<i class="bi bi-printer fs-6"> </i>Print',
            className: 'outline',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 7],
            },
            customize: function (win) {
                $(win.document.body).find('table tbody td:nth-child(6)').css('white-space', 'pre-line');
            },
        }
    ],
    scrollY: 500,
    scrollX: true,
    scrollCollapse: true,
    paging: true,
    fixedColumns: true,
    order: [[4, 'asc']],
    select: true,
    "columnDefs": [
        {"targets": [5], "visible": false, "searchable": false},
        {"targets": [6], "visible": false, "searchable": false},
        {"targets": [7], "visible": false, "searchable": false},
        {"targets": [10], "visible": false, "searchable": false},
        {"orderable": false, "targets": [0, 1, 2, 5, 6, 7, 8, 9, 10]},
        {"orderable": true, "targets": [3, 4]}
    ],
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

setInterval(function () {
                dataTable.ajax.reload(null, false); // Reload data without resetting paging
            }, 10000);
            
var minDateFilter = null;
var maxDateFilter = null;
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var min = minDateFilter ? moment(minDateFilter) : null;
    var max = maxDateFilter ? moment(maxDateFilter) : null;
    var date = moment(data[3], 'MMMM D, YYYY');
    if ((min === null || date.isSameOrAfter(min)) && (max === null || date.isSameOrBefore(max))) {
        return true;
    }
    return false;
});

$('#reportrange').on('apply.daterangepicker', function () {
    dataTable.draw();
});

$('#yearFilter').on('change', function () {
    var selectedYear = $(this).val();
    dataTable.column(4).search(selectedYear, true, false).draw();
});

$('#yearFilter1').on('change', function () {
    var selectedYear = $(this).val();
    dataTable.column(2).search(selectedYear, true, false).draw();
});

var statusFilter = $('#statusFilter');

// Apply the status filter on change
statusFilter.on('change', function () {
    var selectedStatus = $(this).val();
    dataTable.column(8).search(selectedStatus).draw();
});

});
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

function addAppointmentModal(id) {
    $.ajax ({
        url: 'create_appointment.php',
        type: 'POST',
        data: {id: id},
        success: function(response){
            $('#insertAppointment .modal-body').html(response);
            $('#insertAppointment').modal('show');
        }

    });
}
function logActivityForFileDownload(fileType) {
    var userData = <?php echo json_encode($_SESSION['id']); ?>;
    var clinicRole = userData['clinic_role'];
    var name = userData['clinic_lastname'];
    var actionDescription = "Downloaded Z-Skin Care Report";
    actionDescription += " (" + fileType.toUpperCase() + ")";

    logActivity(userData['id'], name, clinicRole, actionDescription);
}
function logActivity(userId, name, role, actionDescription) {
    $.ajax({
        url: 'log_activity.php',
        type: 'POST',
        data: {
            user_id: userId,
            name: name,
            action_type: 'File Download',
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

</body>
</html>
