
      function renderEventDetails(event, element) {
        var time = event.time ? '<br>' + event.time : '';
        element.find('.fc-title').append(time);
        element.addClass('rendered');

        var details = '<div class="event-details">' +
          '<strong>Name:</strong> ' + event.name + '<br>' +
          '<strong>Number:</strong> ' + event.number + '<br>' +
          '<strong>Email:</strong> ' + event.email + '<br>' +
          '<strong>Health Concern:</strong> ' + event.healthConcern + '<br>' +
          '<strong>Services:</strong> ' + event.services + '<br>' +
          '<strong>Date:</strong> ' + event.date + '<br>' +
          '<strong>Time:</strong> ' + event.time +
          '</div>';

        tippy(element[0], {
          placement: 'bottom-start',
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
          editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },
          events: './get_booking.php',
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
