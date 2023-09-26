
<?php
if (isset($_POST['submit'])) {
    include "../../db_connect/config.php";
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $maxFileSize = 5 * 1024 * 1024;
        if ($image['size'] > $maxFileSize) {
            echo "Error: The uploaded image file exceeds the maximum allowed size of 5MB.";
            exit();
        }else {
            // No image uploaded, generate a default image based on the role
            $defaultImages = [
                'Derma' => 'avatar/femaleAvatar.png',
                'Staff' => 'avatar/maleAvatar.png',
                // Add more role-image mappings as needed
            ];
    
            // Set a default image based on the provided role
            $defaultImage = $defaultImages[$role] ?? 'default_unknown.jpg';
    
            // Copy the default image to the upload directory
            $uploadDir = 'img/';
            $imageFileName = time() . '_' . uniqid() . '.jpg'; // Change the extension to JPG or the desired format
            $imagePath = $uploadDir . $imageFileName;
    
            if (copy($defaultImage, $imagePath)) {
                // Default image copied successfully
            } else {
                echo "Error: There was an error generating the default image.";
                exit();
            }
        }
    }
    $password = password_hash($password, PASSWORD_DEFAULT);

    $account_id = generateAccountID();

    $sql = "INSERT INTO zp_accounts (zep_acc, clinic_firstname, clinic_lastname, clinic_email, clinic_gender, image, clinic_password, clinic_role, account_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $account_id, $fname,  $lname, $email, $gender, $imageFileName, $password, $role);
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
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $getOldImageSql = "SELECT image FROM zp_accounts WHERE zep_acc=?";
        $getOldImageStmt = mysqli_prepare($conn, $getOldImageSql);
        mysqli_stmt_bind_param($getOldImageStmt, "s", $edit_id);
        mysqli_stmt_execute($getOldImageStmt);
        mysqli_stmt_bind_result($getOldImageStmt, $oldImage);
        mysqli_stmt_fetch($getOldImageStmt);
        mysqli_stmt_close($getOldImageStmt);
        if (!empty($oldImage) && file_exists('img/' . $oldImage)) {
            unlink('img/' . $oldImage);
        }

        $imageName = time() . '_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadDir = 'img/';
        $imagePath = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $sql = "UPDATE zp_accounts SET clinic_firstname=?, clinic_lastname=?, clinic_email=?, clinic_role=?, image=?";
            $sql .= " WHERE zep_acc=?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $edit_fname, $edit_lname, $edit_email, $edit_role, $imageName, $edit_id);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header("Location: clinic_account.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: There was an error uploading the image.";
        }
    } else {
        $sql = "UPDATE zp_accounts SET clinic_firstname=?, clinic_lastname=?, clinic_email=?, clinic_role=?";
        $sql .= " WHERE zep_acc=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $edit_fname, $edit_lname, $edit_email, $edit_role, $edit_id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: clinic_account.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
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