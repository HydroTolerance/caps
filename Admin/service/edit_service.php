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
    <title>Edit FAQ</title>
</head>

<body>
<?php
if (isset($_GET['id'])) {
    include "../../db_connect/config.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM service WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if (!$row) {
        echo "FAQ not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}


?>
<form method="post" action="" enctype="multipart/form-data" onsubmit="return checkFileSize()">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<div class="form-group">
    <label for="edit_image">Image:</label>
    <input type="file" name="image" id="image" class="form-control " accept="image/*>
</div>
<div class="form-group">
    <label for="edit_description">Service Name</label>
    <textarea name="name" class="form-control"><?php echo $row['name']; ?></textarea>
</div>

<div>
    <label>Services:</label>
    <select name="services" class="form-control">
        <option value="Skin" <?php echo ($row['services'] === 'Skin') ? 'selected' : ''; ?>>Skin</option>
        <option value="Hair" <?php echo ($row['services'] === 'Hair') ? 'selected' : ''; ?>>Hair</option>
        <option value="Nail" <?php echo ($row['services'] === 'Nail') ? 'selected' : ''; ?>>Nail</option>
    </select>
</div>

<div class="form-group">
    <label for="edit_description">Description</label>
    <textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea>
</div>
<div class="modal-footer">
    <input type="submit" name="edit_submit" value="Submit" class="btn text-white" style="background-color: #6537AE;">
</div>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Function to check the file size before form submission
    function checkFileSize() {
        var inputFile = document.getElementById('image');
        var maxFileSize = 2 * 1024 * 1024; // 2 MB limit

        if (inputFile.files.length > 0) {
            var fileSize = inputFile.files[0].size;

            if (fileSize > maxFileSize) {
                // Display SweetAlert 2 error message
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "File size exceeds the limit of 2 MB."
                });

                // Prevent form submission
                return false;
            }
        }

        // Continue with form submission
        return true;
    }
</script>
</body>
</html>