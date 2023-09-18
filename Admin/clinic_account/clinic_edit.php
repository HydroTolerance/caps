
<?php
include "../../db_connect/config.php";

if (isset($_POST['zep_acc'])) {
    $id = $_POST['zep_acc'];
    $sql = "SELECT * FROM zp_accounts WHERE zep_acc = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>
<div class="modal-body">
    <form method="post" action="insert_update_acc.php" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" value="<?php echo $rows['zep_acc']; ?>">
        <div class="mb-3">
            <label for="image">Upload Image (Max 5MB):</label>
            <input type="file" name="image" accept="image/*" id="image">
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_fname" value="<?php echo $rows['clinic_firstname']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_lname" value="<?php echo $rows['clinic_lastname']; ?>"  required>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit_email" name="edit_email" value="<?php echo $rows['clinic_email']; ?>"  required>
        </div>
        <div class="mb-3">
            <label for="edit_role" class="form-label">Role</label>
                <select name="edit_role" id="" class="form-control" required>
                    <option selected="true" disabled>-- Select Role --</option>
                    <option value="Derma" <?php echo ($rows ['clinic_role'] === 'Derma')  ? 'selected' : ''; ?>>Derma</option>
                    <option value="Staff" <?php echo ($rows ['clinic_role'] === 'Staff') ? 'selected' : ''; ?>>Staff</option>
                </select>
        </div>
        <button type="submit" name="edit_submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
