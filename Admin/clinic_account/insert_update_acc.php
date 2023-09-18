
<?php
if (isset($_POST['submit'])) {
    include "../../db_connect/config.php";
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $maxFileSize = 5 * 1024 * 1024;
        if ($image['size'] > $maxFileSize) {
            echo "Error: The uploaded image file exceeds the maximum allowed size of 5MB.";
            exit();
        }

        $allowedTypes = ['jpeg', 'jpg', 'png'];
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedTypes)) {
            echo "Error: Invalid image format. Supported formats: JPEG, JPG, PNG, GIF.";
            exit();
        }
        $imageFileName = time() . '_' . uniqid() . '.' . $fileExtension;
        $uploadDir = './img';
        $imagePath = $uploadDir . $imageFileName;
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        } else {
            echo "Error: There was an error uploading the image.";
            exit();
        }
    }
    $password = password_hash($password, PASSWORD_DEFAULT);

    $account_id = generateAccountID();

    $sql = "INSERT INTO zp_accounts (zep_acc, clinic_firstname, clinic_lastname, clinic_email, image, clinic_password, clinic_role, account_status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $account_id, $fname,  $lname, $email, $imageFileName, $password, $role);
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

if (isset($_POST['edit_submit'])) {
    include "../../db_connect/config.php";
    $edit_id = $_POST['edit_id'];
    $edit_fname = $_POST['edit_fname'];
    $edit_lname = $_POST['edit_lname'];
    $edit_email = $_POST['edit_email'];
    $edit_role = $_POST['edit_role'];
    if (!empty($_POST['edit_password'])) {
        $edit_password = password_hash($_POST['edit_password'], PASSWORD_DEFAULT);
    }

    $sql = "UPDATE zp_accounts SET clinic_firstname=?, clinic_lastname=?, clinic_password=?, clinic_email=?, clinic_role=?";
    if (!empty($edit_password)) {
        $sql .= ", clinic_password=?";
    }
    $sql .= " WHERE zep_acc=?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($edit_password)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $edit_fname, $edit_lname, $edit_email, $edit_role, $edit_password, $edit_id);
    } else {
        mysqli_stmt_bind_param($stmt, "sssss", $edit_fname, $edit_lname, $edit_email, $edit_role, $edit_id);
    }

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


function generateAccountID() {
    include "../../db_connect/config.php";
    $sql = "SELECT MAX(SUBSTRING_INDEX(zep_acc, '-', -1)) AS max_counter FROM zp_accounts";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $max_counter = intval($row['max_counter']);
    $accountID = 'clinic_account-' . str_pad($max_counter + 1, 3, '0', STR_PAD_LEFT);
    return $accountID;
}

function deactivateAccount($zep_acc) {
    include "../../db_connect/config.php";
    $sql = "UPDATE zp_accounts SET account_status = 'deactivated' WHERE zep_acc = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $zep_acc);

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