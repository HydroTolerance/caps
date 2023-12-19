<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Document</title>
</head>
<script>
        function showSelectedMessage() {
            var selectElement = document.getElementById("apt_reason");
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var apologyMessageElement = document.getElementById("apologyMessage");

            apologyMessageElement.innerHTML = selectedOption.value;
        }
    </script>
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
if (!isset($_POST['secret_key']) || $_POST['secret_key'] !== $secret_key) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Access Denied';
    exit;
}

?>
<form id="signUpForm" action="appointment.php" method="post">
<div>
        <label for="">Client Email</label>
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
    <label for="apt_reason">Reason for Rescheduling</label>
    <select name="apt_reason" id="apt_reason" class="form-select" required onchange="showOtherReason()">
        <option value="I sincerely apologize for the unforeseen circumstances that have arisen, preventing me from attending our scheduled appointment. An unexpected event has occurred, and I deeply regret any inconvenience this may have caused. I understand the importance of our meeting and assure you that I am actively working to address the situation. I appreciate your understanding and would be grateful for the opportunity to reschedule our appointment at your earliest convenience. Please let me know a suitable time, and I will make every effort to ensure our meeting takes place smoothly. Once again, I apologize for any disruption this may have caused and appreciate your understanding.">Unexpected event</option>
        <option value="I am currently facing health issues and, unfortunately, cannot attend the scheduled appointment. I apologize for any inconvenience.">Health issue</option>
        <option value="Unexpected weather conditions have arisen, making it unsafe for me to travel to our meeting. I apologize for any disruption this may cause.">Weather conditions</option>
        <option value="Other">Other</option>
    </select>

    <div id="otherReasonDiv" style="display:none;">
        <label for="otherReason">Please specify:</label>
        <textarea type="text" id="otherReason" name="otherReason" class="form-control" rows="5"></textarea>
    </div>

    <?php if (isset($_POST['id'])) : ?>
        <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
    <?php endif; ?>
    <div class="modal-footer">
        <button class="btn bg-purple text-white ml-auto" type="submit" name="<?php echo isset($_POST['id']) ? 'update' : 'save'; ?>"><?php echo isset($_POST['id']) ? 'Update' : 'Save'; ?></button>
    </div>
</form>
<p id="apologyMessage"></p>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<?php
    include "../../db_connect/config.php";

    $sql = "SELECT day_to_disable FROM disabled_days";
    $result = $conn->query($sql);
    $disableDates = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $disableDates[] = $row['day_to_disable'];
        }
    }
    $sql = "SELECT day, is_available FROM availability";
    $result = $conn->query($sql);
    $disableDays = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['is_available'] == 0) {
                $disableDays[] = $row['day'];
            }
        }
    }

    $conn->close();
    ?>
<script>
    var configuration = {
        dateFormat: "Y-m-d",
        allowInput: true,
        minDate: new Date().fp_incr(1),
        maxDate: new Date().fp_incr(60),
        "disable": [
            function(date) {
                date.setHours(23, 59, 59, 999);
                var dateString = date.toISOString().split('T')[0];
                var dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                return <?php echo json_encode($disableDates); ?>.includes(dateString) ||
                <?php echo json_encode($disableDays); ?>.includes(dayName[date.getDay()]);
            },
        ]
    };

    flatpickr("#d", configuration);
</script>
<script>

d.addEventListener("change", updateTime);
function updateTime() {
    var d = document.getElementById("d").value;
    var time = document.getElementById("time");
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
    xmlhttp.open("GET", "get_slot.php?d=" + encodeURIComponent(d), true);
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

</body>
</html>
