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
    <div id="loading" class="text-center">
        <p>Loading...</p>
    </div>
    <form method="post"  enctype="multipart/form-data" style="display: none;" id="formContent">
        <label for="edit_fname" class="form-label">Image</label><br>
        <div class="text-center">
            <?php
            $imagePath = "../../img/progress/{$rows['image']}";

            if (file_exists($imagePath) && is_file($imagePath)) {
                echo "<img class='img-fluid' src='{$imagePath}' alt='' height='200px' width='200px'>";
            } else {
                echo "<p class='text-center'>No Image Inserted</p>";
            }
            ?>
        </div>

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="edit_fname" class="form-label">Date</label><br>
            <label ><?php echo date('M d, Y', strtotime($rows['date_diagnosis'])); ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label">History</label><br>
            <label ><?php echo $rows['history']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label">Diagnosis</label><br>
            <label ><?php echo $rows['diagnosis']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label">Management</label><br>
            <label ><?php echo $rows['management']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label">Notes</label><br>
            <label ><?php echo $rows['notes']; ?></label>
        </div>
    </form>
</div>

<script>
</script>
