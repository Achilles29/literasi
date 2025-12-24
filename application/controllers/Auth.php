<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function token()
    {
        $this->load->view('auth/token_login');
    }

    public function token_login()
    {
        $token = trim($this->input->post('token', true));

        if (!$token) {
            $this->session->set_flashdata('error', 'Token wajib diisi');
            redirect('auth/token');
        }

        $peserta_event = $this->db
            ->select('pe.*, p.name, p.school_name, e.name AS event_name')
            ->from('peserta_event pe')
            ->join('peserta p', 'p.id = pe.peserta_id')
            ->join('events e', 'e.id = pe.event_id')
            ->where('pe.token', $token)
            ->where('pe.is_deleted', 0)
            ->where('p.is_deleted', 0)
            ->get()
            ->row();

        if (!$peserta_event) {
            $this->session->set_flashdata('error', 'Token tidak ditemukan');
            redirect('auth/token');
        }

        if ($peserta_event->status !== 'finished') {
            $this->session->set_flashdata('error', 'Lomba belum selesai');
            redirect('auth/token');
        }

        // Simpan session
        $this->session->set_userdata('peserta_event_id', $peserta_event->id);

        redirect('hasil');
    }

    public function logout()
    {
        $this->session->unset_userdata('peserta_event_id');
        redirect('auth/token');
    }
}
