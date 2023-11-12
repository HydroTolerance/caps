<?php
include "../function.php";
checklogin();
$userData = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <form method="post" action="service.php" enctype="multipart/form-data">
        <div>
            <label>Image:</label>
            <input type="file" name="image" class="form-control" accept=".jpeg, .jpg, .png" required>
        </div>
        <div>
            <label>Service Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div>
            <label>Services:</label>
            <select name="services" id="" class="form-control">
                <option value="Skin">Skin</option>
                <option value="Hair">Hair</option>
                <option value="Nail">Nail</option>
            </select>
        </div>
        <div>
            <label>Description:</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        <div class="modal-footer">
            <input type="submit" name="submit" class="btn text-white" value="Submit" style="background-color:#6537AE; ">
        </div>
        
    </form>
</body>
</html>
