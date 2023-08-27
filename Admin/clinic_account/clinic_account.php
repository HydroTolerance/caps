<?php 
include "../function.php";

checklogin();
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
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include "../sidebar.php"; ?>
        <div class="col main-content custom-navbar bg-light">
            <?php include "../navbar.php"?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="fs-3 mt-3 mb-4">Clinic Account</h1>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="showInsertModal()">Insert</button>
            <div class="container">
                <div class="row">
                    <div class="bg-white p-3 rounded-3 border w-100">
                        <table id="table_clinic" class="table table-striped nowra" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../../db_connect/config.php";
                                $result = mysqli_query($conn, "SELECT * FROM zp_accounts");
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['zep_acc'] ?></td>
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
                <h5 class="modal-title" id="insertModalLabel">Insert New Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
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
