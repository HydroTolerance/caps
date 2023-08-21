<script>
    function get_num_bookings(d, time) {
  var num_bookings = 0;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      num_bookings = parseInt(this.responseText);
    }
  };
  xmlhttp.open("GET", "get_num_bookings.php?d=" + d + "&time=" + time, false);
  xmlhttp.send();
  return num_bookings;
}
</script>