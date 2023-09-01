<?php
// process_date.php

// Perform your MySQL query to fetch the data for the specific date
include "../db_connect/config.php";

// Fetch the events (bookings) data
$query = "SELECT firstname, date as start FROM book1";
$result = mysqli_query($conn, $query);

$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $event = array(
        'title' => $row['firstname'],
        'start' => $row['start']
    );
    $events[] = $event;
}

echo json_encode($events);

mysqli_close($conn);  
?>
