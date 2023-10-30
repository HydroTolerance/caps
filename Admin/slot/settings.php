<?php
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Availability</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

<?php
include "../../db_connect/config.php";
$sql = "SELECT id, day, is_available FROM availability";
$result = $conn->query($sql);
$availabilityData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $availabilityData[] = $row;
    }
}
if(isset($_POST['submit'])){
    $disable = $_POST['day_to_disable'];
    $stmt = mysqli_prepare($conn, "INSERT INTO disabled_days (day_to_disable) VALUE (?)");
    mysqli_stmt_bind_param($stmt, "s" , $disable);
    if(mysqli_stmt_execute($stmt)){
        header("location:settings.php");
        exit();
    }else {
        echo "Error: " . mysqli_error($conn);
    }
}


?>
<div id="wrapper">
    <?php include "../sidebar.php"; ?>
    <section id="content-wrapper">
        <div class="row mx-1">
        <div class="container mt-4">
            <button class="btn bg-purple mb-3 text-white" onclick="DisableDaysModal();">Create</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Days Disable</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                        include "../../db_connect/config.php";
                        $stmt = mysqli_prepare($conn,'SELECT id, day_to_disable FROM disabled_days');
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $id, $days);
                        while(mysqli_stmt_fetch($stmt)) {
                        ?>
                        <tr>
                        <td><?= $days ?></td>
                        <td>
                            <button class="btn bg-purple text-white" type="submit" name="update_data">Update</button>
                            <a href="#" onclick="deleteDays(<?php echo $id;?>)" class="btn btn-outline-purple" type="submit" name="update_data" va>Delete</a>
                        </td>
                        </tr>
                        <?php
                            }
                        ?>
                    
                </tbody>
            </table>
            </div>
            <div class="container mt-4">
                <h2>Changing Working Open Days</h2>
                <form method="POST" id="updateForm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Is Available</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($availabilityData as $data) { ?>
                                <tr>
                                    <td><?php echo $data['day']; ?></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="availability[<?php echo $data['id']; ?>]" value="1" <?php echo ($data['is_available'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="availability[<?php echo $data['id']; ?>]" value="0" <?php echo ($data['is_available'] == 0) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">No</label>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update" id="updateButton" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="DisableDaysModal" tabindex="-1" aria-labelledby="DisableDaysModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DisableDaysModalLabel">Add Specific Day to Disable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- create form will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('updateForm').addEventListener('submit', function (event) {
    event.preventDefault();
    Swal.fire({
        title: 'Confirm Update',
        text: 'Are you sure you want to update this data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            const form = event.target;
            const formData = new FormData(form);

            fetch('update_availability.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data Updated successfully.'
                    }).then(function() {
                        window.location.href = 'settings.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update data.'
                    });
                }
            });
        }
    });
});
function DisableDaysModal(id) {
        $.ajax({
            url: 'add_disable.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                $('#DisableDaysModal .modal-body').html(response);
                $('#DisableDaysModal').modal('show');
            }
        });
    }
    function deleteDays(id) {
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
                    url: 'delete_days.php',
                    type: 'GET',
                    data: { id: id },
                    success: function (response) {
                        window.location.href = 'settings.php';
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

        // Prevent the default behavior of the link
        return false;
    }

</script>

</body>
</html>
