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
            <label for="edit_fname" class="form-label">History</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_history" value="<?php echo $rows['history']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label">Diagnosis</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_diagnosis" value="<?php echo $rows['diagnosis']; ?>"  required>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label">Management</label>
            <input type="text" class="form-control" id="edit_email" name="edit_management" value="<?php echo $rows['management']; ?>"  required>
        </div>
        <button type="submit" name="update_diagnosis" class="btn btn-primary">Save Changes</button>
    </form>
</div>
