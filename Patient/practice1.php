<?php
// Connect to the MySQL database
include "../db_connect/config.php";

// Check for errors
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// If the form was submitted, handle the booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the slot that was selected
    $slot = $_POST['slot'];

    // Get the date that was selected
    $date = $_POST['date'];

    // Query the database to get the number of bookings for the selected slot and date
    $sql = "SELECT COUNT(*) AS num_bookings FROM appointments WHERE slot = '$slot' AND date = '$date'";
    $result = mysqli_query($conn, $sql);

    // Check for errors
    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }

    // Get the number of bookings
    $row = mysqli_fetch_assoc($result);
    $num_bookings = $row['num_bookings'];

    // If the slot has already been booked twice, display an error message
    if ($num_bookings >= 2) {
        $error = 'Sorry, that slot has already been booked by two users.';
    } else {
        // Insert the appointment into the database
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $sql = "INSERT INTO appointments1 (name, email, slot, date) VALUES ('$name', '$email', '$slot', '$date')";
        $result = mysqli_query($conn, $sql);

        // Check for errors
        if (!$result) {
            die('Query failed: ' . mysqli_error($conn));
        }
    }
}

// Query the database to get the booked appointment slots and dates
$sql = "SELECT slot, date FROM appointments2";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// Create an array of booked slots and dates
$booked_slots = array();
while ($row = mysqli_fetch_assoc($result)) {// Add the booked slot and date to the array
    $booked_slots[] = $row['slot'] . '_' . $row['date'];
    }
    
    // Close the database connection
    mysqli_close($conn);
    
    // Output the appointment form
    ?>
<form method="post">
    <label>
        Name:
        <input type="text" name="name" required>
    </label>
    <br>
    <label>
        Email:
        <input type="email" name="email" required>
    </label>
    <br>
    <label>
        Date:
        <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>
    </label>
    <br>
    <label>
        Slot:
        <select name="slot" required>
            <option value="">-- Select a slot --</option>
            <?php for ($i = 9; $i < 22 ; $i++) : ?>
                <?php
                $slot = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                $slot_date = $_POST['date'];
                $booked = in_array($slot . '_' . $slot_date, $booked_slots);
                $disabled = '';
                if ($booked || strtotime($slot_date) < strtotime(date('Y-m-d'))) {
                    $disabled = 'disabled';
                }
                ?>
                <option value="<?php echo $slot; ?>" <?php echo $disabled; ?>><?php echo $slot; ?></option>
            <?php endfor; ?>
        </select>
    </label>
    <br>
    <button type="submit">Book appointment</button>
</form>
<?php if (isset($error)) : ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>
<script>
    function updateForm() {
        var date = document.getElementById('date').value;
        var slot = document.getElementById('slot').value;
        if (date && slot) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'check_availability.php?date=' + encodeURIComponent(date) + '&slot=' + encodeURIComponent(slot));
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'error') {
                        alert(response.message);
                    } else {
                        var slots = document.querySelectorAll('#slot option');
                        for (var i = 0; i < slots.length; i++) {
                            var slotId = slots[i].id;
                            if (response.booked_slots.indexOf(slotId) !== -1) {
                                slots[i].disabled = true;
                            } else {
                                slots[i].disabled = false;
                            }
                        }
                    }
                }
            };
            xhr.send();
        }
    }

    document.getElementById('date').addEventListener('change', updateForm);
    document.getElementById('slot').addEventListener('change', updateForm);
</script>