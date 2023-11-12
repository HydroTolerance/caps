<?php
include "../function.php";
checklogin('Staff');
$userData = $_SESSION['id'];
    ?>
    <?php
        include "../../db_connect/config.php";
        $currentYear = date("m");
        $queryApproved = "SELECT COUNT(*) as total_approved FROM zp_appointment WHERE appointment_status = 'Completed' AND MONTH(date) = $currentYear";
        $resultApproved = mysqli_query($conn, $queryApproved);
        $rowApproved = mysqli_fetch_assoc($resultApproved);
        $totalApproved = $rowApproved['total_approved'];

        $queryPending = "SELECT COUNT(*) as total_pending FROM zp_appointment WHERE appointment_status = 'Pending' AND MONTH(date) = $currentYear";
        $resultPending = mysqli_query($conn, $queryPending);
        $rowPending = mysqli_fetch_assoc($resultPending);
        $totalPending = $rowPending['total_pending'];

        $queryReschedule = "SELECT COUNT(*) as total_reschedule FROM zp_appointment WHERE appointment_status = 'Rescheduled' AND MONTH(date) = $currentYear";
        $resultReschedule = mysqli_query($conn, $queryReschedule);
        $rowReschedule = mysqli_fetch_assoc($resultReschedule);
        $totalReschedule = $rowReschedule['total_reschedule'];

        $queryCancelled = "SELECT COUNT(*) as total_cancelled FROM zp_appointment WHERE appointment_status = 'Cancelled' AND MONTH(date) = $currentYear";
        $resultCancelled = mysqli_query($conn, $queryCancelled);
        $rowCancelled = mysqli_fetch_assoc($resultCancelled);
        $totalCancelled = $rowCancelled['total_cancelled'];

        $queryAcknowledged= "SELECT COUNT(*) as total_Acknowledged FROM zp_appointment WHERE appointment_status = 'Acknowledged' AND MONTH(date) = $currentYear";
        $resultAcknowledged= mysqli_query($conn, $queryAcknowledged);
        $rowAcknowledged= mysqli_fetch_assoc($resultAcknowledged);
        $totalAcknowledged= $rowAcknowledged['total_Acknowledged'];

        $queryDidnotshow= "SELECT COUNT(*) as total_Didnotshow FROM zp_appointment WHERE appointment_status = 'Did not show' AND MONTH(date) = $currentYear";
        $resultDidnotshow= mysqli_query($conn, $queryDidnotshow);
        $rowDidnotshow= mysqli_fetch_assoc($resultDidnotshow);
        $totalDidnotshow = $rowDidnotshow['total_Didnotshow'];

        $queryMale = "SELECT COUNT(*) as total_male FROM zp_client_record WHERE client_gender = 'Male'";
        $resultMale = mysqli_query($conn, $queryMale);
        $rowMale = mysqli_fetch_assoc($resultMale);
        $totalMale = $rowMale['total_male'];

        $queryFemale = "SELECT COUNT(*) as total_female FROM zp_client_record WHERE client_gender = 'Female'";
        $resultFemale = mysqli_query($conn, $queryFemale);
        $rowFemale = mysqli_fetch_assoc($resultFemale);
        $totalFemale = $rowFemale['total_female'];

        date_default_timezone_set('Asia/Manila');
        $today = date("Y-m-d");
        $stmt = mysqli_query($conn, " SELECT COUNT(*) as total_appointment FROM (SELECT date FROM zp_appointment) AS combined_dates WHERE DATE(date) = '$today'");
        $appointment_count = mysqli_fetch_assoc($stmt);
        $totalAppointments = $appointment_count['total_appointment'];

        $queryTotalPatients = "SELECT COUNT(*) as total_patient FROM zp_client_record";
        $resultTotalPatients = mysqli_query($conn, $queryTotalPatients);

        $queryServices = "SELECT management, COUNT(*) as service_count 
        FROM (
            SELECT management FROM zp_derma_record WHERE MONTH(date_diagnosis) = $currentYear
        ) AS combined_services
        GROUP BY management";
        $resultServices = mysqli_query($conn, $queryServices);
        $serviceLabels = [];
        $serviceCounts = [];

        while ($rowService = mysqli_fetch_assoc($resultServices)) {
        $serviceLabels[] = $rowService['management'];
        $serviceCounts[] = $rowService['service_count'];
        }
        if ($resultTotalPatients) {
            $rowTotalPatients = mysqli_fetch_assoc($resultTotalPatients);
            $totalPatient = $rowTotalPatients['total_patient'];
        } else {
            $totalPatient = 'N/A';
        }
        ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
            <title>Dashboard</title>
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/dataTables.bootstrap5.min.css">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.2/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
        </head>
        <style>
            .status-indicator { display: inline-block; margin-right: 10px; width: 20px; height: 20px; border-radius: 50%; }
    .bg-purple { background-color: #6f42c1; }
    .bg-blue { background-color: #007bff; }
    .bg-grey { background-color: #6c757d; } 
    .bg-yellow { background-color: #ffc107; } 
    .bg-green { background-color: #28a745; }
            .dropdown-menu {
            margin-left: -2rem;
        }
        @media (max-width: 768px) {
            .dropdown-menu {
                margin-left: -4rem;
            }
        }
        #serviceChartContainer {
            max-width: 100%;
            height: auto;
        }
        .fade-in {
                animation: fadeIn 1s ease-in-out;
                opacity: 0;
                animation-fill-mode: forwards;
            }
            @keyframes fadeIn {
                0% {
                    opacity: 0;
                }
                100% {
                    opacity: 1;
                }
            }
        </style>
        <body> 
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
                <div class="bg-white py-3 mb-3 border border-bottom">
                    <div class="d-flex justify-content-between mx-4">
                        <div>
                            <h2 style="color:6537AE;" class="fw-bold">DASHBOARD</h2>
                        </div>
                    </div>
                </div>
            <div class="mx-3">

            <section id="content-wrapper">
                    <div class="row mt-3">
                        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 mb-2">
                                <div class="card bg-white p-4 fade-in rounded h-100 d-flex flex-column justify-content-between">
                                    <p>Total of Patients</p>
                                    <span class="badge bg-purple fs-4 p-3 ms-auto rounded" style="padding: 10px;"><?php echo  $totalPatient; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <div class="card bg-white p-4 fade-in rounded h-100 d-flex flex-column justify-content-between">
                                    <p>Total of Appointment Today</p>
                                    <span class="badge bg-purple fs-4 p-3 ms-auto rounded" style="padding: 10px;"><?php echo $totalAppointments; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <div class="card bg-white p-4 fade-in rounded h-100  flex-column justify-content-between">
                                    
                                    <p>This Month's Appointment</p>
                                    <span class="badge bg-purple fs-4 p-3 ms-auto rounded" style="padding: 10px;"><?php echo $totalApproved + $totalPending + $totalReschedule + $totalCancelled + $totalAcknowledged + $totalDidnotshow; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <div class="card bg-white p-4 fade-in rounded h-100 d-flex flex-column justify-content-between">
                                    <p>This Month's Completed Appointments</p>
                                    <span class="badge bg-purple fs-4 p-3 rounded ms-auto" style="padding: 10px;"><?php echo $totalApproved; ?></span>
                                </div>
                            </div>
                            </div>
                        </div>
                    <div>
                                <div class="row">
                                    <div class=" col-xxl-6 col-l-6  mt-2 fade-in">
                                        <div class="border bg-body rounded pt-3 h-100">
                                            <div class=" text-center">
                                                <h5>Services for this Month</h5>
                                                <div class="chart-container ">
                                                    <canvas id="serviceChart" width="550" height="250"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-xxl-6  col-l-6">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6 mt-2 fade-in ">
                                                <div class="border bg-body rounded pt-3 h-100">
                                                <div class="text-center">
                                                        <h5>Total Appointments: <?php echo $totalApproved + $totalPending + $totalReschedule + $totalCancelled + $totalAcknowledged + $totalDidnotshow; ?></h5>
                                                        <div >
                                                        <canvas id="appointmentChart" width="250" height="250"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Total Patients Chart -->
                                            <div class="col-md-6 mt-2 fade-in">
                                                    <div class="border bg-body rounded pt-3 pb-3 h-100">
                                                    <div class=" text-center">
                                                            <h5>Total Patients: <?php echo $totalPatient; ?></h5>
                                                            <div >
                                                                <canvas id="patientChart" width="200" height="200"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="bg-white p-4 fade-in my-3 text-center rounded">
                                <h2 class="text-center mb-3" style="color: #6f42c1;">Color Calendar Appointment Indicator</h2>
                                <div class="status-indicator-container d-flex flex-wrap justify-content-center">
                                    <div class="text-center mx-2">
                                        <span class="status-indicator bg-green"></span> Completed
                                    </div>
                                    <div class="text-center mx-2">
                                        <span class="status-indicator bg-blue"></span> Rescheduled
                                    </div>
                                    <div class="text-center mx-2">
                                        <span class="status-indicator bg-grey"></span> Pending
                                    </div>
                                    <div class="text-center mx-2">
                                        <span class="status-indicator bg-danger"></span> Cancelled
                                    </div>
                                    <div class="text-center mx-2">
                                        <span class="status-indicator bg-purple"></span> Acknowledged
                                    </div>
                                    <div class="text-center mx-2">
                                        <span class="status-indicator bg-yellow"></span> Did Not Show
                                    </div>
                                </div>
                            </div>
                                        <div class="text-center  bg-white border rounded fade-in">
                                        <div class="p-4" id="calendar"></div>
                                        </div>
                                    </div>
                                    
                            
                            </div>
                        </div>
                        
                            
                            
                                </div>
                            </div>
                        </div>
                    </div>
                                
                </div>
            </section>
            </div>
        <script src="js/dashboard.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/counterup/1.0.2/jquery.counterup.min.js"></script>

        <script>
            $(document).ready(function() {
            // Data for the pie charts

            var appointmentChartData = {
                datasets: [{
                    data: [<?php echo $totalPending; ?>,  <?php echo $totalAcknowledged; ?>, <?php echo $totalApproved; ?>,  <?php echo $totalDidnotshow; ?>, <?php echo $totalReschedule; ?>, <?php echo $totalCancelled; ?>],
                    backgroundColor: ['#6c757d', '#6f42c1', '#28a745',  '#ffc107', '#007bff', '#dc3545'],
                }],
                labels: ['Pending', 'Acknowledged', 'Completed', 'Did Not Show', 'Rescheduled', 'Cancelled'],
            };

            var patientChartData = {
                labels: ['Male Patients', 'Female Patients'],
                datasets: [{
                    data: [<?php echo $totalMale; ?>, <?php echo $totalFemale; ?>],
                    backgroundColor: ['#28a745', '#dc3545'],
                }]
            };

            // Create pie charts
            var appointmentChart = new Chart(document.getElementById('appointmentChart'), {
                type: 'doughnut',
                data: appointmentChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                    },
                    cutout: '60%',
                },
            });


            var patientChart = new Chart(document.getElementById('patientChart'), {
                type: 'doughnut',
                data: patientChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            
                        },
                    },
                    cutout: '60%',
                },
            });
            var serviceChartData = {
                labels: <?php echo json_encode($serviceLabels); ?>,
                datasets: [{
                    label: 'Service Count',
                    data: <?php echo json_encode($serviceCounts); ?>,
                    backgroundColor: ['rgba(255, 99, 132, 0.2)','rgba(255, 159, 64, 0.2)','rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            };
            var serviceChart = new Chart(document.getElementById('serviceChart'), {
            type: 'bar',
            data: serviceChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

                    });
                    chart.canvas.parentNode.style.height = '128px';
                    chart.canvas.parentNode.style.width = '128px';
        </script>
        </body>
    </html>