<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leaderboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Wajib login via token
        if (!$this->session->userdata('peserta_event_id')) {
            redirect('auth/token');
        }
    }

    public function index()
    {
        $peserta_event_id = $this->session->userdata('peserta_event_id');

        // =========================
        // DATA PESERTA AKTIF
        // =========================
        $current = $this->db
            ->select('pe.event_id, p.level')
            ->from('peserta_event pe')
            ->join('peserta p', 'p.id = pe.peserta_id')
            ->where('pe.id', $peserta_event_id)
            ->where('pe.is_deleted', 0)
            ->get()
            ->row();

        if (!$current) {
            show_error('Peserta event tidak ditemukan');
        }

        // =========================
        // INFO EVENT
        // =========================
        $event = $this->db
            ->where('id', $current->event_id)
            ->where('is_deleted', 0)
            ->get('events')
            ->row();

        if (!$event) {
            show_error('Event tidak ditemukan');
        }

        // =========================
        // LEADERBOARD (REAL SCORE)
        // skor = (jawaban benar / 75) * 100
        // =========================
        $leaderboard = $this->db->query("
            SELECT 
                p.name,
                p.school_name,
                p.level,
                COUNT(a.id) AS benar,
                pe.duration_seconds
            FROM peserta_event pe
            JOIN peserta p ON p.id = pe.peserta_id
            LEFT JOIN answers a 
                ON a.peserta_event_id = pe.id
                AND a.is_correct = 1
                AND a.is_deleted = 0
            WHERE pe.event_id = ?
              AND p.level = ?
              AND pe.is_deleted = 0
            GROUP BY pe.id
            ORDER BY 
                benar DESC,
                pe.duration_seconds ASC
        ", [
            $current->event_id,
            $current->level
        ])->result();

        // =========================
        // KIRIM KE VIEW
        // =========================
        $this->load->view('leaderboard/index', [
            'event'       => $event,
            'level'       => $current->level,
            'leaderboard' => $leaderboard
        ]);
    }
}
