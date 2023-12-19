<?php 
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>
<?php
include "../../db_connect/config.php";
$stmt = mysqli_prepare($conn, "SELECT * FROM activity_log");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Activity Log</title>
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
</head>
<style>
    .page-item.active .page-link {
    background-color: #6537AE !important;
    color: #fff !important;
    border: #6537AE;
}
.page-link {
    color: black !important;
}
th{
        background-color:#6537AE  !important;
        color: #fff  !important;
        text-align: center !important;
        }
                .top-height {
    margin-top: 23px;
    height: -10px;
  }
</style>
<body>
<div id="wrapper">
    <?php include "../sidebar.php"; ?>
    <section id="content-wrapper">
        <div class="row">
            <div class="bg-white py-3 mb-3 border border-bottom">
                <div class="d-flex justify-content-between mx-3">
                    <div>
                        <h2 style="color:6537AE;" class="fw-bold">ACTIVITY LOG</h2>
                    </div>
                </div>
            </div>
        <div>
        <div class="row mx-3">
            <div class="bg-white p-3 rounded-3 border w-100">
                <table id="reportTable" class="table table-bordered table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../../db_connect/config.php";
                        $stmt = mysqli_prepare($conn, "SELECT * FROM activity_log ORDER BY timestamp DESC");
                        
                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['role'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['action_type'] . "</td>";
                                echo "<td>" . $row['action_description'] . "</td>";
                                echo "<td>" . formatTimestamp($row['timestamp']) . "</td>";

                                echo "</tr>";
                            }
                        }
                        function formatTimestamp($timestamp) {
                            $dateTime = new DateTime($timestamp);
                            return $dateTime->format('F j, Y h:i A');
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
function filterTableByYear(selectedYear) {
    $('#reportTable').DataTable().search(selectedYear, true, false).draw();
}
document.getElementById('yearFilter').addEventListener('change', function() {
    const selectedYear = this.value;
    filterTableByYear(selectedYear);
});
</script>
<script>
$(document).ready(function() {
    $('#reportTable').DataTable({
        dom: '<"row  text-end"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end">>rtip',
        responsive: true,
        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        select: true,
        "ordering": false,
    });
});
</script>

</body>
</html>
