<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sertifikat extends CI_Controller
{
    private function get_peserta($id)
    {
        $peserta = $this->db->get_where('lt_lomba', ['id' => $id])->row();
        if (!$peserta) show_error('Peserta tidak ditemukan', 404);
        return $peserta;
    }

    private function get_template_view($jenis_lomba)
    {
        $map = [
            'PIDATO'   => 'sertifikat/sertifikat_pidato',
            'STORY'    => 'sertifikat/sertifikat_story',
            'MAPEL'    => 'sertifikat/sertifikat_mapel',
            'MEWARNAI' => 'sertifikat/sertifikat_mewarnai',
            'REELS'    => 'sertifikat/sertifikat_reels',
        ];

        if (!isset($map[$jenis_lomba])) {
            show_error(
                'Template sertifikat belum tersedia untuk lomba: ' . $jenis_lomba,
                404
            );
        }

        return $map[$jenis_lomba];
    }
    public function preview($id = null)
    {
        if (!$id) show_error('ID peserta tidak valid', 404);

        $peserta = $this->get_peserta($id);
        $view    = $this->get_template_view($peserta->jenis_lomba);

        $this->load->view($view, [
            'peserta' => $peserta,
            'mode'    => 'preview'
        ]);
    }



    /**
     * DOWNLOAD PDF
     */
    public function download_pdf($id = null)
    {
        if (!$id) show_error('ID peserta tidak valid', 404);

        $peserta = $this->get_peserta($id);
        $view    = $this->get_template_view($peserta->jenis_lomba);

        // ⬇️ RENDER KHUSUS PDF (MODE pdf)
        $html = $this->load->view($view, [
            'peserta' => $peserta,
            'mode'    => 'pdf'
        ], true);

        $this->load->library('pdf');

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();

        $filename = 'Sertifikat_' . strtoupper(
            preg_replace('/[^A-Z0-9]/', '_', $peserta->nama)
        ) . '.pdf';

        // ⬇️ JANGAN stream()
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $this->pdf->output();
        exit;
    }

    /**
     * DOWNLOAD PNG (client side) - html2canvas
     */

    public function download_png($id = null)
    {
        if (!$id) show_error('ID peserta tidak valid', 404);

        $peserta = $this->get_peserta($id);
        $view    = $this->get_template_view($peserta->jenis_lomba);

        // Render halaman sertifikat KHUSUS MODE PNG
        // Tidak load Pdf library sama sekali
        $this->load->view($view, [
            'peserta' => $peserta,
            'mode'    => 'png'
        ]);
    }

    public function download_piagam($filename)
    {
        $path = FCPATH . 'assets/img/' . $filename;

        if (!file_exists($path)) {
            show_404();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
}
