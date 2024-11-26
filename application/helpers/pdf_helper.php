<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

if (!function_exists('generate_pdf')) {
    function generate_pdf($html, $filename = '', $paper = 'A4', $orientation = 'portrait')
    {
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper($paper, $orientation);

        $dompdf->render();

        if (empty($filename)) {
            $filename = 'document.pdf';
        } else {
            $filename .= '.pdf';
        }

        $dompdf->stream($filename, array('Attachment' => 0));
    }
}
