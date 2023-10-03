<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Cancel Appointment</title>
</head>
<body>
<?php
include "../db_connect/config.php";
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $reason = $_POST['apt_reason'];
    $stmt = mysqli_prepare($conn, "UPDATE zp_appointment SET email=?, apt_reason = ?, appointment_status = 'Cancelled', schedule_status = 'Cancel' WHERE id =?");
    mysqli_stmt_bind_param($stmt, "ssi", $email, $reason, $id);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        require 'phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP(); 
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;         
            $mail->Username = 'blazered098@gmail.com';
            $mail->Password = 'nnhthgjzjbdpilbh'; // Your SMTP password
            $mail->SMTPSecure = 'tls';       
            $mail->Port = 587;              

            //Recipients
            $mail->setFrom('blazered098@gmail.com', 'ROgen');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true); 
            $mail->Subject = 'Appointment Cancelled';
            $mail->Body = "Your appointment has been cancelled:<br><br>Reason: $reason";

            $mail->send();
            header("Location: home.php");
            exit();
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $email = $row['email'];
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div>
        <label for="">User's Email</label>
        <input type="text" class="form-control" name="email" readonly value="<?php echo ($email)?>">
    </div>
    <div>
        <label for="">Reason for Cancellation</label>
        <textarea class="form-control" placeholder="Enter reason for cancellation" name="apt_reason" required></textarea>
    </div>
    <?php if (isset($_POST['id'])) : ?>
        <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
        <button type="submit" name="update">Cancel Appointment</button>
    <?php endif; ?>
</form>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
