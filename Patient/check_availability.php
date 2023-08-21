<?php
// Connect to database
include "../db_connect/config.php";

// Check if datetime is fully booked
$datetime = $_POST["datetime"];
$sql = "SELECT COUNT(*) AS count FROM appointments WHERE datetime = '$datetime'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row["count"] >= 3) {
    echo "full";
} else {
    echo "available";
}

$conn->close();
?>