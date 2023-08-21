<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Export Chart to Excel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
</head>

<body>
    <canvas id="myChart" width="400" height="400"></canvas>
    <button id="exportButton">Export to Excel</button>

    <script>
        // Sample pie chart data
        var chartData = {
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                data: [300, 50, 100],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        };

        // Create the pie chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: chartData
        });

        // Export to Excel button click event
        document.getElementById('exportButton').addEventListener('click', function () {
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet('Chart Data');

            worksheet.columns = [
                { header: 'Label', key: 'label' },
                { header: 'Value', key: 'value' }
            ];

            chartData.labels.forEach((label, index) => {
                worksheet.addRow({ label: label, value: chartData.datasets[0].data[index] });
            });

            workbook.xlsx.writeBuffer().then(function (buffer) {
                var blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'chart_data.xlsx';
                a.click();
                window.URL.revokeObjectURL(url);
            });
        });
    </script>
</body>
</html>
