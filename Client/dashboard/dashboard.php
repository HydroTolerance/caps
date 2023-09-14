<?php
include "../function.php";
checklogin();
$userData = $_SESSION['clinic_number'];
?>
<?php
    include "../../db_connect/config.php";
    $currentYear = date("Y");

    $queryApproved = "SELECT COUNT(*) as total_approved FROM zp_appointment WHERE appointment_status = 'approved' AND YEAR(created) = $currentYear";
    $resultApproved = mysqli_query($conn, $queryApproved);
    $rowApproved = mysqli_fetch_assoc($resultApproved);
    $totalApproved = $rowApproved['total_approved'];

    $queryPending = "SELECT COUNT(*) as total_pending FROM zp_appointment WHERE appointment_status = 'pending' AND YEAR(created) = $currentYear";
    $resultPending = mysqli_query($conn, $queryPending);
    $rowPending = mysqli_fetch_assoc($resultPending);
    $totalPending = $rowPending['total_pending'];

    $queryReschedule = "SELECT COUNT(*) as total_reschedule FROM zp_appointment WHERE appointment_status = 'rescheduled' AND YEAR(created) = $currentYear";
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

    $today = date("Y-m-d");
    $stmt = mysqli_query($conn, " SELECT COUNT(*) as total_appointment FROM (SELECT date FROM zp_appointment UNION ALL SELECT date_appointment FROM zp_derma_appointment) AS combined_dates WHERE DATE(date) = '$today'");
    $appointment_count = mysqli_fetch_assoc($stmt);
    $totalAppointments = $appointment_count['total_appointment'];

    $queryTotalPatients = "SELECT COUNT(*) as total_patient FROM zp_client_record";
    $resultTotalPatients = mysqli_query($conn, $queryTotalPatients);
    
    $queryServices = "SELECT services, COUNT(*) as service_count FROM  zp_appointment WHERE YEAR(created) = $currentYear GROUP BY services";
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
    <div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include "../sidebar.php"; ?>
        <div class="col main-content custom-navbar bg-light">
        <?php include "../navbar.php"?>
        <div class="container">
            <div class="row ">
                <div class="d-flex justify-content-center fade-in">
                    <!-- Purple Box -->
                    <div class="bg-purple col-xl-8 p-3 rounded mb-3 shadow mx-2">
                        <!-- Container for Text and Picture  -->
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="text-white">Hello Arola</h2>
                                <div>
                                    <div>
                                        <span class="text-white">Total of appointment Today Are!</span>
                                    </div>
                                    <br>
                                    <div>
                                        <h1 class="text-white"><?php echo $totalAppointments; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <img src="../image/dashboard.png" alt="" height="160px" class="w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-10 mt-2 fade-in">
                        <div class="border bg-body rounded pt-3 pb-3 d-flex justify-content-center align-items-center">
                            <div class="mx-2 text-center">
                                <h5>Services</h5>
                                <div>
                                    <canvas id="serviceChart" width="1000" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
              <div class="row justify-content-center">
                <div class="col-md-5 mt-2 fade-in">
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
                  <div class="col-md-5 mt-2 fade-in">
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
              
        
                        <div>
                        <div class="text-center mt-4 mb-5 bg-white p-4 border rounded mx-4 fade-in"  id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
                        
                
            </ul>
        </div>
    </div>
    <script src="js/dashboard.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script></script>
    <script>
        $(document).ready(function() {
        // Data for the pie charts
        var appointmentChartData = {
            datasets: [{
                data: [<?php echo $totalApproved; ?>, <?php echo $totalPending; ?>, <?php echo $totalReschedule; ?>],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
            }],
            labels: ['Approved', 'Pending', 'Rescheduled'],
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
                        position: 'right', // Change the position to 'bottom'
                    },
                },
                cutout: '60%', // Adjust the hole size (optional)
            },
        });


        var patientChart = new Chart(document.getElementById('patientChart'), {
            type: 'doughnut',
            data: patientChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right', // Change the position to 'bottom'
                    },
                },
                cutout: '60%', // Adjust the hole size (optional)
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

        // Create bar chart
        var serviceChart = new Chart(document.getElementById('serviceChart'), {
            type: 'bar',
            data: serviceChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
            }
        });
    });
    </script>
    </body>
</html>