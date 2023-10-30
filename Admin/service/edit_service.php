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

if (isset($_POST['edit_submit'])) {
    $service = $_POST['services'];
    $description = $_POST['description'];
    $newImageUploaded = false;
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $newImageUploaded = true;
        $uploadedFile = $_FILES['image'];
        $uploadDir = "../../img/services/";
        $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        $uniqueFilename = uniqid() . '.' . $fileExtension;
        $newImageFilePath = $uploadDir . $uniqueFilename;

        if (move_uploaded_file($uploadedFile['tmp_name'], $newImageFilePath)) {
            if (!empty($row['image']) && file_exists($uploadDir . $row['image'])) {
                unlink($uploadDir . $row['image']);
            }
            $sql = "UPDATE service SET services=?, description=?, image=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssi", $service, $description, $uniqueFilename, $id);
        } else {
            echo "Error uploading the new image.";
            exit;
        }
    } else {
        $sql = "UPDATE service SET services=?, description=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $service, $description, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: service.php");
        exit();
    } else {
        echo "Error Updating Error: " . mysqli_error($conn);
    }
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" enctype="multipart/form-data">
<div class="form-group">
    <label for="edit_image">Image:</label>
    <input type="file" name="image" class="form-control-file">
</div>

<div>
    <label>Services:</label>
    <select name="services" class="form-control">
        <option value="Skin" <?php echo ($row['services'] === 'Skin') ? 'selected' : ''; ?>>Skin</option>
        <option value="Face" <?php echo ($row['services'] === 'Skin') ? 'selected' : ''; ?>>Face</option>
        <option value="Nail" <?php echo ($row['services'] === 'Nail') ? 'selected' : ''; ?>>Nail</option>
    </select>
</div>

<div class="form-group">
    <label for="edit_description">Description</label>
    <textarea name="description" class="form-control"><?php echo $row['description']; ?></textarea>
</div>
<div class="modal-footer">
    <input type="submit" name="edit_submit" value="Submit" class="btn btn-primary">
</div>
</form>
</body>
</html>
