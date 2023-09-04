<?php
include "../../db_connect/config.php";
$d = $_GET['d'];
$slots_query = "SELECT slots_left FROM slots WHERE id = 1";
$slots_result = mysqli_query($conn, $slots_query);
$slots_row = mysqli_fetch_assoc($slots_result);
$slots_left_value = $slots_row['slots_left'];
$query = "SELECT appointment_slots.slots,
            ($slots_left_value - 
             IFNULL(bookings_and_appointments.num_bookings, 0)) AS available_slots
          FROM appointment_slots
          LEFT JOIN (
            SELECT time,
                   COUNT(*) AS num_bookings
            FROM (
              SELECT time
              FROM book1
              WHERE date = '$d'
              UNION ALL
              SELECT time_appointment
              FROM zp_derma_appointment
              WHERE date_appointment = '$d'
            ) AS all_bookings_and_appointments
            GROUP BY time
          ) AS bookings_and_appointments
          ON appointment_slots.slots = bookings_and_appointments.time";

$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $slot = $row['slots'];
    $total_num_bookings = $row['available_slots'];

    $available_slots_for_slot = $slots_left_value - $total_num_bookings;
    if ($available_slots_for_slot < 0) {
        $available_slots_for_slot = 0;
    }
    $slots[$slot] = $available_slots_for_slot;
}
$response = [
    'slots' => $slots,
    'slots_left' => $slots_left_value
];
echo json_encode($response);
?>