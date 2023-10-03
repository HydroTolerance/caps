<?php
    include "../function.php";
    checklogin();
    $userData = $_SESSION['id'];
    ?>
   <?php
include "../../db_connect/config.php";

if (isset($userData['id'])) {
    $userId = $userData['id'];
    date_default_timezone_set('Asia/Manila');
    $currentYear = date("m");
    $queryServices = "SELECT services, COUNT(*) as service_count 
        FROM (
            SELECT services FROM zp_appointment WHERE MONTH(created) = $currentYear AND client_id = $userId
        ) AS combined_services
        GROUP BY services";

    $resultServices = mysqli_query($conn, $queryServices);
    $serviceLabels = [];
    $serviceCounts = [];

    while ($rowService = mysqli_fetch_assoc($resultServices)) {
        $serviceLabels[] = $rowService['services'];
        $serviceCounts[] = $rowService['service_count'];
    }
} else {
    // Handle the case where userData['id'] is not set or is not a valid integer
    // You can provide a default behavior or error message here
    $serviceLabels = [];
    $serviceCounts = [];
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
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 mt-2 fade-in">
                                        <div class="border bg-body rounded pt-3 pb-3 d-flex justify-content-center align-items-center">
                                            <div class="mx-2 text-center">
                                                <h5>Services</h5>
                                                <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                                                    <canvas id="serviceChart"  width="1000" height="200"></canvas>
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
        <script>
            function renderEventDetails(event, element) {
  var time = event.time ? '<br>' + event.time : '';
  element.find('.fc-title').append(time);
  element.addClass('rendered');

  var details = '<div class="event-details">' +
      '<strong>Name:</strong> ' + event.name + '<br>' +
      '<strong>Email:</strong> ' + event.email + '<br>' +
      '<strong>Services:</strong> ' + event.services + '<br>' +
      '<strong>Date:</strong> ' + event.date + '<br>' +
      '<strong>Time:</strong> ' + event.time +
      '</div>';

  tippy(element[0], {
    zIndex: 10000,
    placement: 'right',
      interactive: true,
      content: details,
      allowHTML: true,
      appendTo: document.body,
  });

  element.css({
      'background-color': event.color,
      'border-color': event.color
  });
}

$(document).ready(function() {
  $('#calendar').fullCalendar({
    eventLimit: true,
  views: {
    agenda: {
      eventLimit: 6
    }
  },
      editable: true,
      header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay,listMonth'
      },
      events: 'get_booking.php?id=<?php echo $userData['id']; ?>',
      eventRender: function(event, element) {
          var duplicate = checkForDuplicateEvent(event);
          if (!element.hasClass('rendered') && !duplicate) {
              renderEventDetails(event, element);
          }
      },
      viewRender: function(view, element) {
          $('.event-details').remove(); // Remove existing tooltips
      },
      eventAfterAllRender: function(view) {
          $('.fc-event').each(function() {
              var event = $(this);
              var tooltip = event.data('tippy');
              if (tooltip) {
                  tooltip.enable(); // Enable tooltips for rendered events
              }
          });
      }
  });
});

// Function to check for duplicate events
function checkForDuplicateEvent(event) {
  var existingEvents = $('#calendar').fullCalendar('clientEvents');

  for (var i = 0; i < existingEvents.length; i++) {
      var existingEvent = existingEvents[i];

      if (existingEvent.id !== event.id && existingEvent.title === event.title && existingEvent.start.isSame(event.start)) {
          return true;
      }
  }

  return false;
}

        </script>
        </body>
    </html>