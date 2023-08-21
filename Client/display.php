<?php
$firstname = $_GET['firstname'];
$lastname = $_GET['lastname'];
$num = $_GET['number'];
$email = $_GET['email'];
$message = $_GET['health_concern'];
$option = $_GET['services'];
$d = $_GET['date'];
$time = $_GET['time'];
$reference = $_GET['reference_code'];

$to = $email;
$subject = "Appointment Summary";
$body = "<html><body style='color: #000000;'>";
$body .= "<p><img src='cid:dermalogo.png' alt='Image' height='100px' width='100%'></p>";
$body .= "<p>Dear $firstname $lastname,</p>";
$body .= "<p>Thank you for your appointment!</p>";
$body .= "<p>Here is your appointment summary:</p>";
$body .= "<ul>";
$body .= "<li><strong>Name:</strong> $firstname $lastname</li>";
$body .= "<li><strong>Phone number:</strong> $num</li>";
$body .= "<li><strong>Email:</strong> $email</li>";
$body .= "<li><strong>Message:</strong> $message</li>";
$body .= "<li><strong>Service:</strong> $option</li>";
$body .= "<li><strong>Date:</strong> " . date("F j, Y", strtotime($d)) . "</li>";
$body .= "<li><strong>Time:</strong> $time</li>";
$body .= "</ul>";
$body .= "<p style='font-weight: bold; font-size: 20px;'>Reference Code: $reference</p>";
$body .= "<p>Thank you for your transaction!</p>";
$body .= "</body></html>";

$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'blazered098@gmail.com';
$smtpPassword = 'nnhthgjzjbdpilbh';

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer(true);

$mail->SMTPDebug = 0;

$mail->isSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;

$mail->setFrom($smtpUsername, 'Zephyris Skin Care');
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = $body;

$imagePath = 'img/dermalogo.png';
$mail->addEmbeddedImage($imagePath, 'dermalogo.png', 'dermalogo.png');

require 'fpdf/fpdf.php';
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Appointment Summary', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Name: ' . $firstname . ' ' . $lastname, 0, 1);
$pdf->Cell(0, 10, 'Phone number: ' . $num, 0, 1);
$pdf->Cell(0, 10, 'Email: ' . $email, 0, 1);
$pdf->Cell(0, 10, 'Message: ' . $message, 0, 1);
$pdf->Cell(0, 10, 'Option: ' . $option, 0, 1);
$pdf->Cell(0, 10, 'Date: ' . date("F j, Y", strtotime($d)), 0, 1);
$pdf->Cell(0, 10, 'Time: ' . $time, 0, 1);
$pdf->Cell(0, 10, 'Reference Code: ' . $reference, 0, 1);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Thank you for your transaction!', 0, 1);

$pdfData = $pdf->Output('appointment_summary.pdf', 'S');

$mail->addStringAttachment($pdfData, 'appointment_summary.pdf');

$mailSent = $mail->send();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Appointment Summary</title>
  <style>
  </style>
</head>
<body>
  <div class="container">
    <h2>Appointment Summary</h2>
    <p><strong>Name:</strong> <?php echo "$firstname $lastname"; ?></p>
    <p><strong>Phone number:</strong> <?php echo $num; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Message:</strong> <?php echo $message; ?></p>
    <p><strong>Option:</strong> <?php echo $option; ?></p>
    <p><strong>Date:</strong> <?php echo date("F j, Y", strtotime($d)); ?></p>
    <p><strong>Time:</strong> <?php echo $time; ?></p>
    <p><strong>Reference Code:</strong> <?php echo $reference; ?></p>
    <p>Thank you for your transaction!</p>
    <img src="fpdf/fpdf.php" alt="">
  </div>
</body>
</html>
