<?php
include "../../db_connect/config.php";
$id = $_GET['id'];

// Modify the SQL query to include the 'services' column
$query = "SELECT date, time, services, appointment_status FROM zp_appointment WHERE client_id = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die('Query Error: ' . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

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
    $title =$row['services']  . ' ' . $row['time'];

    $event = array(
        'title' => $title,
        'start' => $row['date'],
        'time' => $row['time'],
        'services' => $row['services'],
        'color' => $color
    );
    $events[] = $event;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($events);
?>
