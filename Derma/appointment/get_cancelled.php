<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Cancel Appointment</title>
</head>
<body>
<?php
include "../../db_connect/config.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $email = $row['email'];
    }
}
?>

<form id="signUpForm" action="appointment.php" method="post">
    <div>
        <label for="">User's Email</label>
        <input type="text" class="form-control" name="email" readonly value="<?php echo ($email)?>">
    </div>
    <div>
        <label for="">Reason for Cancellation</label>
        <textarea class="form-control" placeholder="Enter reason for cancellation" name="apt_reason" required></textarea>
    </div>
    <?php if (isset($_POST['id'])) : ?>
        <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
        <div class="modal-footer">
        <button class="btn bg-purple text-white ml-auto" type="submit" name="cancel">Cancel Appointment</button>
        </div>
        
    <?php endif; ?>
</form>
<script>
$(document).ready(function() {
  $("#signUpForm").on("submit", function(e) {
    if (this.checkValidity()) {
      $("#pageloader").fadeIn();
    } else {
      e.preventDefault();
    }
  });
});
    </script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
