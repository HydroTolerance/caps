

function updateStatus(id, status) {
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
  }
});
}else if (status === 'Did not show'){
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
        acknowledgeAppointment(id)
      }
  });
} else if (status === 'Rescheduled') {
showRescheduleModal(id);
} else if (status === 'Cancelled') {
showCancelledModal(id);
} 
else {
performStatusUpdate(id, status);
}
}
function acknowledgeAppointment(id) {
  $.ajax({
    url: 'acknowledge_appointment.php', // Replace with your PHP script for acknowledgment
    type: 'POST',
    data: {
      id: id,
    },
    success: function (response) {
      if (response === 'Acknowledged') {
        var statusCell = $('#status_' + id);
        statusCell.text('Acknowledged');
        statusCell.removeClass().addClass('status-acknowledged');
        $('.status-select[data-id="' + id + '"]').prop('disabled', true);
      } else {
        Swal.fire('Success', 'Appointment has been acknowledged', 'success');;
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
      Swal.fire('Error', 'Failed to acknowledge appointment', 'error');
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
    var toastrMessage = 'Appointment status is now ' + status + '!';
    toastr.success(toastrMessage, '', {
      progressBar: true,
      timeOut: 3000,
      positionClass: 'toast-top-right'
    });
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