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

// Gmail SMTP configuration
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'blazered098@gmail.com'; // Replace with your Gmail email address
$smtpPassword = 'nnhthgjzjbdpilbh'; // Replace with your Gmail password

// Create a new PHPMailer instance
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer(true);

// Enable SMTP debugging (optional)
$mail->SMTPDebug = 0;

// Set the SMTP parameters for Gmail
$mail->isSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;

// Set the email parameters
$mail->setFrom($smtpUsername, 'Zephyris Skin Care');
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->isHTML(true); // Set the email body as HTML
$mail->Body = $body;

// Add image attachment
$imagePath = 'img/dermalogo.png'; // Replace with the path to your image file
// Embed image in email
$mail->addEmbeddedImage($imagePath, 'dermalogo.png', 'dermalogo.png'); // Attach the image and assign it a content ID (CID)

// Create a new PDF object
require 'fpdf/fpdf.php';
$pdf = new FPDF();
$pdf->AddPage();

// Add content to the PDF
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

// Save the PDF to a variable
$pdfData = $pdf->Output('appointment_summary.pdf', 'S');

// Attach the PDF to the email
$mail->addStringAttachment($pdfData, 'appointment_summary.pdf');

// Send the email
$mailSent = $mail->send();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Appointment Summary</title>
  <style>
    /* CSS styles omitted for brevity */
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
