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
    <title>FAQ Module</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Include Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
    </style>
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
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .status-cancelled {
    color: red !important;
}
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
}
    </style>
</head>
<body>
<?php
include "../../db_connect/config.php";
if (isset($_POST['submit'])) {

    $question =$_POST['question'];
    $answer = $_POST['answer'];
    $sql = "INSERT INTO faq (question, answer) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $question, $answer);
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "Added FAQ successfully!",
        }).then(function() {
            window.location.href = "faq.php"; // Redirect after user clicks OK
        });
    </script>';
    exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

include "../../db_connect/config.php";
if (isset($_POST['edit_submit'])) {
    $id = $_POST['id']; // Get the id from the form
    $question = $_POST['edit_question'];
    $answer = $_POST['edit_answer'];

    $sql = "UPDATE faq SET question=?, answer=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $question, $answer, $id);
    if(mysqli_stmt_execute($stmt)){
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "FAQ updated successfully!",
        }).then(function() {
            window.location.href = "faq.php"; // Redirect after user clicks OK
        });
    </script>';
    exit();
    }
    else {
        echo "Error Updating Error: " . mysqli_error($conn);
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
                                <h2 style="color:6537AE;" class="fw-bold">FAQ's</h2>
                            </div>
                            <div class="align-items-center">
                                <a class="btn bg-purple text-white" onclick="addFaqModal()">CREATE</a>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-12">

                </div>
                    <div class="col-lg-12">
            <div class="bg-white p-3 rounded-3 border mx-3">
                <table id="faqTable" class="table table-bordered text-center" style="width: 100%;">
                    <thead>
                    <tr>
                        <th class="text-center">Question</th>
                        <th  class="text-center">Answer</th>
                        <th  class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include "../../db_connect/config.php";
                    $result = mysqli_query($conn, "SELECT * FROM faq");
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['question'] ?></td>
                            <td><?php echo strlen($row['answer']) > 50 ? substr($row['answer'], 0, 50) . '...' : $row['answer']; ?></td>
                            <td class="action-buttons">
                                <button onclick="showRescheduleModal('<?php echo $row['id']; ?>')" class="btn btn-purple bg-purple text-white">Edit</button>
                                <a href="#" onclick="deleteFAQ(<?php echo $row['id']; ?>)" class="btn-outline-purple text-decoration-none btn" >Delete</a>
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
                <h5 class="modal-title" id="rescheduleModalLabel">Edit FAQ Entry</h5>
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
                <h5 class="modal-title" id="rescheduleModalLabel">Add FAQ Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add FAQ form will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#faqTable').DataTable({
            responsive: true,
            "ordering": false,
        });
    });

    function showRescheduleModal(id) {
        $.ajax({
            url: 'edit_faq.php',
            type: 'GET',
            data: { id: id },
            success: function (response) {
                $('#rescheduleModal .modal-body').html(response);
                $('#rescheduleModal').modal('show');
            }
        });
    }
    function addFaqModal(id) {
        $.ajax({
            url: 'add_faq.php',
            type: 'POST',
            data: { id: id },
            success: function (response) {
                $('#addFaqModal .modal-body').html(response);
                $('#addFaqModal').modal('show');
            }
        });
    }
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
                url: 'delete_faq.php',
                type: 'GET',
                data: { id: id },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted Successfully',
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "faq.php";
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

    // Prevent the default behavior of the link
    return false;
}

</script>

</script>

</body>
</html>
