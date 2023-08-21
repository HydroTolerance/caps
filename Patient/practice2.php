<!DOCTYPE html>
<html>
<head>
	<title>Appointment Booking System</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
</head>
<body>
	<h1>Appointment Booking System</h1>
	<form id="appointment-form" method="post" action="book_appointment.php">
		<label for="date">Date:</label>
		<input type="date" name="date" id="date" required><br><br>
		<label for="time">Time:</label>
		<select name="time" id="time" required>
			<option value="">Select a time</option>
			<option value="10:00:00">10:00 AM</option>
			<option value="11:00:00">11:00 AM</option>
			<option value="12:00:00">12:00 PM</option>
		</select><br><br>
		<label for="client_name">Client Name:</label>
		<input type="text" name="client_name" id="client_name" required><br><br>
		<input type="submit" name="submit" value="Book Appointment">
	</form>
	<script>
		function submitForm() {
			var date = $('#date').val();
			var time = $('#time').val();
			var client_name = $('#client_name').val();

			$.ajax({
				type: "POST",
				url: "book_appointment.php",
				data: { date: date, time: time, client_name: client_name },
				success: function(result) {
					if (result == 'success') {
						Swal.fire(
						  'Success',
						  'Your appointment has been booked.',
						  'success'
						).then((result) => {
							if (result.isConfirmed) {
								window.location.reload();
							}
						});
					} else {
						Swal.fire(
						  'Error',
						  result,
						  'error'
						);
					}
				}
			});
		}

		$('#appointment-form').submit(function(event) {
			event.preventDefault();
			var available_slots = <?php echo $available_slots; ?>;
			if (available_slots > 0) {
				$.ajax({
					type: "POST",
					url: "update_appointment.php",
					data: { date: $('#date').val(), time: $('#time').val() },
					success: function(result) {
						if (result == 'success') {
							submitForm();
						} else {
							Swal.fire(
							  'Error',
							  result,
							  'error'
							);
						}
					}
				});
			} else {
				Swal.fire(
				  'Error',
				  'Sorry, no slots available for this date and time.',
				  'error'
				);
			}
		});
	</script>
</body>
</html>