<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Literasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Voucher_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    /**
     * Halaman Form Daftar Hadir
     * URL: /literasi
     */
    public function index()
    {
        $data['title'] = 'Daftar Hadir Festival Literasi';

        $this->load->view('literasi/form', $data);
    }

    /**
     * Proses Submit Daftar Hadir
     * URL: /literasi/submit
     */
    public function submit()
    {
        // ================= VALIDASI =================
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Data belum lengkap.');
            redirect('literasi');
        }

        $no_hp = $this->input->post('no_hp', TRUE);

        // ====== CEK NO HP SUDAH PERNAH DAFTAR ======
        $cek = $this->db
            ->where('no_hp', $no_hp)
            ->get('lt_pengunjung')
            ->row();

        if ($cek) {
            $this->session->set_flashdata(
                'error',
                'Nomor HP ini sudah terdaftar dan sudah mendapatkan voucher.'
            );
            redirect('literasi/voucher/' . $cek->kode_voucher);
        }

        // ================= GENERATE VOUCHER =================
        $kode_voucher = $this->Voucher_model->generate_kode();

        // ================= SIMPAN PENGUNJUNG =================
        $this->db->insert('lt_pengunjung', [
            'nama' => $this->input->post('nama', TRUE),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
            'no_hp' => $no_hp,
            'pekerjaan' => $this->input->post('pekerjaan', TRUE),
            'pendidikan_terakhir' => $this->input->post('pendidikan_terakhir', TRUE),
            'alamat' => $this->input->post('alamat', TRUE),
            'kode_voucher' => $kode_voucher,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // ================= SIMPAN VOUCHER KE POS =================
        $this->Voucher_model->create_voucher($kode_voucher);

        // ================= REDIRECT =================
        $this->session->set_flashdata(
            'success',
            'Pendaftaran berhasil! Voucher Anda siap digunakan.'
        );

        redirect('literasi/voucher/' . $kode_voucher);
    }

    /**
     * Halaman Voucher
     * URL: /literasi/voucher/{kode}
     */
    public function voucher($kode_voucher = null)
    {
        if (!$kode_voucher) {
            show_404();
        }

        $voucher = $this->Voucher_model->get_voucher_by_kode($kode_voucher);

        if (!$voucher) {
            show_404();
        }

        $pengunjung = $this->db
            ->where('kode_voucher', $kode_voucher)
            ->get('lt_pengunjung')
            ->row();

        $data = [
            'title'      => 'Voucher Festival Literasi',
            'voucher'    => $voucher,
            'pengunjung' => $pengunjung
        ];

        $this->load->view('literasi/voucher', $data);
    }

    public function qr()
    {
        $this->load->view('literasi/qr');
    }
}
