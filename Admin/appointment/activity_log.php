<?php
include "../function.php";
session_start();  // Start or resume the session
$userData = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointmentId'];
    $newStatus = $_POST['newStatus'];

    if ($userData) {
        include "../../db_connect/config.php";
        $actionDescription = "Appointment status updated to: " . $newStatus;
        $clinicRole = $userData['clinic_role'];
        $insertLogQuery = "INSERT INTO activity_log (user_id, action_type, role, action_description) 
                           VALUES (?, 'Appointment Status Update', ?, ?) ";
        $stmt = mysqli_prepare($conn, $insertLogQuery);
        mysqli_stmt_bind_param($stmt, 'iss', $userData['id'], $clinicRole, $actionDescription);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo json_encode(['success' => false, 'error' => 'User data not found']);
    }
}
?>
