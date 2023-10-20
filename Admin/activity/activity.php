<?php 
include "../function.php";
checklogin();
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
    <title>Generate Report</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
</head>

<body>
<div id="wrapper">
    <?php include "../sidebar.php"; ?>
    <section id="content-wrapper">
        <div class="row mx-1">
            <div class="col-lg-12">
                <div class="mx-3 text-center">
                    <div class="row">
                        <div class="col-xl-3">
                        </div>
                        <div class="col-xl-6">
                            <h1 class=" mb-1" style="color:6537AE;">Activity Log</h1>
                        </div>
                    </div>
                </div>
            </div>
        <div>
        <div class="row mx-3">
            <div class="bg-white p-3 rounded-3 border w-100">
                <table id="reportTable" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Action
                            </th>
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
                                echo "<td>" . $row['action_type'] . "</td>";
                                echo "<td>" . $row['action_description'] . "</td>";
                                echo "<td>" . $row['timestamp'] . "</td>";
                                echo "</tr>";
                            }
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

$(document).ready(function() {
    $('#reportTable').DataTable({
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(3)'
        },
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
