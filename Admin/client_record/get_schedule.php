<?php
include "../../db_connect/config.php";
$id = $_GET['id'];
$query = "SELECT date, time FROM zp_appointment WHERE client_id = ?";
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
        'title' => $row['time'],
        'start' => $row['date'],
        'time' => $row['time'],
    );
    $events[] = $event;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($events);

?>

