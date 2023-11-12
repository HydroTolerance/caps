<?php
include "../../db_connect/config.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_array($result)) {
        $fullName = $row['firstname'] . ' ' . $row['lastname'];
        $formattedDate = date('M d, Y', strtotime($row['date']));
        $output = '
                        <label class="fw-bold">Full Name</label><br>
                        <label>' . $fullName . '</label><br>
                        <hr>
                        <label class="fw-bold">Number</label><br>
                        <label>' . $row['number'] . '</label><br>
                        <hr>
                        <label class="fw-bold">Email</label><br>
                        <label>' . $row['email'] . '</label><br>
                        <hr>
                        <label class="fw-bold">Message</label><br>
                        <label>' . $row['health_concern'] . '</label><br>
                        <hr>
                        <label class="fw-bold">Services</label><br>
                        <label>' . $row['services'] . '</label><br>
                        <hr>
                        <label class="fw-bold">Date</label><br>
                        <label>' . $formattedDate . '</label><br>
                        <hr>
                        <label class="fw-bold">Time</label><br>
                        <label>' . $row['time'] . '</label><br>
                        <hr>
                        <label class="fw-bold">Status</label><br>
                        <label>' . $row['appointment_status'] . '</label><br>
                        <hr>
        ';
    } else {
        $output = "No data found for the provided ID.";
    }

    // Close the database connection
    mysqli_close($conn);

    // Return the generated HTML content
    echo $output;
}
?>
