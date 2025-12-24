<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {

    protected $dompdf;

    public function __construct()
    {
        $options = new Options();

        // WAJIB
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // IZINKAN AKSES FILE LOKAL
        $options->set('chroot', FCPATH);

        $this->dompdf = new Dompdf($options);
    }

    public function loadHtml($html)
    {
        $this->dompdf->loadHtml($html);
    }

    public function setPaper($size = 'A4', $orientation = 'portrait')
    {
        $this->dompdf->setPaper($size, $orientation);
    }

    public function render()
    {
        $this->dompdf->render();
    }

    public function output()
    {
        return $this->dompdf->output();
    }
}
