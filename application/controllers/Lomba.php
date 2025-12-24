<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lomba extends CI_Controller
{
    /**
     * STEP 1
     * Form input nomor HP
     */
    public function claim()
    {
        $this->load->view('lomba/claim_form');
    }

    /**
     * STEP 2
     * Cek data peserta (BELUM generate voucher)
     */
public function cek()
{
    $no_hp = $this->input->post('no_hp', true);

    $peserta_list = $this->db
        ->where('no_hp', $no_hp)
        ->order_by('id', 'ASC')
        ->get('lt_lomba')
        ->result();

    if (empty($peserta_list)) {
        $this->session->set_flashdata('error', 'Data peserta tidak ditemukan.');
        redirect('lomba/claim');
    }

    // kirim SEMUA peserta dengan nomor HP ini
    $this->load->view('lomba/claim_preview', [
        'peserta_list' => $peserta_list,
        'no_hp'        => $no_hp
    ]);
}


    /**
     * STEP 3
     * Tombol CLAIM ditekan
     * Baru generate voucher jika belum ada
     */
    public function do_claim()
    {
        $id = $this->input->post('id');

        $peserta = $this->db
            ->where('id', $id)
            ->get('lt_lomba')
            ->row();

        if (!$peserta) {
            show_error('Data peserta tidak valid');
        }

        // VALIDASI 1 HP = 1 KLAIM
        if (!$peserta->kode_voucher) {

            $kode = $peserta->jenis_lomba . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            // simpan ke lt_lomba
            $this->db->where('id', $peserta->id)
                ->update('lt_lomba', [
                    'kode_voucher' => $kode
                ]);

            // simpan ke POS (pr_voucher)
            $this->db->insert('pr_voucher', [
                'kode_voucher'     => $kode,
                'jenis'            => 'persentase',
                'nilai'            => 20, // FIX 20%
                'min_pembelian'    => 0,
                'maksimal_voucher' => 1,
                'sisa_voucher'     => 1,
                'status'           => 'aktif',
                'tanggal_mulai'    => date('Y-m-d'),
                'tanggal_berakhir' => date('Y-m-d', strtotime('+14 days'))
            ]);
        }

        // redirect ke halaman voucher
        redirect('lomba/voucher/' . $peserta->id);
    }

    /**
     * STEP 4
     * Halaman voucher + download
     */
    public function voucher($id)
    {
        $peserta = $this->db
            ->select('l.*, v.tanggal_berakhir')
            ->from('lt_lomba l')
            ->join('pr_voucher v', 'v.kode_voucher = l.kode_voucher', 'left')
            ->where('l.id', $id)
            ->get()
            ->row();

        if (!$peserta || !$peserta->kode_voucher) {
            show_error('Voucher tidak ditemukan');
        }

        $this->load->view('lomba/claim_voucher', [
            'peserta' => $peserta
        ]);
    }
}
