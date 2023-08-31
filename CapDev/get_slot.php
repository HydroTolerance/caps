<?php
include "../db_connect/config.php";
$d = $_GET['d'];
$query = "SELECT appointment_slots.slots, COUNT(total_bookings.time) AS total_bookings FROM appointment_slots
          LEFT JOIN (
              SELECT time FROM book1 WHERE date = '$d'
              UNION ALL
              SELECT time_appointment AS time FROM zp_derma_appointment WHERE date_appointment = '$d'
          ) AS total_bookings ON appointment_slots.slots = total_bookings.time
          GROUP BY appointment_slots.slots";

$result = mysqli_query($conn, $query);
$slots = array();
while ($row = mysqli_fetch_array($result)) {
    $slot = $row['slots'];
    $total_bookings = $row['total_bookings'];
    $slots[$slot] = $total_bookings;
}

// Fetch the slots_left value from the slots table
$slots_query = "SELECT `slots_left` FROM `slots` WHERE id = 1";
$slots_result = mysqli_query($conn, $slots_query);
$slots_row = mysqli_fetch_assoc($slots_result);
$slots_left_value = $slots_row['slots_left'];

// Add the slots_left value to the response array
$response = array(
    'slots' => $slots,
    'slots_left' => $slots_left_value
);

// Return the response as a JSON-encoded string
echo json_encode($response);
?>
