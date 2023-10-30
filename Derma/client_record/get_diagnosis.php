<?php
include "../../db_connect/config.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM zp_derma_record WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<div class="modal-body">
    <form method="post"  enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="edit_fname" class="form-label fw-bold">History</label><br>
            <label ><?php echo $rows['history']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label fw-bold">Diagnosis</label><br>
            <label ><?php echo $rows['diagnosis']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label fw-bold">Management</label><br>
            <label ><?php echo $rows['management']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label fw-bold">Notes</label><br>
            <label ><?php echo $rows['notes']; ?></label>
        </div>
    </form>
</div>
