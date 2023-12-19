<?php
include "../../db_connect/config.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "UPDATE zp_appointment SET appointment_status = 'Acknowledged' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {

        $query = "SELECT * FROM zp_appointment WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $reference = $row['reference_code'];
        }
        require 'phpmailer/PHPMailerAutoload.php';
        $stmt = mysqli_prepare($conn, "SELECT email, firstname, lastname, services, date, time, reference_code FROM zp_appointment WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $emailResult = mysqli_stmt_get_result($stmt);

        if ($emailRow = mysqli_fetch_assoc($emailResult)) {
            $email = $emailRow['email'];
            $name = $emailRow['firstname'] . ' ' . $emailRow['lastname'];
            $services = $emailRow['services'];
            $date = date('F d, Y', strtotime($emailRow['date']));
            $time = $emailRow['time'];
            $reference = $emailRow['reference_code'];

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'blazered098@gmail.com';
                $mail->Password = 'nnhthgjzjbdpilbh';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('blazered098@gmail.com', 'Z Skin Care Center');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Appointment Acknowledged';

                $mail->Body = '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Appointment Acknowledged</title>
                    <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        color: #333;
                        padding: 20px;
                    }
            
                    h1 {
                        color: #6537AE;
                    }
            
                    p {
                        font-size: 16px;
                    }
            
                    .appointment-details {
                        margin-top: 20px;
                    }
            
                    .detail-label {
                        font-weight: bold;
                    }
            
                    .contact-info {
                        margin-top: 20px;
                    }
            
                    .footer {
                        margin-top: 20px;
                        text-align: center;
                        color: #888;
                    }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Z Skin Care Center</h1>
                        <p>Dear ' . $name . ',</p>
                        <p>Your appointment scheduled has been <strong>Acknowledged</strong>.</p>
                        
                        <div class="appointment-details">
                            <p><span class="detail-label">Name:</span> ' . $name . '</p>
                            <p><span class="detail-label">Services:</span> ' . $services . '</p>
                            <p><span class="detail-label">Date:</span> ' . $date . '</p>
                            <p><span class="detail-label">Time:</span> ' . $time . '</p>
                            <p style="font-weight: bold; font-size: 20px;">Reference Code:' . $reference . '</p>
                        </div>
                        <p>Thank you for your transaction. Please note that rescheduling your appointment is limited to 5 attempts, and cancelling is allowed only once. To proceed with rescheduling or cancelling, <a href="https://zephyderm.infinityfreeapp.com/t/reschedule.php?reference_code=' . $reference . '">tap here.</a></p>
                        <div class="contact-info">
                            <p>Best regards,</p>
                            <p>Z SKIN CARE CENTER</p>
                        </div>
                    </div>
                    <div class="footer">
                        <p>&copy; 2023 Z Skin Care Center. All rights reserved.</p>
                        <p style="color: #888; margin-top: 20px;">This is an automated email, please do not reply.</p>
                    </div>

                </body>
                </html>';
                $imagePath = '../../t/images/thank_you_from_zskin.png';
                $mail->addEmbeddedImage($imagePath, 'Z Skin Care Center Reminders', 'Z Skin Care Center Reminders');
                
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