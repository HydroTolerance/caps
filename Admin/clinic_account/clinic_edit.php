<?php
include "../../db_connect/config.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM zp_accounts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $rows = mysqli_fetch_assoc($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<div class="modal-body">

    <form method="post"  enctype="multipart/form-data">
    <div class="container">
        <div class="row">
        <input type="hidden" name="edit_id" value="<?php echo $rows['id']; ?>">
        <div class="col-md-6">
            <label for="image" class="form-label">Upload Image (Max 5MB):</label>
            <input type="file" name="image" accept="image/*" id="image" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="edit_fname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_fname" value="<?php echo $rows['clinic_firstname']; ?>" required>
        </div>
        <div class="col-md-6">
            <label for="edit_fname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_lname" value="<?php echo $rows['clinic_lastname']; ?>"  required>
        </div>
        <div class="col-md-6">
            <label for="edit_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit_email" name="edit_email" value="<?php echo $rows['clinic_email']; ?>"  required>
        </div>
        <div class="col-md-6">
            <label for="edit_email" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="edit_email" name="birthday" value="<?php echo $rows['clinic_birthday']; ?>"  required>
        </div>
        <div class="col-md-6">
            <label for="edit_role" class="form-label">Gender</label>
                <select name="edit_role" id="" class="form-control" required>
                    <option selected="true" disabled>-- Select Role --</option>
                    <option value="Derma" <?php echo ($rows ['clinic_gender'] === 'Male')  ? 'selected' : ''; ?>>Male</option>
                    <option value="Staff" <?php echo ($rows ['clinic_gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="edit_role" class="form-label">Role</label>
                <select name="edit_role" id="" class="form-control" required>
                    <option selected="true" disabled>-- Select Role --</option>
                    <option value="Derma" <?php echo ($rows ['clinic_role'] === 'Derma')  ? 'selected' : ''; ?>>Derma</option>
                    <option value="Staff" <?php echo ($rows ['clinic_role'] === 'Staff') ? 'selected' : ''; ?>>Staff</option>
                </select>
        </div>
        <div class="modal-footer">
            <button type="submit" name="edit_submit" class="btn text-white" style="background-color: #6537AE;">Save Changes</button>
        </div>
            
        </div>
    </div>
        
    </form>
</div>