<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Dashboard</title>
</head>
<body>
    <div class="container mt-5">
        <form method="post" action="settings.php" id="signUpForm">
            <div class="mb-3">
                <label for="day_to_disable" class="form-label">Select Specific Day to Disable:</label>
                <input type="date" id="d" class="form-control" name="day_to_disable" placeholder="Select Day" required autocomplete="off" readonly>
            </div>
            <div class="mb-3">
                <label for="new_appointment_date" class="form-label">New Appointment Date:</label>
                <input type="date" id="d1" class="form-control" name="new_appointment_date" placeholder="Select New Date" required autocomplete="off" readonly>
            </div>
            <div class="mb-3">
                <label for="apt_reason">Reason for Rescheduling</label>
                <select name="apt_reason" id="apt_reason" class="form-select" required onchange="showOtherReason()">
                <option hidden>Select Reason</option>
                    <option value="I sincerely apologize for the unforeseen circumstances that have arisen, preventing me from attending our scheduled appointment. An unexpected event has occurred, and I deeply regret any inconvenience this may have caused. I understand the importance of our meeting and assure you that I am actively working to address the situation. I appreciate your understanding and would be grateful for the opportunity to reschedule our appointment at your earliest convenience. Please let me know a suitable time, and I will make every effort to ensure our meeting takes place smoothly. Once again, I apologize for any disruption this may have caused and appreciate your understanding.">Unexpected event</option>
                    <option value="I am currently facing health issues and, unfortunately, cannot attend the scheduled appointment. I apologize for any inconvenience.">Health issue</option>
                    <option value="Unexpected weather conditions have arisen, making it unsafe for me to travel to our meeting. I apologize for any disruption this may cause.">Weather conditions</option>
                    <option value="We are observing a holiday and will not be able to assist you on this day. We apologize for any inconvenience caused.">Holiday</option>
                    <option value="Other">Other</option>
                </select>

                <div id="otherReasonDiv" style="display:none;">
                    <label for="otherReason">Please specify:</label>
                    <textarea type="text" id="otherReason" name="otherReason" class="form-control" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn text-white" style="background-color: #6537AE;">Submit</button>
            </div>
        </form>
    </div>
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
        minDate: new Date().fp_incr(0),
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
        minDate: new Date().fp_incr(0),
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

    flatpickr("#d1", configuration);
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
        $('#d').on('focus', ({ currentTarget }) => $(currentTarget).blur())
    $("#d").prop('readonly', false)
    $('#d1').on('focus', ({ currentTarget }) => $(currentTarget).blur())
    $("#d1").prop('readonly', false)
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