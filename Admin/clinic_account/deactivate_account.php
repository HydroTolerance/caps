<?php
include "../function.php";
checklogin();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $action = $_POST['action']; // Action will be either 'deactivate' or 'reactivate'
    
    $userData = $_SESSION['id'];
    $clinicRole = $userData['clinic_role'];
    
    $accountData = getAccountData($id); // Retrieve account data, e.g., first name and last name

    if ($action === 'deactivate') {
        $actionDescription = "Deactivated account: " . $accountData['clinic_firstname'] . " " . $accountData['clinic_lastname'];
        deactivateAccount($id, $actionDescription);
    } elseif ($action === 'reactivate') {
        $actionDescription = "Reactivated account: " . $accountData['clinic_firstname'] . " " . $accountData['clinic_lastname'];
        reactivateAccount($id, $actionDescription);
    }
}

function deactivateAccount($id, $actionDescription) {
    include "../../db_connect/config.php";
    $sql = "UPDATE zp_accounts SET account_status = 'deactivated' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        // Log the deactivation action
        logActivity($actionDescription);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: clinic_account.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function reactivateAccount($id, $actionDescription) {
    include "../../db_connect/config.php";
    $sql = "UPDATE zp_accounts SET account_status = 'active' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        // Log the reactivation action
        logActivity($actionDescription);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: clinic_account.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function logActivity($actionDescription) {
    // Insert the activity log into the database
    include "../../db_connect/config.php";
    $userData = $_SESSION['id'];
    $clinicRole = $userData['clinic_role'];
    
    $insertLogQuery = "INSERT INTO activity_log (user_id, action_type, role, action_description) 
                       VALUES (?, 'Account Activity', ?, ?)";
    $stmt = mysqli_prepare($conn, $insertLogQuery);
    mysqli_stmt_bind_param($stmt, 'iss', $userData['id'], $clinicRole, $actionDescription);

    if (mysqli_stmt_execute($stmt)) {
        // Log successfully added
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getAccountData($id) {
    include "../../db_connect/config.php";
    $sql = "SELECT clinic_firstname, clinic_lastname FROM zp_accounts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $firstName, $lastName);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return ['clinic_firstname' => $firstName, 'clinic_lastname' => $lastName];
}
?>
