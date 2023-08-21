<?php
include "../db_connect/config.php";

$bookingTime = mysqli_real_escape_string($conn, $_GET['booking_time']);
$bookingDate = mysqli_real_escape_string($conn, $_GET['booking_date']);
$sql = "SELECT COUNT(*) AS num_bookings FROM bookings WHERE booking_time = '$bookingTime' AND booking_date = '$bookingDate'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$numBookings = $row['num_bookings'];
$conn->close();

echo $numBookings >= 3 ? 'true' : 'false';
?>