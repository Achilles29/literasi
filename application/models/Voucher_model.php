<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher_model extends CI_Model
{
    /**
     * Generate kode voucher unik
     * Format: LITERASI-XXXXXX
     */
    public function generate_kode()
    {
        return 'LITERASI-' . strtoupper(substr(md5(uniqid()), 0, 6));
    }

    /**
     * Simpan voucher ke tabel pr_voucher
     */
    public function create_voucher($kode_voucher)
    {
        $data = [
            'kode_voucher'      => $kode_voucher,
            'jenis'             => 'persentase',
            'nilai'             => 10,
            'min_pembelian'     => 0,
            'maksimal_voucher'  => 1,
            'sisa_voucher'      => 1,
            'status'            => 'aktif',
            'tanggal_mulai'     => date('Y-m-d'),
            'tanggal_berakhir'  => date('Y-m-d', strtotime('+14 days')),
        ];

        return $this->db->insert('pr_voucher', $data);
    }

    /**
     * Ambil voucher berdasarkan kode
     */
    public function get_voucher_by_kode($kode)
    {
        return $this->db
            ->where('kode_voucher', $kode)
            ->get('pr_voucher')
            ->row();
    }
}
