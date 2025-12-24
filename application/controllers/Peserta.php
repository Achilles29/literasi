<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peserta extends CI_Controller
{
    public function mapel()
    {
        $q     = trim($this->input->get('q', true) ?? '');
        $page  = (int) ($this->input->get('page') ?? 1);
        $limit = 50; // DEFAULT 50
        $offset = ($page - 1) * $limit;

        // ===== QUERY DASAR =====
        $this->db->from('lt_lomba');
        $this->db->where('jenis_lomba', 'MAPEL');

        if ($q !== '') {
            $this->db->group_start()
                ->like('nama', $q)
                ->or_like('asal_sekolah', $q)
                ->or_like('kelas', $q)
                ->or_like('no_hp', $q)
                ->group_end();
        }

        // ===== HITUNG TOTAL =====
        $total = $this->db->count_all_results('', false);

        // ===== URUTAN KELAS → NAMA =====
        // Mapping kelas supaya urut benar
        $this->db->order_by("
        CASE kelas
            WHEN 'Kelas I' THEN 1
            WHEN 'Kelas II' THEN 2
            WHEN 'Kelas III' THEN 3
            WHEN 'Kelas IV' THEN 4
            WHEN 'Kelas V' THEN 5
            WHEN 'Kelas VI' THEN 6
            ELSE 99
        END
    ", '', false);

        $this->db->order_by('nama', 'ASC');
        $this->db->limit($limit, $offset);

        $peserta = $this->db->get()->result();

        $data = [
            'title'       => 'Peserta MAPEL',
            'peserta'     => $peserta,
            'page'        => $page,
            'limit'       => $limit,
            'total'       => $total,
            'total_pages' => ceil($total / $limit),
            'keyword'     => $q
        ];

        // AJAX request → hanya tabel
        if ($this->input->is_ajax_request()) {
            $this->load->view('peserta/_mapel_table', $data);
        } else {
            $this->load->view('peserta/mapel', $data);
        }
    }


    public function mewarnai()
    {
        $q     = trim($this->input->get('q', true) ?? '');
        $page  = (int) ($this->input->get('page') ?? 1);
        $limit = 50; // DEFAULT 50
        $offset = ($page - 1) * $limit;

        // ===== QUERY DASAR =====
        $this->db->from('lt_lomba');
        $this->db->where('jenis_lomba', 'MEWARNAI');

        if ($q !== '') {
            $this->db->group_start()
                ->like('nama', $q)
                ->or_like('asal_sekolah', $q)
                ->or_like('kelas', $q)
                ->or_like('no_hp', $q)
                ->group_end();
        }

        // ===== HITUNG TOTAL =====
        $total = $this->db->count_all_results('', false);

        // ===== URUTAN KELAS → NAMA =====
        // Mapping kelas supaya urut benar
        $this->db->order_by("
        CASE kelas
            WHEN 'Kelas I' THEN 1
            WHEN 'Kelas II' THEN 2
            WHEN 'Kelas III' THEN 3
            WHEN 'Kelas IV' THEN 4
            WHEN 'Kelas V' THEN 5
            WHEN 'Kelas VI' THEN 6
            ELSE 99
        END
    ", '', false);

        $this->db->order_by('nama', 'ASC');
        $this->db->limit($limit, $offset);

        $peserta = $this->db->get()->result();

        $data = [
            'title'       => 'Peserta MEWARNAI',
            'peserta'     => $peserta,
            'page'        => $page,
            'limit'       => $limit,
            'total'       => $total,
            'total_pages' => ceil($total / $limit),
            'keyword'     => $q
        ];

        // AJAX request → hanya tabel
        if ($this->input->is_ajax_request()) {
            $this->load->view('peserta/_mewarnai_table', $data);
        } else {
            $this->load->view('peserta/mewarnai', $data);
        }
    }
}
