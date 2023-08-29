<?php
include "../../db_connect/config.php";

$query = "
    SELECT 
        firstname, 
        lastname, 
        number, 
        email, 
        health_concern, 
        services, 
        date, 
        time, 
        appointment_status 
    FROM 
        book1
    UNION ALL
    SELECT 
        name_appointment AS firstname, 
        '', 
        '', 
        '', 
        '', 
        services_appointment AS services, 
        date_appointment AS date, 
        time_appointment AS time, 
        '' AS appointment_status 
    FROM 
        zp_derma_appointment 
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    if (!empty($row['firstname'])) {
        $color = ($row['appointment_status'] === 'Approved') ? '#228B22' : '#21A5B7';
        $name = $row['firstname'] . ' ' . $row['lastname'];
    } else {
        $color = '#FF5733'; // Specify color for derma appointments
        $name = $row['name_appointment'];
    }

    $event = array(
        'title' => $name,
        'start' => $row['date'],
        'time' => $row['time'],
        'name' => $name,
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

// Encode the combined events array as JSON
header('Content-Type: application/json');
echo json_encode($events);
?>
