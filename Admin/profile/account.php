<?php
include "../function.php";
checklogin();
$userData = $_SESSION['zep_acc'];
$target_file = ""; // Define a default value for $target_file

if (isset($_POST['edit_submit'])) {
    $userID = $_SESSION['zep_acc']['id'];
    include "../../db_connect/config.php";

    if ($_FILES['image']['name']) {
        if ($_SESSION['zep_acc']['image']) {
            unlink($_SESSION['zep_acc']['image']);
        }
        $target_dir = "../clinic_account/img/";
        $file_name = basename($_FILES["image"]["name"]);
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $unique_filename = uniqid() . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $unique_filename;
        
        if ($_FILES["image"]["size"] > 5000000) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Sorry, your file is too large. Max 5MB allowed.'
                });
                </script>";
            exit();
        }
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Image is updated
            $stmt = mysqli_prepare($conn, "UPDATE zp_accounts SET clinic_firstname=?, clinic_lastname=?, clinic_email=?, clinic_gender=?, clinic_role=?, image=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "ssssssi", $_POST['edit_fname'], $_POST['edit_lname'], $_POST['edit_email'], $_POST['edit_gender'], $_POST['edit_role'], $target_file, $userID);
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Sorry, there was an error uploading your file.'
                });
                </script>";
            exit();
        }
    } else {
        // Image is not updated
        $stmt = mysqli_prepare($conn, "UPDATE zp_accounts SET clinic_firstname=?, clinic_lastname=?, clinic_email=?, clinic_gender=?, clinic_role=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssssi", $_POST['edit_fname'], $_POST['edit_lname'], $_POST['edit_email'], $_POST['edit_gender'], $_POST['edit_role'], $userID);
    }
    if ($stmt->execute()) {
        // Update other fields
        $_SESSION['zep_acc']['clinic_firstname'] = $_POST['edit_fname'];
        $_SESSION['zep_acc']['clinic_lastname'] = $_POST['edit_lname'];
        $_SESSION['zep_acc']['clinic_email'] = $_POST['edit_email'];
        $_SESSION['zep_acc']['clinic_gender'] = $_POST['edit_gender'];
        $_SESSION['zep_acc']['clinic_role'] = $_POST['edit_role'];
        
        // Update the image only if it was uploaded
        if ($_FILES['image']['name']) {
            $_SESSION['zep_acc']['image'] = $target_file; 
        }
        
        echo "<script>
            window.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data added successfully.'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = 'account.php';
                    }
                });
            });
        </script>";
        exit();
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error updating data. Please try again later.'
            });
            </script>";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
</head>
<body>
    <div id="wrapper">
        <?php include "../sidebar.php"; ?>
            <section id="content-wrapper">
            <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Profile Settings</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="image" class="form-label">Current Image:</label>
                                <div class="current-image">
                                    <?php if (!empty($userData['image'])) : ?>
                                        <img src="<?php echo $userData['image']; ?>" alt="Current Image" class="img-fluid">
                                    <?php else : ?>
                                        <p>No Image Available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload New Image (Max 5MB):</label>
                                <input type="file" class="form-control" name="image" accept="image/*" id="image" onchange="previewImage()">
                            </div>
                            <div class="mb-3">
                                <label for="edit_fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="edit_fname" name="edit_fname" value="<?php echo $userData['clinic_firstname']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="edit_lname" name="edit_lname" value="<?php echo $userData['clinic_lastname']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="edit_email" value="<?php echo $userData['clinic_email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_role" class="form-label">Gender</label>
                                <select name="edit_role" id="edit_role" class="form-select" required>
                                    <option selected disabled>-- Select Role --</option>
                                    <option value="Male" <?php echo ($userData['clinic_gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($userData['clinic_gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                            <button type="submit" name="edit_submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
            </section>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function previewImage() {
            const input = document.getElementById('image');
            const currentImageContainer = document.querySelector('.current-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid';
                    currentImageContainer.innerHTML = '';
                    currentImageContainer.appendChild(img);
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                currentImageContainer.innerHTML = '<p>No Image Available</p>';
            }
        }
    </script>
</body>
</html>