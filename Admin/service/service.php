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
        <title>Dashboard</title>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
    </head>
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
    $answer = $_POST['description'];

    $sql = "INSERT INTO service (services, description, image) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $service, $answer, $uniqueFilename);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: service.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>
    <div id="wrapper">
    <?php include "../sidebar.php"; ?>
        <section id="content-wrapper">
            <div class="row mx-1">
                <div class="col-lg-12">
                    <div class="mx-3 text-center">
                        <div class="row">
                            <div class="col-xl-3">
                                <button class="create_patients btn text-white ms-3 mb-3 mt-2" style="background-color: #6537AE;" onclick="addServiceModal()">CREATE</button>
                            </div>
                            <div class="col-xl-6">
                                <h1 class=" mb-1" style="color:6537AE;">Services</h1>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="bg-white p-3 rounded-3 border w-100">
                <table id="clientTable" class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Images</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../../db_connect/config.php";
                        $stmt = mysqli_prepare($conn, "SELECT id, services, image, description FROM service");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $id, $services, $image, $description);

                        while (mysqli_stmt_fetch($stmt)) {
                            ?>
                            <tr>
                                <td><?php echo $services; ?></td>
                                <td><img src="../../img/services/<?php echo $image;?>" alt="" width="50px" height="50px"></td>
                                <td><?php echo $description; ?></td>
                                <td class="action-buttons">
                                <button type="button" onclick="showRescheduleModal('<?php echo $id; ?>')" class="btn text-white edit-button" style="background-color: #6537AE;">Edit</button>
                                    <a href="#" onclick="deleteFAQ(<?php echo $id; ?>)" class="text-decoration-none btn btn-outline-purple">Delete</a>
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
                        window.location.href = 'service.php';
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
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