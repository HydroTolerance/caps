<?php
include "../function.php";
checklogin();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $action = $_POST['action']; // Action will be either 'deactivate' or 'reactivate'
    
    if ($action === 'deactivate') {
        deactivateAccount($id);
    } elseif ($action === 'reactivate') {
        reactivateAccount($id);
    }
}

function deactivateAccount($id) {
    include "../../db_connect/config.php";
    $sql = "UPDATE zp_accounts SET account_status = 'deactivated' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
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

function reactivateAccount($id) {
    include "../../db_connect/config.php";
    $sql = "UPDATE zp_accounts SET account_status = 'active' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
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
?>