<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Document</title>
</head>
<body>
    <style>
            #rescheduleModal .modal-dialog .modal-content .modal-header {
        text-align: center;
    }
    </style>
<?php

include "../../db_connect/config.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM zp_appointment WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $date = $row['date'];
        $time = $row['time'];
    }
}
$secret_key = 'helloimjaycearon';

// Check for the presence of the secret key
if (!isset($_POST['secret_key']) || $_POST['secret_key'] !== $secret_key) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Access Denied';
    exit;
}

?>
<form id="signUpForm" action="appointment.php" method="post">
<div>
        <label for="">Email of User</label>
        <input type="text" class="form-control"  name="email" required readonly value="<?php echo ($email)?>">
    </div>
    <div>
        <label for="">Schedule Date (Rescheduled)</label>
        <input type="date" class="form-control" placeholder="Enter Schedule Date" id="d" name="date" required value="<?php echo isset($date) ? $date : ''; ?>">
    </div>
    <div>
        <label>Select Time Appointment (Rescheduled)</label>
        <select class="form-control" name="time" id="time" placeholder="Enter Time Appointment" required>
            <?php if (isset($time)) : ?>
                <option value="<?php echo $time; ?>" selected><?php echo $time; ?></option>
            <?php endif; ?>
        </select>
    </div>
    <div>
        <label for="">Reason of Rescheduled</label>
        <textarea class="form-control" placeholder="type....." name="apt_reason" required><?php echo isset($reason) ? $reason : ''; ?></textarea>
    </div>
    <?php if (isset($_POST['id'])) : ?>
        <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
    <?php endif; ?>
    <div class="modal-footer">
        <button class="btn bg-purple text-white ml-auto" type="submit" name="<?php echo isset($_POST['id']) ? 'update' : 'save'; ?>"><?php echo isset($_POST['id']) ? 'Update' : 'Save'; ?></button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    var configuration = {
        dateFormat: "Y-m-d",
        minDate: new Date().fp_incr(1),
        maxDate: new Date().fp_incr(60),
        disable: [
            function(date) {
                return (date.getDay() === 2 || date.getDay() === 4 || date.getDay() === 0);
            }
        ]
    };

    flatpickr("#d", configuration);
    var d = document.getElementById("d");
    var time = document.getElementById("time");

    d.addEventListener("change", updateTime);

    function updateTime() {
        var selectedDate = d.value;
        time.innerHTML = "";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                var slots = response.slots;
                var slotsLeft = response.slots_left;

                for (var slot in slots) {
                    var option = document.createElement("option");
                    option.value = slot;
                    option.text = slot;
                    var num_bookings = slots[slot];
                    var slotsLeftForOption = slotsLeft - num_bookings;
                    if (slotsLeftForOption <= 0) {
                        option.disabled = true;
                        slotsLeftForOption = 0;
                    }
                    time.add(option);
                    var slotText = option.text + " (" + slotsLeftForOption + " slot(s) left)";
                    option.text = slotText;
                }
                var num_slots = Object.keys(slots).length;
                document.getElementById("num_slots").innerHTML = " (" + num_slots + " slots available)";
            }
        };
        xmlhttp.open("GET", "get_slot.php?d=" + encodeURIComponent(selectedDate), true);
        xmlhttp.send();
    }
    
</script>
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
</body>
</html>
