<?php
include "../function.php";
checklogin();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];
    
    $userData = $_SESSION['id'];
    $clinicRole = $userData['clinic_role'];
    
    $accountData = getAccountData($id);

    if ($action === 'deactivate') {
        $actionDescription = "Deactivated account: " . $accountData['clinic_firstname'] . " " . $accountData['clinic_lastname'];
        deactivateAccount($id, $actionDescription);
    } elseif ($action === 'reactivate') {
        $actionDescription = "Reactivated account: " . $accountData['clinic_firstname'] . " " . $accountData['clinic_lastname'];
        reactivateAccount($id, $actionDescription);
    }
}

function deactivateAccount($id, $actionDescription) {
    date_default_timezone_set('Asia/Manila');
    include "../../db_connect/config.php";
    $deactivationTimestamp = date('Y-m-d H:i:s', strtotime('+30 days'));
    $sql = "UPDATE zp_accounts SET account_status = 'deactivated', deactivation_timestamp = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $deactivationTimestamp, $id);
    if (mysqli_stmt_execute($stmt)) {
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

function deleteExpiredAccounts() {
    date_default_timezone_set('Asia/Manila');
    include "../../db_connect/config.php";
    $currentTimestamp = date('Y-m-d H:i:s');

    // Select accounts that have passed the 30-day mark
    $sql = "DELETE FROM zp_accounts WHERE account_status = 'deactivated' AND deactivation_timestamp <= ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $currentTimestamp);
    mysqli_stmt_execute($stmt);

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

    // Set the timezone to Asia/Manila
    $timezone = new DateTimeZone('Asia/Manila');
    $dateTime = new DateTime('now', $timezone);
    $timestamp = $dateTime->format('Y-m-d H:i:s');

    $insertLogQuery = "INSERT INTO activity_log (user_id, name, action_type, role, action_description, timestamp) 
                       VALUES (?, ?, 'Account Activity', ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertLogQuery);
    mysqli_stmt_bind_param($stmt, 'issss', $userData['id'], $userData['clinic_lastname'], $clinicRole, $actionDescription, $timestamp);

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
