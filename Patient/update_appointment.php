<?php
// Get the form data
$date = $_POST['date'];
$time = $_POST['time'];

include "../db_connect/config.php";

// Check if the selected date and time has already been booked by three clients
$query = "SELECT COUNT(*) AS count FROM appointments3 WHERE date = '$date' AND time = '$time'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
if ($count >= 3) {
	echo "Sorry, no slots available for this date and time.";
	exit();
}

mysqli_close($conn);
echo "success";