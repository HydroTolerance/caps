<?php
include "../../db_connect/config.php";
$id = $_GET['id'];
$query = "SELECT date_appointment, time_appointment FROM zp_derma_appointment WHERE patient_id = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die('Query Error: ' . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $event = array(
        'title' => $row['time_appointment'],
        'start' => $row['date_appointment'],
        'time' => $row['time_appointment'],
    );
    $events[] = $event;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($events);

?>

