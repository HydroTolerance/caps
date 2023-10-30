<?php 
include "../function.php";
checklogin('Staff');
$userData = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
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
</style>
<body>
        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
                <section id="content-wrapper">
                    <div class="row mx-1">
                        <div class="col-lg-12">
                            <div class="mx-3 text-center">
                                <div class="row">
                                    <div class="col-xl-3">
                                    </div>
                                    <div class="col-xl-6">
                                        <h1 class=" mb-1" style="color:6537AE;">Client Record</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div>
                    <div class="bg-white p-3 rounded-3 border w-100">
                        <table id="clientTable" class="table table-bordered  table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Day of Birth</th>
                                    <th>Contact Number</th>
                                    <th>Email Address</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../../db_connect/config.php";
                                $stmt = mysqli_prepare($conn, "SELECT * FROM zp_client_record");
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>

                                    <tr>
                                        <td><?php echo $row['client_firstname']?></td>
                                        <td><?php echo $row['client_lastname']?></td>
                                        <td><?php echo $row['client_birthday']?></td>
                                        <td><?php echo $row['client_number']?></td>
                                        <td><?php echo $row['client_email']?></td>
                                        <td class="action-buttons">
                                            <a href="view.php?id=<?php echo $row['id']?>" class="btn bg-purple text-white"> View</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var table = $('#clientTable').DataTable({
                responsive: true,
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                fixedColumns: true,
                select: true,
            });
        });
    </script>
</body>
</html>
