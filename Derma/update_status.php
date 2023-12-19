<?php
$id = $_POST['id'];
$status = $_POST['status'];
include "../db_connect/config.php";
$sql = "UPDATE book1 SET appointment_status = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $status, $id);
if (mysqli_stmt_execute($stmt)) {
    echo $status;
} else {
    echo "Error updating status.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>