<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
$dompdf = new Dompdf;

// Load HTML content into Dompdf
$html = '<html><body><h1>Hello, Dompdf!</h1></body></html>';
$dompdf->loadHtml($html);

// Set paper size and orientation (optional)
$dompdf->setPaper('A4', 'portrait');

// Render the PDF (optional, but recommended)
$dompdf->render();

// Output the generated PDF to the browser
$dompdf->stream();
