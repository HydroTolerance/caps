<?php
include "../../db_connect/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $success = true;
    foreach ($_POST['availability'] as $id => $value) {
        $sql = "UPDATE availability SET is_available = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $value, $id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }            
        }
    }
}
