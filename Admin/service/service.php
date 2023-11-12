<?php
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>
    
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>Service Module</title>
    </head>
    <style>
        .page-item.active .page-link {
            background-color: #6537AE !important;
            color: #fff !important;
            border: #6537AE;
        }
        .page-link {
            color: black !important;
        }
        th{
        background-color:#6537AE  !important;
        color: #fff  !important;
        text-align: center !important;
        }
    </style>
    <body>
    <?php 
if (isset($_POST['submit'])) {
    include "../../db_connect/config.php";
    if (isset($_FILES['image'])) {
        $uploadDir = "../../img/services/";
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uniqueFilename = uniqid() . '.' . $fileExtension;
        $uploadedFile = $uploadDir . $uniqueFilename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
        } else {
            echo "Error uploading the image.";
        }
    }
    $service = $_POST['services'];
    $name = $_POST['name'];
    $answer = $_POST['description'];
    $sql = "INSERT INTO service (services, description, name, image) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $service, $answer, $name, $uniqueFilename);
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Services updated successfully!",
        }).then(function() {
            window.location.href = "service.php"; // Redirect after the user clicks OK
        });
        </script>';
        exit();
    }
    else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>
<?php
include "../../db_connect/config.php";

if (isset($_POST['edit_submit'])) {
    $id = $_POST['id'];
    $service = $_POST['services'];
    $description = $_POST['description'];
    $name = $_POST['name'];
    $newImageUploaded = false;

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $newImageUploaded = true;
        $uploadedFile = $_FILES['image'];
        $uploadDir = "../../img/services/";
        $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        $uniqueFilename = uniqid() . '.' . $fileExtension;
        $newImageFilePath = $uploadDir . $uniqueFilename;

        if (move_uploaded_file($uploadedFile['tmp_name'], $newImageFilePath)) {
            // Delete the old image if it exists
            $selectQuery = "SELECT image FROM service WHERE id=?";
            $selectStmt = mysqli_prepare($conn, $selectQuery);
            mysqli_stmt_bind_param($selectStmt, "i", $id);
            mysqli_stmt_execute($selectStmt);
            $result = mysqli_stmt_get_result($selectStmt);
            $row = mysqli_fetch_assoc($result);

            if (!empty($row['image']) && file_exists($uploadDir . $row['image'])) {
                unlink($uploadDir . $row['image']);
            }

            // Update with the new image
            $sql = "UPDATE service SET services=?, description=?, name=?, image=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $service, $description, $name, $uniqueFilename, $id);
        } else {
            echo "Error uploading the new image.";
            exit;
        }
    } else {
        // Update without a new image
        $sql = "UPDATE service SET services=?, description=?, name=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $service, $description, $name, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Service updated successfully!",
        }).then(function() {
            window.location.href = "service.php"; // Redirect after the user clicks OK
        });
        </script>';
        exit();
    } else {
        echo "Error Updating: " . mysqli_error($conn);
    }
}
?>


    <div id="wrapper">
    <?php include "../sidebar.php"; ?>
        <section id="content-wrapper">
        <div class="row">
                    <div class="bg-white py-3 mb-3 border border-bottom">
                        <div class="d-flex justify-content-between mx-4">
                            <div>
                                <h2 style="color:6537AE;" class="fw-bold">SERVICES</h2>
                            </div>
                            <div class="align-items-center">
                                <a class="btn text-white" style="background-color:#6537AE;" onclick="addServiceModal()">CREATE</a>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-12">
                </div>
                    <div class="col-lg-12">
            <div class="bg-white p-3 rounded-3 border mx-3">
                <table id="clientTable" class="table table-bordered text-center" style="width: 100%;">
                    <thead>
                        <tr>
                            
                            <th>Images</th>
                            <th>Service Type</th>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../../db_connect/config.php";
                        $stmt = mysqli_prepare($conn, "SELECT id, services, name, image, description FROM service");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $id, $services, $name, $image, $description);
                        while (mysqli_stmt_fetch($stmt)) {
                            ?>
                            <tr>
                                <td><img src="../../img/services/<?php echo $image;?>" alt="" width="50px" height="50px"></td>
                                <td><?php echo $services; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $description; ?></td>
                                <td class="action-buttons">
                                <button type="button" onclick="showRescheduleModal('<?php echo $id; ?>')" class="btn text-white edit-button" style="background-color: #6537AE;">Edit</button>
                                <a href="#" onclick="deleteFAQ(<?php echo $id; ?>)" class="text-decoration-none btn" style="  border-color: purple; color: purple;">Delete</a>
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
<!-- Modal Edit -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rescheduleModalLabel">Edit Services Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Reschedule form will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rescheduleModalLabel">Add Services Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Reschedule form will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.js"></script>
<script> $(document).ready(function() {
    $('#clientTable').DataTable({
        responsive: true,
            "ordering": false,
    });
});


    function showRescheduleModal(id) {
        $.ajax({
            url: 'edit_service.php',
            type: 'GET',
            data: { id: id },
            success: function (response) {
                $('#rescheduleModal .modal-body').html(response);
                var myModal = new bootstrap.Modal(document.getElementById('rescheduleModal'));
                myModal.show();
            }
        });
    };
    function addServiceModal(id) {
        $.ajax({
            url: 'add_service.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                $('#addFaqModal .modal-body').html(response);
                var myModal = new bootstrap.Modal(document.getElementById('addFaqModal'));
                myModal.show();
            }
        });
    };
    function deleteFAQ(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete_service.php',
                type: 'GET',
                data: { id: id },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted Successfully',
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "service.php";
                    });
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    // Show an error alert using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error deleting FAQ: ' + xhr.responseText,
                    });
                }
            });
        }
    });

        return false;
    }
</script>
    </body>
</html>