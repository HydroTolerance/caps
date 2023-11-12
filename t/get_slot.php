<?php
include "../db_connect/config.php";
$d = $_GET['d'];
$query = "SELECT appointment_slots.slots, COUNT(zp_appointment.time) AS total_bookings
          FROM appointment_slots
          LEFT JOIN (
              SELECT time
              FROM zp_appointment
              WHERE date = '$d'
              AND appointment_status IN ('rescheduled', 'completed', 'pending', 'acknowledged')
              AND appointment_status NOT IN ('Cancelled', 'did not show')
          ) AS zp_appointment
          ON appointment_slots.slots = zp_appointment.time
          GROUP BY appointment_slots.slots";



$result = mysqli_query($conn, $query);
$slots = array();
while ($row = mysqli_fetch_array($result)) {
    $slot = $row['slots'];
    $total_bookings = $row['total_bookings'];
    $slots[$slot] = $total_bookings;
}
$slots_query = "SELECT `slots_left` FROM `slots` WHERE id = 1";
$slots_result = mysqli_query($conn, $slots_query);
$slots_row = mysqli_fetch_assoc($slots_result);
$slots_left_value = $slots_row['slots_left'];
$response = array(
    'slots' => $slots,
    'slots_left' => $slots_left_value
);
echo json_encode($response);
?>
