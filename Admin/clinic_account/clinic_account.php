<?php 
include "../function.php";
checklogin();
$userData = $_SESSION['id'];
?>
<?php
if (isset($_POST['submit'])) {
    include "../../db_connect/config.php";
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $checkEmailQuery = "SELECT COUNT(*) FROM zp_accounts WHERE clinic_email = ?";
    $stmtCheckEmail = mysqli_prepare($conn, $checkEmailQuery);
    mysqli_stmt_bind_param($stmtCheckEmail, "s", $email);
    mysqli_stmt_execute($stmtCheckEmail);
    mysqli_stmt_bind_result($stmtCheckEmail, $emailCount);
    mysqli_stmt_fetch($stmtCheckEmail);
    mysqli_stmt_close($stmtCheckEmail);

    if ($emailCount > 0) {
        echo "<script>
            window.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'The email address already exists in the database.',
                }).then(function() {
                    window.location.href = 'clinic_account.php'; // Redirect to your page
                });
            });
        </script>";
        exit();
    }

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = $_FILES['image'];
        $maxFileSize = 5 * 1024 * 1024;

        if ($image['size'] > $maxFileSize) {
            echo "Error: The uploaded image file exceeds the maximum allowed size of 5MB.";
            exit();
        } else {
            $uploadDir = '../../img/img/';
            $imageFileName = $uploadDir . time() . '_' . uniqid() . '.jpg';
            $imagePath = $imageFileName;

            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                echo "Error: There was an error uploading the image.";
                exit();
            }
        }
    } else {
        $defaultImages = [
            'Derma' => '../../img/avatar/femaleAvatar.png',
            'Staff' => '../../img/avatar/maleAvatar.png',
        ];
        $defaultImage = $defaultImages[$role] ?? 'default_unknown.jpg';
        $imageFileName = $defaultImage;
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
        if (!empty($oldImage) && file_exists('../../img/img/' . $oldImage)) {
            unlink('../../img/img/' . $oldImage);
        }
        $uploadDir = '../../img/img/';
        $imageName = $uploadDir . time() . '_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        
        $imagePath = $imageName;
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Clinic Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-pro@latest/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
</head>
<body>
<div id="wrapper">
            <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
                <div class="row mx-1">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="row">
                                <div class="col-xl-2 mb-3">
                                        <button class="create_patients btn btn-purple bg-purple text-white mb-4 mt-2" onclick="showInsertModal()">CREATE ACCOUNT</button>
                                </div>
                                <div class="col-xl-9">
                                    <h1 class=" mb-1" style="color:6537AE;">Account Settings</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
                    <div class="bg-white p-3 rounded-3 border w-100 mb-1" >
                        <table id="table_clinic" class="table table-striped nowra" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Profile Image</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../../db_connect/config.php";
                                $result = mysqli_query($conn, "SELECT * FROM zp_accounts WHERE clinic_role IN ('Derma', 'Staff');                                ");
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo $row['image']; ?>" alt="User Image" width="100">
                                        </td>
                                        <td><?php echo $row['clinic_firstname'] ?></td>
                                        <td><?php echo $row['clinic_email'] ?></td>
                                        <td><?php echo $row['clinic_role'] ?></td>
                                        <td class="action-buttons">
                                            <div class="add-btn">
                                                <?php
                                                if ($row['account_status'] == 'active') {
                                                    echo '<button onclick="statusAccount(\'' . $row['zep_acc'] . '\', \'deactivate\')" class="btn btn-success bg-success text-white">Active</button>';
                                                } else {
                                                    echo '<button onclick="statusAccount(\'' . $row['zep_acc'] . '\', \'reactivate\')" class="btn btn-danger bg-danger text-white">Deactivated</button>';
                                                }
                                                ?>
                                                <button onclick="showData('<?php echo $row['zep_acc']; ?>')" class="btn btn-purple bg-purple text-white" data-zep-acc="<?php echo $row['zep_acc']; ?>">Edit</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="displayAccount" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataModalLabel">Full Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="insertAccount" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:6537AE" id="insertModalLabel">Create New Account</h5>
                <div class="modal-footer">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Data will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function() {
            $('#clientTable').DataTable({
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                }
            });
        });
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script src="js/clinic.js"></script>
</body>
</html>
