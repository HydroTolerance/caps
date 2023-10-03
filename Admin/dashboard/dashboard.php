<?php
    include "../function.php";
    checklogin();
    $userData = $_SESSION['zep_acc'];
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

        $queryServices = "SELECT services, COUNT(*) as service_count 
        FROM (
            SELECT services FROM zp_appointment WHERE MONTH(date) = $currentYear
        ) AS combined_services
        GROUP BY services";
$resultServices = mysqli_query($conn, $queryServices);
$serviceLabels = [];
$serviceCounts = [];

while ($rowService = mysqli_fetch_assoc($resultServices)) {
$serviceLabels[] = $rowService['services'];
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
            <section id="content-wrapper">
                    <div class="row">
                        <div class="container">
                            <div class="row ">
                                <div class="col-md-3 mb-2">
                                    <div class="card h-100 fade-in ">
                                        <div class="card-body ">
                                            <div style="text-align: center;"> <!-- Center align the content -->
                                                <img src="<?php echo $userData['image']; ?>" class="rounded-circle mb-3" height="80px" width="80px" class="card-img-top" alt="...">
                                            </div>
                                            <h4 class="text-center"><?php echo $userData['clinic_firstname'] . " " . $userData['clinic_lastname']; ?></h4>
                                            <p class="card-text text-center"><?php echo $userData['clinic_role'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 mb-2">
                                    <div class="fade-in ">
                                        <!-- Purple Box -->
                                        <div class="bg-purple p-3 rounded mb-3 h-100">
                                            <!-- Container for Text and Picture  -->
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h2 class="text-white">Hello Arola</h2>
                                                    <div>
                                                        <div>
                                                            <span class="text-white">Total of appointment Today Are!: ></span>
                                                        </div>
                                                        <br>
                                                        <div>
                                                            <h1 class="text-white counter" ><?php echo $totalAppointments; ?></h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <img src="../image/dashboard.png" alt="" height="160px" class="w-100 ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="bg-white p-4 fade-in text-center rounded">
                                        Total of Appointment for this Month: <span class="bg-purple p-3 m-3 rounded text-white"><?php echo $totalApproved + $totalPending + $totalReschedule; ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="bg-white p-4 fade-in text-center rounded">
                                        Total of Completed Appointment for this Month: <span class="bg-purple p-3 m-3 rounded text-white"><?php echo $totalApproved?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 mt-2 fade-in">
                                        <div class="border bg-body rounded pt-3 pb-3 d-flex justify-content-center align-items-center">
                                            <div class="mx-2 text-center">
                                                <h5>Services for this Month</h5>
                                                <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                                                    <canvas id="serviceChart"  width="1000" height="200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 mt-2 fade-in">
                                        <div class="border bg-body rounded pt-3 justify-content-center pb-3 d-flex  h-100">
                                        <div class="mx-2 text-center">
                                                <h5>Total Appointments: <?php echo $totalApproved + $totalPending + $totalReschedule; ?></h5>
                                                <div style="margin: -50px;">
                                                <canvas id="appointmentChart" width="300" height="300"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Total Patients Chart -->
                                    <div class="col-md-6 mt-2 fade-in">
                                            <div class="border bg-body rounded pt-3 pb-3 d-flex justify-content-center align-items-center flex-shrink-0 h-100">
                                            <div class="mx-2 text-center">
                                                    <h5>Total Patients: <?php echo $totalPatient; ?></h5>
                                                    <div style="margin: -50px;">
                                                        <canvas id="patientChart" width="300" height="300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        
                                        <div class="text-center mt-4 mb-5 bg-white border rounded fade-in">
                                        <div class="p-4" id="calendar"></div>
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
                    data: [<?php echo $totalApproved; ?>, <?php echo $totalPending; ?>, <?php echo $totalReschedule; ?>],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                }],
                labels: ['Completed', 'Pending', 'Rescheduled',],
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
                    plugins: {
                        legend: {
                            position: 'right',
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
                    plugins: {
                        legend: {
                            position: 'right',
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