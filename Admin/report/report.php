<?php 
include "../function.php";
checklogin();
$userData = $_SESSION['zep_acc'];
?>
<?php
include "../../db_connect/config.php";
$currentYear = date("Y");
$queryServices = "SELECT services, YEAR(created) AS created_year, COUNT(*) as service_count 
                FROM (
                    SELECT services, created FROM zp_appointment
                    UNION ALL
                    SELECT services_appointment, created FROM zp_derma_appointment
                ) AS combined_services
                GROUP BY services, created_year";
$resultServices = mysqli_query($conn, $queryServices);
$serviceData = [];
while ($rowService = mysqli_fetch_assoc($resultServices)) {
    $serviceLabel = $rowService['services'];
    $createdYear = $rowService['created_year'];

    // Add the data to the serviceData array
    $serviceData[] = [
        'services' => $serviceLabel,
        'created_year' => $createdYear,
        'service_count' => $rowService['service_count']
    ];
}
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
                            <button class="btn bg-purple text-white mb-3" id="generateReport">Export</button>
                        </div>
                        <div class="col-xl-6">
                            <h1 class=" mb-1" style="color:6537AE;">Generate Report</h1>
                        </div>
                    </div>
                </div>
            </div>
        <div>
        <div class="row mx-3">
            <div class="bg-white p-3 rounded-3 border w-100">
                <div class="mb-3 text-end">
                    <label for="yearFilter" class="form-label">Filter by Year: </label>
                </div>
                <table id="reportTable" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Service Label</th>
                            <th>Created Date
                            <select id="yearFilter" class="form-select form-select-sm float-end ms-3" style="width: 16.5%;">
                                <?php
                                $queryUniqueYears = "SELECT DISTINCT YEAR(created) as year FROM zp_appointment UNION SELECT DISTINCT YEAR(created) as year FROM zp_derma_appointment";
                                $resultUniqueYears = mysqli_query($conn, $queryUniqueYears);
                                while ($rowYear = mysqli_fetch_assoc($resultUniqueYears)) {
                                    $year = $rowYear['year'];
                                    echo "<option value=\"$year\">$year</option>";
                                }
                                ?>
                            </select>
                            </th>
                            <th>Service Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($serviceData as $service) {
                            $serviceLabel = $service['services'];
                            $createdDate = $service['created_year'];
                            $serviceCount = $service['service_count'];
                            
                        ?>
                            <tr>
                                <td><?php echo $serviceLabel?></td>
                                <td><?php echo $createdDate?></td>
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
// Function to generate the report in Excel format for the displayed data
function generateExcelReport() {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('Z Skin Files');

    // Define the headers
    worksheet.columns = [
        { header: 'Service', key: 'service', width: 20 },
        { header: 'Count', key: 'count', width: 15 },
    ];

    // Get the data from the displayed DataTable
    const table = $('#reportTable').DataTable();
    const displayedData = table.rows({ search: 'applied' }).data().toArray();

    // Add data rows
    displayedData.forEach(row => {
        const serviceLabel = row[0];
        const serviceCount = row[2];
        worksheet.addRow({ service: serviceLabel, count: serviceCount });
    });

    // Generate the Excel file
    workbook.xlsx.writeBuffer().then(function (data) {
        const blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'report.xlsx';
        a.click();
        window.URL.revokeObjectURL(url);
    });
}

// Add a click event listener to the "Generate Report" button
document.getElementById('generateReport').addEventListener('click', generateExcelReport);

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
            selector: 'td:nth-child(2)'
        },
    });
});
</script>
</body>
</html>
