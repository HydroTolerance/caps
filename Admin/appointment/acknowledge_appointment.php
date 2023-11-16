<?php
include "../../db_connect/config.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "UPDATE zp_appointment SET appointment_status = 'Acknowledged' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        require 'phpmailer/PHPMailerAutoload.php';
        $stmt = mysqli_prepare($conn, "SELECT email FROM zp_appointment WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $emailResult = mysqli_stmt_get_result($stmt);

        if ($emailRow = mysqli_fetch_assoc($emailResult)) {
            $email = $emailRow['email'];
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'blazered098@gmail.com';
                $mail->Password = 'nnhthgjzjbdpilbh';
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
                echo 'email_error';
            }
        } else {
            echo 'email_not_found';
        }
    } else {
        echo 'update_error';
    }
} else {
    echo 'invalid_request';
}

mysqli_close($conn);
?>
