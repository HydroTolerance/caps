<?php
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_POST['htmlTable'])) {
    // Create a Dompdf instance
    $dompdf = new Dompdf();

    // Load the HTML content
    $html = '<html><body>';
    $html .= $_POST['htmlTable'];
    $html .= '</body></html>';

    $dompdf->loadHtml($html);

    // Set paper size and orientation (optional)
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Output the generated PDF as a download
    $dompdf->stream('datatable_data.pdf');
} else {
    // Handle the case where no HTML table data was received
    echo 'Error: No data received.';
}
?>
