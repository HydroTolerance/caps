<?php
include "../../db_connect/config.php";
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT firstname, lastname, number, email, health_concern, services, date, time, appointment_status FROM zp_appointment WHERE client_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $color = ($row['appointment_status'] === 'Completed') ? '#6537AE' :
    (($row['appointment_status'] === 'Cancelled') ? 'red' :
    (($row['appointment_status'] === 'Rescheduled') ? 'blue' :
    (($row['appointment_status'] === 'Rescheduled') ? 'blue' : 'grey')));

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

mysqli_stmt_close($stmt);
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($events);
}
?>
