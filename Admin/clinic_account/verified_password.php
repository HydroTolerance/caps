<?php
session_start();

$correctAdminPassword = $_SESSION['clinic_password'];
$requestPayload = file_get_contents('php://input');
$requestData = json_decode($requestPayload);

if ($requestData && isset($requestData->adminPassword)) {
    $adminPassword = $requestData->adminPassword;
    if ($adminPassword === $correctAdminPassword) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect admin password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
