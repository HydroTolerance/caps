function logStatusChange(id, status) {
  $.ajax({
    type: 'POST',
    url: 'activity_log.php',
    data: {
      appointmentId: id,
      newStatus: status,
    },
  });
}


// Function to update the appointment status with confirmation
function updateStatus(id, status) {
  var statusSelect = $('.form-select[data-id="' + id + '"]');
  if (status === 'Completed') {
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to complete this appointment?',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'No',
      confirmButtonText: 'Yes',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    }).then((result) => {
      if (result.isConfirmed) {
        performStatusUpdate(id, status);
        logStatusChange(id, status);
        statusSelect.prop('disabled', true);
      }
    });
  } else if (status === 'Did not show') {
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to set "Did not Show" to this appointment?',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'No',
      confirmButtonText: 'Yes',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
  }).then((result) => {
      if (result.isConfirmed) {
          performStatusUpdate(id, status);
          logStatusChange(id, status);
          statusSelect.prop('disabled', true);
      }
  });
    
  } else if (status === 'Acknowledged') {
    Swal.fire({
      title: 'Confirmation',
      text: 'Are you sure you want to acknowledge this appointment?',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'No',
      confirmButtonText: 'Yes',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    }).then((result) => {
      if (result.isConfirmed) {
        performStatusUpdate(id, status);
        acknowledgeAppointment(id);
        logStatusChange(id, status);
      }
    });
  } else if (status === 'Rescheduled (Derma)') {
    showRescheduleModal(id);
    logStatusChange(id, status);
  } else if (status === 'Cancelled') {
    showCancelledModal(id);
    logStatusChange(id, status);
  } else {
    performStatusUpdate(id, status);
    
  }
}




function acknowledgeAppointment(id) {
  Swal.fire({
    title: 'Acknowledging Appointment',
    html: 'Please wait...',
    allowOutsideClick: false,
    showConfirmButton: false,
    onBeforeOpen: () => {
      Swal.showLoading();
    },
  });

  $.ajax({
    url: 'acknowledge_appointment.php',
    type: 'POST',
    data: {
      id: id,
    },
    success: function (response) {
      Swal.close(); // Close the loading indicator

      if (response === 'Acknowledged') {
        statusCell.removeClass().addClass('status-acknowledged');
        $('.status-select[data-id="' + id + '"]').prop('disabled', true);
        Swal.fire('Success', 'Appointment has been acknowledged', 'success');
      } else {
        Swal.fire('Success', 'Appointment has been acknowledged', 'success');
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
      Swal.close(); // Close the loading indicator
      Swal.fire('Success', 'Appointment has been acknowledged', 'success');
    },
  });
}

function performStatusUpdate(id, status) {
  $.ajax({
    url: 'update_status.php',
    type: 'POST',
    data: {
      id: id,
      status: status
    },
    success: function(response) {
      var statusCell = $('#status_' + id);
      statusCell.text(response);
      statusCell.removeClass().addClass('status-' + status.toLowerCase().replace(' ', '-'));

      if (status === 'Did not show') {
        var statusSelect = $('.form-select[data-id="' + id + '"]');
        statusSelect.prop('disabled', true);
        Swal.fire('Success', 'Appointment has been set to Did not Show', 'success');
      } else if (status === 'Completed') {
        Swal.fire('Success', 'Appointment has been set to Completed', 'success');
      }
    }
  });
}
function showRescheduleModal(id) {
$.ajax({
    url: 'get_reschedule.php',
    type: 'POST',
    data: { id: id, secret_key: 'helloimjaycearon' },
    success: function (response) {
        $('#rescheduleModal .modal-body').html(response);
        $('#rescheduleModal').modal('show');
    }
});
}
function showData(id) {
    $.ajax({
        url: 'get_appointment.php',
        type: 'POST',
        data: {id: id, secret_key: 'helloimjaycearon' },
        success: function(response) {
            $('#dataModal .modal-body').html(response);
            $('#dataModal').modal('show');
        }
    });
}
function showCancelledModal(id) {
$.ajax({
    url: 'get_cancelled.php',
    type: 'POST',
    data: { id: id, secret_key: 'helloimjaycearon' },
    success: function (response) {
        $('#cancelledModal .modal-body').html(response);
        $('#cancelledModal').modal('show');
    }
});
}