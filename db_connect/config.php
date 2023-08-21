  <?php
  $host = "localhost";
  $username = "root";
  $password = "";//password to username, if locked
  $db_name = "zephyderm_database";//name of database to access here

  // Create connection
  $conn = new mysqli($host, $username, $password, $db_name);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  ?>