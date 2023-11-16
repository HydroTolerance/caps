<?php
require 'vendor/autoload.php'; // Adjust the path based on your project structure

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// HTML content
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HTML to PDF Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        h1 {
            color: #007BFF;
        }
    </style>
</head>
<body>
    <h1>Hello, World!</h1>
    <p>This is an example PDF generated from HTML and CSS using Dompdf.</p>
</body>
</html>
';

// Load HTML into Dompdf
$dompdf->loadHtml($html);

// Set paper size (optional)
$dompdf->setPaper('A4', 'portrait');

// Render PDF (first pass to get total pages)
$dompdf->render();

// Output PDF
$dompdf->stream('output.pdf', ['Attachment' => false]);
