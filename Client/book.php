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

    $count_sql = "SELECT COUNT(*) FROM book1 WHERE d='$d' AND time='$time'";
    $count_result = mysqli_query($conn, $count_sql);
    $count_row = mysqli_fetch_array($count_result);
    $num_bookings = $count_row[0];

    if ($num_bookings >= 3) {
        echo "Sorry, this time slot is fully booked. Please choose another time.";
    } else {
        $sql = "INSERT INTO book1 (name, age, dob, num, address, email, ecp, relation, num2, message, option, d, time) VALUES ('$name', '$age', '$dob', '$num', '$address', '$email', '$ecp', '$relation', '$num2', '$message', '$option', '$d', '$time')";
        if (mysqli_query($conn, $sql)) {
          header("Location: display.php?name=$name&age=$age&dob=$dob&num=$num&address=$address&email=$email&ecp=$ecp&relation=$relation&num2=$num2&message=$message&option=$option&d=$d&time=$time");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Book</title>
</head>
<body>
    <div class="backicon">
        <div class="backbutton"><a href="index.html"><img src="back.svg" alt="Icon"> </a></div>
    </div>
  
        <h1 class="topword">Book an Appointment</h1>

        <form action="" method="post">
        <div class="input-group1">
            <div class="input-name">
              <label for="name">NAME:</label>
              <input type="text" id="name" name="name">
            </div>
            <div class="input-age">
              <label for="age">AGE:</label>
              <input type="number" id="age" name="age">
            </div>
            <div class="input-dob">
                <label for="dob">DATE OF BIRTH:</label>
                <input type="date" id="dob" name="dob">
              </div>
            <div class="input-num">
                <label for="num">CONTACT NUMBER:</label>
                <input type="number" id="num" name="num">
            </div>
              
          </div>

          <div class="input-group2">
            <div class="input-address">
              <label for="address">ADDRESS:</label>
              <input type="text" id="address" name="address">
            </div>
            <div class="input-email">
              <label for="email">EMAIL:</label>
              <input type="email" id="email" name="email">
            </div>

            </div>

            <div class="input-group3">
              <div class="input-ecp">
                <label for="ecp">EMERGENCY CONTACT PERSON:</label>
                <input type="text" id="ecp" name="ecp">
              </div>
              <div class="input-relation">
                <label for="relation">RELATION:</label>
                <input type="text" id="relation" name="relation">
              </div>
              <div class="input-num2">
                  <label for="num2">CONTACT NUMBER:</label>
                  <input type="number" id="num2" name="num2">
                </div>

                </div>
            
                <div class="input-group4">
                  <div class="hc">
                    <label for="message">HEALTH COMPLAINT:</label>
                    <textarea id="message" name="message"></textarea>
                  </div>
                </div>
                    <div class="input-group5">
                      <div class="servs"><label for="dropdown">SERVICE:</label>
                          <select id="option" name="option">
                            <option value="General Checkup">General Checkup</option>
                            <option value="Vaccination">Vaccination</option>
                            <option value="Medical Test">Medical Test</option>
                          </select></div>

                          <div class="input-d">
  <label for="d">DATE:</label>
  <input type="date" id="d" name="d" onchange="updateTime()">
</div>

<div class="taym">
  <label for="dropdown">TIME:</label>
  <select class="form-control" name="time" id="time" style="height: 35px;"></select>
  <span id="num_slots"></span>
</div>

<script>
  function updateTime() {
    var d = document.getElementById("d").value;
    var time = document.getElementById("time");
    time.innerHTML = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var slots = JSON.parse(this.responseText);
        for (var slot in slots) {
          var option = document.createElement("option");
          option.value = slot;
          option.text = slot;
          var num_bookings = slots[slot];
          if (num_bookings >= 3) {
            option.disabled = true;
          }
          time.add(option);
          var slotsLeft = 3 - num_bookings;
          var slotText = option.text + " (" + slotsLeft + " slot(s) left)";
          option.text = slotText;
        }
        var num_slots = Object.keys(slots).length;
        document.getElementById("num_slots").innerHTML = " (" + num_slots + " choose you can pick)";
      }
    };
    xmlhttp.open("GET", "get_slot.php?d=" + d, true);
    xmlhttp.send();
  }
</script>


                      <div class="bookton2-container">
                        <input type="submit" name="submit" value="Submit">
                      </div>
          
                      </form>
      <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
      <script>
        configuration = {
          dateFormat: "Y-m-d",
          minDate: "today",
          maxDate: new Date().fp_incr(60),
          "disable": [
        // Disable weekends
        function(date) {
            return (date.getDay() === 2 || date.getDay() === 4 || date.getDay() === 0);

        }
    ]

        }
        flatpickr("#d", configuration);
      </script>
    </body>
</html>