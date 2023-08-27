<?php
include "../../db_connect/config.php";
    $events = array();

    $info_sql = "SELECT date_appointment, time_appointment FROM zp_derma_appointment";
    $info_stmt = mysqli_prepare($conn, $info_sql);
    mysqli_stmt_bind_param($info_stmt, "i", $id);
    mysqli_stmt_execute($info_stmt);
    $info_result = mysqli_stmt_get_result($info_stmt);

    while ($info_row = mysqli_fetch_assoc($info_result)) {
        $date_appointment = $info_row['date_appointment'];
        $time_appointment = $info_row['time_appointment'];

        $event = array(
            'title' => 'Appointment',
            'start' => date("Y-m-d H:i:s", strtotime("$date_appointment $time_appointment"))
        );

        $events[] = $event;
    }

    mysqli_stmt_close($info_stmt);
    mysqli_close($conn);

    header('Content-Type: application/json');
    echo json_encode($events);
?>
