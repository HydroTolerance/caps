<?php
// Include your database connection configuration here
include "../../db_connect/config.php";

// Fetch availability data from the database
$sql = "SELECT id, day, is_available FROM availability";
$result = $conn->query($sql);

// Create an array to store availability data
$availabilityData = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $availabilityData[] = $row;
    }
}
    // Handle form submission
    if (isset($_POST['update'])) {
        // Process the form data and update the database
        foreach ($_POST['availability'] as $id => $value) {
            $sql = "UPDATE availability SET is_available = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $value, $id);
            $stmt->execute();
            $stmt->close();
        }
        // Redirect back to the page or perform any other action
        header("Location: settings.php");
        exit();
    }
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Availability</title>
</head>
<body>
    <form method="POST">
        <table>
            <tr>
                <th>Day</th>
                <th>Is Available</th>
            </tr>
            <?php foreach ($availabilityData as $data) { ?>
                <tr>
                    <td><?php echo $data['day']; ?></td>
                    <td>
                        <label><input type="radio" name="availability[<?php echo $data['id']; ?>]" value="1" <?php echo ($data['is_available'] == 1) ? 'checked' : ''; ?>> Yes</label>
                        <label><input type="radio" name="availability[<?php echo $data['id']; ?>]" value="0" <?php echo ($data['is_available'] == 0) ? 'checked' : ''; ?>> No</label>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
