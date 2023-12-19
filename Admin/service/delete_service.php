<?php
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>

<?php
if (isset($_GET['id'])) {
    include "../../db_connect/config.php";
    $id = $_GET['id'];

    // Fetch information about the service being deleted for the activity log
    $selectQuery = "SELECT services, name, image FROM service WHERE id=?";
    $selectStmt = mysqli_prepare($conn, $selectQuery);
    mysqli_stmt_bind_param($selectStmt, "i", $id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $serviceName = $row['services'];
        $serviceName .= !empty($row['name']) ? ' - ' . $row['name'] : '';
        
        // Unlink the associated image
        $imagePath = "../../img/services/" . $row['image'];
        if (!empty($row['image']) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the service
        $deleteQuery = "DELETE FROM service WHERE id=?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $id);

        if (mysqli_stmt_execute($deleteStmt)) {
            // Add activity log entry
            logActivity($conn, $userData['id'], $userData['clinic_lastname'], 'Delete Service', $userData['clinic_role'], 'Deleted service: ' . $serviceName);
            mysqli_stmt_close($deleteStmt);
            mysqli_close($conn);
            echo "Service deleted successfully.";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Service not found.";
    }
} else {
    echo "Invalid request.";
}

function logActivity($conn, $userId, $name, $actionType, $role, $actionDescription) {
    $sql = "INSERT INTO activity_log (user_id, name, action_type, role, action_description) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'issss', $userId, $name, $actionType, $role, $actionDescription);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
    }
}
?>
