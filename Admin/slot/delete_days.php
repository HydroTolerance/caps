<?php
include "../../db_connect/config.php";
if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM disabled_days WHERE id = '$id'";
    if(mysqli_query($conn, $sql)){
        mysqli_close($conn);
        echo "FAQ deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

?>