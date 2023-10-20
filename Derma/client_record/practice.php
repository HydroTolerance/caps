<?php
include "../function.php";
checklogin();
$userData = $_SESSION['zep_acc'];

// Include database connection
include "../../db_connect/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['session_name'])) {
        $sessionName = $_POST['session_name'];
        
        // Use a prepared statement to insert the session name
        $session_stmt = mysqli_prepare($conn, "INSERT INTO zp_sessions (session_name) VALUES (?)");
        if ($session_stmt) {
            mysqli_stmt_bind_param($session_stmt, "s", $sessionName);
            if (mysqli_stmt_execute($session_stmt)) {
                header("location:practice.php");
            } else {
                echo "Error creating ZP Session: " . mysqli_error($conn);
            }
            mysqli_stmt_close($session_stmt);
        }
    } elseif (isset($_POST['session_id']) && isset($_POST['diagnosis_text'])) {
        $sessionId = $_POST['session_id'];
        $diagnosisText = $_POST['diagnosis_text'];
        $sql = "INSERT INTO zp_diagnoses (session_id, diagnosis_text) VALUES (?, ?)";
        
        // Use a prepared statement to insert the diagnosis
        $diagnosis_stmt = mysqli_prepare($conn, $sql);
        if ($diagnosis_stmt) {
            mysqli_stmt_bind_param($diagnosis_stmt, "is", $sessionId, $diagnosisText);
            if (mysqli_stmt_execute($diagnosis_stmt)) {
                echo "ZP Diagnosis added successfully!";
            } else {
                echo "Error adding ZP Diagnosis: " . mysqli_error($conn);
            }
            mysqli_stmt_close($diagnosis_stmt);
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>ZP Sessions and Diagnoses</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<style>
    .container {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f4f4f4;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
<body>
    <div class="container">
        <h1>Create a ZP Session</h1>
        <form method="POST">
            <label for="session_name">Session Name:</label>
            <input type="text" name="session_name" required>
            <input type="submit" value="Create Session">
        </form>
    </div>
    <div>
        <h1>Session of the User</h1>
    </div>
    <?php
// ...

// Fetch all existing sessions
$sessionsQuery = "SELECT * FROM zp_sessions";
$sessionsResult = mysqli_query($conn, $sessionsQuery);

if ($sessionsResult) {
    // Display existing sessions
    while ($sessionRow = mysqli_fetch_assoc($sessionsResult)) {
        $sessionId = $sessionRow['id'];
        $sessionName = $sessionRow['session_name'];
        ?>

        <div class="container">
            <h2><?= $sessionName ?></h2>
            <form method="POST">
                <input type="hidden" name="session_id" value="<?= $sessionId ?>">
                <label for="diagnosis_text">Session Information:</label>
                <textarea name="diagnosis_text" required></textarea>
                <input type="submit" value="Add Diagnosis">
                
            </form>
            <table class="diagnosis-container">
                        <tr>
                            <th>Diagnosis</th>
                        </tr>
            <?php
            // Display diagnoses associated with the session
            $diagnosesQuery = "SELECT * FROM zp_diagnoses WHERE session_id = $sessionId";
            $diagnosesResult = mysqli_query($conn, $diagnosesQuery);
            
            if ($diagnosesResult) {
                while ($diagnosisRow = mysqli_fetch_assoc($diagnosesResult)) {
                    $diagnosisText = $diagnosisRow['diagnosis_text'];
                    ?>
                        <tr>
                            <td><?= $diagnosisText ?></td>
                        </tr>
                    <?php
                }
            } else {
                echo "Error fetching diagnoses: " . mysqli_error($conn);
            }
            ?>
            </table>
        </div>

        <?php
    }
} else {
    // Handle the case when the query doesn't return any results or there's an error.
    echo "No sessions found or an error occurred: " . mysqli_error($conn);
}

    ?>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
