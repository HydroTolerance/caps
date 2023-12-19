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
        <label for="">Client Email</label>
        <input type="text" class="form-control" name="email" readonly value="<?php echo ($email)?>">
    </div>
    <div>
        <label for="">Reason for Cancellation</label>
        <select name="apt_reason" id="apt_reason" class="form-select" required onchange="showOtherReason()">
          <option value="" hidden>Select Reason</option>
          <option value="Unfortunately, your appointment is canceled due to a violation of our appointment policy. We will provide details on the issue and steps for resolution. We appreciate your understanding in maintaining a safe and respectful environment.">Policy Violation</option>
          <option value="I regret to inform you that we need to cancel your upcoming appointment. Unfortunately, due to a scheduling oversight, your appointment was double-booked. We sincerely apologize for any inconvenience this may cause.">Double Booking</option>
          <option value="Unfortunately, we need to cancel your appointment due to a natural disaster or unforeseen circumstances beyond our control. Your safety is our top priority, and we appreciate your understanding during this challenging time.">Natural Disaster</option>
        <option value="Other">Other</option>
    </select>
    <div id="otherReasonDiv" style="display:none;">
        <label for="otherReason">Please specify:</label>
        <textarea type="text" id="otherReason" name="otherReason" class="form-control" rows="5"></textarea>
    </div>
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
        <script>
function showOtherReason() {
    var select = document.getElementById("apt_reason");
    var otherReasonDiv = document.getElementById("otherReasonDiv");
    var otherReasonInput = document.getElementById("otherReason");

    if (select.value === "Other") {
        otherReasonDiv.style.display = "block";
        otherReasonInput.required = true;
        otherReasonInput.name = "apt_reason";
    } else {
        otherReasonDiv.style.display = "none";
        otherReasonInput.required = false;
        otherReasonInput.name = "";
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
