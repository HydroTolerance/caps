<?php
include "../../db_connect/config.php";

$query = "
    SELECT firstname, lastname, number, email, health_concern, services, date, time, appointment_status FROM zp_appointment";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $appointmentStatus = $row['appointment_status'];
    $color = ($appointmentStatus === 'Completed') ? '#28a745' :
         (($appointmentStatus === 'Cancelled') ? 'red' :
         (($appointmentStatus === 'Did not show') ? 'orange' :
         (($appointmentStatus === 'Acknowledged') ? '#6537AE' :
         (strpos($appointmentStatus, 'Rescheduled (Admin)') !== false ? '#3B71CA' :
         (strpos($appointmentStatus, 'Rescheduled (Derma)') !== false ? '#3B71CA' :
         (strpos($appointmentStatus, 'Rescheduled (Client)') !== false ? '#3B71CA' : 'grey'))))));

    $event = array(
        'title' => $row['firstname'] . ' ' . $row['lastname'],
        'start' => $row['date'],
        'time' => $row['time'],
        'name' => $row['firstname'] . ' ' . $row['lastname'],
        'number' => $row['number'],
        'email' => $row['email'],
        'healthConcern' => $row['health_concern'],
        'services' => $row['services'],
        'date' => date('M d, Y', strtotime($row['date'])),
        'color' => $color
    );
    $events[] = $event;
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($events);
?>
