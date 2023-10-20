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
    $color = ($row['appointment_status'] === 'Completed') ? '#6537AE' :
    (($row['appointment_status'] === 'Cancelled') ? 'red' :
    (($row['appointment_status'] === 'Rescheduled') ? 'blue' :
    (($row['appointment_status'] === 'Did not show') ? 'orange' :
    (($row['appointment_status'] === 'Acknowledged') ? 'Yellow' : 'grey'))));

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
