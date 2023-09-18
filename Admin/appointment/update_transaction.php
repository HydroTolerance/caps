<?php
include "../../db_connect/config.php";

if (isset($_POST['id']) && isset($_POST['transaction'])) {
    $id = $_POST['id'];
    $transaction = $_POST['transaction'];
    $query = "UPDATE zp_appointment SET appointment_transaction = 'Completed' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo $transaction;
    } else {
        echo 'Error updating appointment status: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request';
}
?>