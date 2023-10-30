<?php 
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>
<?php
include "../../db_connect/config.php";
$currentYear = date("Y");
$queryServices = "SELECT services, YEAR(date) AS date_year, MONTHNAME(date) AS date_month, COUNT(*) as service_count FROM (SELECT services, date FROM zp_appointment) AS combined_services GROUP BY services, date_year, date_month";
$resultServices = mysqli_query($conn, $queryServices);
$serviceData = [];
while ($rowService = mysqli_fetch_assoc($resultServices)) {
    $serviceLabel = $rowService['services'];
    $dateYear = $rowService['date_year'];
    $dateMonth = $rowService['date_month'];

    // Add the data to the serviceData array
    $serviceData[] = [
        'services' => $serviceLabel,
        'date_year' => $dateYear,
        'date_month' => $dateMonth,
        'service_count' => $rowService['service_count']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
                            <h1 class="mb-1" style="color:6537AE;">Generate Report</h1>
                        </div>
                    </div>
                </div>
            </div>
        <div>
        <div class="row mx-3">
            <div class="bg-white p-3 rounded-3 border w-100">
                <div class="col-md-6">
                <div class="row">
                <div class="col-md-6">
                    <label for="yearFilter">Filter by Year:</label>
                    <select id="yearFilter" class="form-select">
                        <option value="">All Years</option>
                        <!-- Generate options dynamically based on available years -->
                        <?php
                        $query = "SELECT DISTINCT YEAR(date) AS year FROM zp_appointment ORDER BY year DESC";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $year = $row['year'];
                            echo '<option value="' . $year . '">' . $year . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="monthFilter">Filter by Month:</label>
                    <select id="monthFilter" class="form-select">
                        <option value="">All Months</option>
                        <!-- Generate options dynamically based on available months -->
                        <?php
                        $query = "SELECT DISTINCT MONTHNAME(date) AS month FROM zp_appointment ORDER BY date";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $month = $row['month'];
                            echo '<option value="' . $month . '">' . $month . '</option>';
                        }
                        ?>
                    </select>
                </div>
                </div>
                
                </div>
                
                <table id="reportTable" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Service Label</th>
                            <th>Yearly Report</th>
                            <th>Montly Report</th>
                            <th>Service Rendered</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($serviceData as $service) {
                            $serviceLabel = $service['services'];
                            $dateYear = $service['date_year'];
                            $dateMonth = $service['date_month'];
                            $serviceCount = $service['service_count'];
                        ?>
                            <tr>
                                <td><?php echo $serviceLabel?></td>
                                <td><?php echo $dateYear?></td>
                                <td><?php echo $dateMonth?></td>
                                <td><?php echo $serviceCount?></td>
                            </tr>
                        <?php
                        }
        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // DataTable initialization
    var table = $('#reportTable').DataTable({
        order: [[0, 'desc']],
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
                title: 'Z-Skin Care Report', // Add your custom title here
                    },
            'copy',
            'excel',
            'csv',
            'print'
        ]
    }
],
    });
    // Filter by Year
    $('#yearFilter').on('change', function() {
        var selectedYear = $(this).val();
        table.column(1).search(selectedYear).draw();
    });
    
    // Filter by Month
    $('#monthFilter').on('change', function() {
        var selectedMonth = $(this).val();
        table.column(2).search(selectedMonth).draw();
    });
});
</script>
</body>
</html>
