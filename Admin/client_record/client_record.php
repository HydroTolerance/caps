<?php 
include "../function.php";
checklogin('Admin');
$userData = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Record</title>
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
body {
    padding-right: 0 !important;
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
.top-height {
    margin-top: 23px;
    height: -10px;
  }
</style>
<body>
<div id="content-container"></div>

        <div id="wrapper">
            <?php include "../sidebar.php"; ?>
                <section id="content-wrapper">
                    <div class="bg-white py-3 mb-3 border border-bottom">
                        <div class="d-flex justify-content-between mx-4">
                            <div>
                                <h2 style="color:6537AE;" class="fw-bold">CLIENT RECORD</h2>
                            </div>
                            <div class="align-items-center">
                                <a href="add_client_record.php" class="btn bg-purple text-white">CREATE</a>
                            </div>
                        </div>
                    </div>
                    <div class=" px-3">
                    <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Client Records</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Archived Client Records</button>
                </div>
                </nav>
                <div class="bg-white p-3">

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <div class="table-responsive">
                        <div class="col-md-3">
                            <label for="yearFilter">Filter by Year:</label>
                            <select id="yearFilter" class="form-select form-select-sm">
                                <option value="">All Years</option>
                                <?php
                                $query = "SELECT DISTINCT YEAR(date_diagnosis) AS year FROM zp_derma_record ORDER BY year DESC";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $year = $row['year'];
                                    echo '<option value="' . $year . '">' . $year . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <table id="archiveTable" class="table table-bordered table-striped nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date Updated</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Date of Birth</th>
                                        <th>Contact Number</th>
                                        <th>Email Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "../../db_connect/config.php";
                                    $tableName = 'zp_client_record';
                                    $dermaTableName = 'zp_derma_record';
                                    
                                    $stmt = mysqli_prepare($conn, "
                                        SELECT c.*, MAX(d.date_diagnosis) AS latest_update
                                        FROM $tableName c
                                        LEFT JOIN $dermaTableName d ON c.id = d.patient_id
                                        WHERE c.is_archived = 0
                                        GROUP BY c.id
                                        ORDER BY latest_update DESC
                                    ");
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>

                                        <tr>
                                            <td><?php echo $row['latest_update'] ? date('F d, Y', strtotime($row['latest_update'])) : 'N/A'; ?></td>
                                            <td><?php echo $row['client_firstname']?></td>
                                            <td><?php echo $row['client_lastname']?></td>
                                            <td><?php echo date('F d, Y', strtotime($row['client_birthday']))?></td>
                                            <td><?php echo $row['client_number']?></td>
                                            <td><?php echo $row['client_email']?></td>
                                            
                                            <td class="action-buttons">
                                                <a href="view.php?id=<?php echo $row['id']?>" class="btn bg-purple text-white"> View</a>
                                                <a href="edit_client_record.php?id=<?php echo $row['id']?>" class="btn btn-outline-purple">Edit</a>
                                                <a href="#" class="btn btn-danger archive-btn" data-id="<?php echo $row['id']?>">Archive</a>
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
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        <div class="table-responsive">
                            <table id="clientTable" class="table table-bordered table-striped nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Date of Birth</th>
                                        <th>Contact Number</th>
                                        <th>Email Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "../../db_connect/config.php";
                                    $stmt = mysqli_prepare($conn, "SELECT * FROM zp_client_record WHERE is_archived = 1 ORDER BY client_firstname ASC, client_lastname ASC");
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>

                                        <tr>
                                            <td><?php echo date('F d, Y', strtotime($row['archived_at']))?></td>
                                            <td><?php echo $row['client_firstname']?></td>
                                            <td><?php echo $row['client_lastname']?></td>
                                            <td><?php echo date('F d, Y', strtotime($row['client_birthday']))?></td>
                                            <td><?php echo $row['client_number']?></td>
                                            <td><?php echo $row['client_email']?></td>

                                            <td class="action-buttons">
                                                <a href="view.php?id=<?php echo $row['id']?>" class="btn bg-purple text-white"> View</a>
                                                <a href="edit_client_record.php?id=<?php echo $row['id']?>" class="btn btn-outline-purple">Edit</a>
                                                <a href="#" class="btn btn-danger archive-btn" data-id="<?php echo $row['id']?>">Unarchive</a>
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
                dom: '<"row  text-end"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end">>rtip',
                "ordering": false,
            });
        });
    </script>
     <script>
        $(document).ready(function() {
            var table = $('#archiveTable').DataTable({
                dom: '<"row  text-end"<"col-xl-2 col-lg-3 col-md-6 mt-4"l><"col-xl-3 col-lg-4 col-md-6 top-height"f><"col-xl-4"><"col-xl-3 col-lg-4 mt-3 text-end">>rtip',
                "ordering": false,
            });
            $('#yearFilter').on('change', function() {
                var selectedYear = $(this).val();
                table.column(0).search(selectedYear).draw();
            });
        });
    </script>
    <script>
$(document).ready(function() {
    // Handle archive button click using event delegation
    $('#content-wrapper').on('click', '.archive-btn', function(e) {
        e.preventDefault();
        var clientId = $(this).data('id');
        var isArchived = $(this).text().trim() === 'Archive';
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to ${isArchived ? 'archive' : 'unarchive'} this client record!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: `Yes, ${isArchived ? 'archive' : 'unarchive'} it!`
        }).then((result) => {
            // If user clicks 'Yes'
            if (result.isConfirmed) {
                updateArchiveStatus(clientId, isArchived);
            }
        });
    });

    function updateArchiveStatus(clientId, isArchived) {
        $.ajax({
            type: 'GET',
            url: `archive.php?id=${clientId}&archive=${isArchived ? '1' : '0'}`,
            success: function(response) {
                Swal.fire('Success', `Client record ${isArchived ? 'archived' : 'unarchived'} successfully!`, 'success')
                    .then(() => {
                        location.reload();
                    });
            },
            error: function(error) {
                console.error(`Error ${isArchived ? 'archiving' : 'unarchiving'} client record: `, error);
                Swal.fire('Error', `Failed to ${isArchived ? 'archive' : 'unarchive'} client record!`, 'error');
            }
        });
    }
});


</script>

</body>
</html>
