<?php
if(isset($_POST['submit'])){
    include "../db_connect/config.php";
    $name = $_POST['name'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $num = $_POST['num'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $ecp = $_POST['ecp'];
    $relation = $_POST['relation'];
    $num2 = $_POST['num2'];
    $message = $_POST['message'];
    $option = $_POST['option'];
    $d = $_POST['d'];
    $time = $_POST['time'];

    // Query the database for the number of bookings for the selected date and time
    $count_sql = "SELECT COUNT(*) FROM book1 WHERE d='$d' AND time='$time'";
    $count_result = mysqli_query($conn, $count_sql);
    $count_row = mysqli_fetch_array($count_result);
    $num_bookings = $count_row[0];

    if ($num_bookings >= 3) {
        // If the maximum number of bookings has been reached, disable the dropdown
        echo "Sorry, this time slot is fully booked. Please choose another time.";
        echo "<script>document.getElementById('time').disabled = true;</script>";
    } else {
        // If the time slot is available, insert the booking into the database
        $sql = "INSERT INTO book1 (name, age, dob, num, address, email, ecp, relation, num2, message, option, d, time) VALUES ('$name', '$age', '$dob', '$num', '$address', '$email', '$ecp', '$relation', '$num2', '$message', '$option', '$d', '$time')";
        if (mysqli_query($conn, $sql)) {
            echo "Appointment booked successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
