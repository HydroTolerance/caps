<?php
include "../../db_connect/config.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Update the appointment status to 'Acknowledged' in the database
    $query = "UPDATE zp_appointment SET appointment_status = 'Acknowledged' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Send acknowledgment email
        require 'phpmailer/PHPMailerAutoload.php';
        
        // Retrieve the email address associated with the appointment from the database
        $stmt = mysqli_prepare($conn, "SELECT email FROM zp_appointment WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $emailResult = mysqli_stmt_get_result($stmt);

        if ($emailRow = mysqli_fetch_assoc($emailResult)) {
            $email = $emailRow['email'];

            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'blazered098@gmail.com';
                $mail->Password = 'nnhthgjzjbdpilbh'; // Your SMTP password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('blazered098@gmail.com', 'ROgen');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Appointment Acknowledged';
                $mail->Body = "Your appointment has been Acknowledged 123456577.";

                // Send the email
                $mail->send();
                echo 'acknowledged';
            } catch (Exception $e) {
                echo 'email_error'; // Return an error response if the email sending fails
            }
        } else {
            echo 'email_not_found'; // Return an error response if the email address is not found
        }
    } else {
        echo 'update_error'; // Return an error response if the update fails
    }
} else {
    echo 'invalid_request';
}

mysqli_close($conn);
?>
