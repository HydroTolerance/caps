<!DOCTYPE html>
<html>
<head>
  <!-- Include FullCalendar CSS and jQuery library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
</head>
<body>
  <div id="calendar"></div>

  <script>
    $(document).ready(function() {
      $('#calendar').fullCalendar({
        // Set your FullCalendar options here

        events: 'get_booking.php',
        
        eventRender: function(event, element) {
          element.find('.fc-title').append('<br>' + event.title);
        }
      });
    });
  </script>
</body>

</html>
