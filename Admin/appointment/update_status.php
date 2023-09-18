<?php
include "../../db_connect/config.php";

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $query = "UPDATE zp_appointment SET appointment_status = 'Completed' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);
 
    if ($result) {
        echo $status;
    } else {
        echo 'Error updating appointment status: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request';
}
?>


