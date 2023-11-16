<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
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
            <label for="edit_fname" class="form-label fw-bold">Date</label>
            <input type="date" class="form-control" id="d" name="edit_date" value="<?php echo $rows['date_diagnosis']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label fw-bold">History</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_history" value="<?php echo $rows['history']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label fw-bold">Diagnosis</label>
            <textarea type="text" class="form-control" id="edit_fname" name="edit_diagnosis" rows="5"  required><?php echo $rows['diagnosis']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label fw-bold">Management</label>
            <select class="select1 form-select" name="edit_management" style="width: 100%;" required>
                <option value=""></option>
                <?php
                include "../../db_connect/config.php";
                $stmt = mysqli_prepare($conn, "SELECT DISTINCT services FROM service");
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $category);

                while (mysqli_stmt_fetch($stmt)) {
                    echo '<optgroup label="' . $category . '">';
                    $stmt2 = mysqli_prepare($conn, "SELECT id, services, name, image, description FROM service WHERE services = ?");
                    mysqli_stmt_bind_param($stmt2, "s", $category);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_store_result($stmt2);
                    mysqli_stmt_bind_result($stmt2, $id, $services, $name, $image, $description);

                    while (mysqli_stmt_fetch($stmt2)) {
                        $selected = ($name == $rows['management']) ? 'selected' : '';
                        echo '<option value="' . $name . '" ' . $selected . '>' . $name . '</option>';
                    }
                    echo '</optgroup>';
                }
                ?>
            </select>

        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label fw-bold">Notes</label>
            <textarea type="text" class="form-control" id="edit_notes" name="edit_notes" rows="5"  required><?php echo $rows['notes']; ?></textarea>
        </div>
        <div class="modal-footer">
            <button type="submit" name="update_diagnosis" class="btn bg-purple text-white">Save</button>
        </div>
        
    </form>
    <script>
            $(document).ready(function(){
        $('.select1').select2({
        placeholder: {
            id: '',
            text: 'None Selected'
        },
        theme: 'bootstrap-5',
        allowClear: true,
        dropdownParent: $("#displayAccount")
    });
    })
    </script>
</div>

</body>
</html>
