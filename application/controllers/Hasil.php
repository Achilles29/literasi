<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('peserta_event_id')) {
            redirect('auth/token');
        }
    }

    public function index()
    {
        $peserta_event_id = $this->session->userdata('peserta_event_id');

        // =========================
        // INFO PESERTA & EVENT
        // =========================
        $info = $this->db
            ->select('pe.*, p.name, p.school_name, e.name AS event_name')
            ->from('peserta_event pe')
            ->join('peserta p', 'p.id = pe.peserta_id')
            ->join('events e', 'e.id = pe.event_id')
            ->where('pe.id', $peserta_event_id)
            ->get()
            ->row();

        if (!$info) {
            show_error('Data peserta tidak ditemukan');
        }

        // =========================
        // DETAIL JAWABAN
        // =========================
        $jawaban = $this->db->query("
            SELECT 
                q.text AS soal,
                q.category,
                MAX(CASE WHEN qo_all.label = 'A' THEN qo_all.text END) AS option_a,
                MAX(CASE WHEN qo_all.label = 'B' THEN qo_all.text END) AS option_b,
                MAX(CASE WHEN qo_all.label = 'C' THEN qo_all.text END) AS option_c,
                MAX(CASE WHEN qo_all.label = 'D' THEN qo_all.text END) AS option_d,
                qo_jawab.label AS jawaban,
                a.is_correct
            FROM answers a
            JOIN questions q ON q.id = a.question_id
            JOIN question_options qo_jawab ON qo_jawab.id = a.option_id
            JOIN question_options qo_all ON qo_all.question_id = q.id
            WHERE a.peserta_event_id = ?
              AND a.is_deleted = 0
            GROUP BY a.id, q.text, q.category, qo_jawab.label, a.is_correct
            ORDER BY q.order_number ASC
        ", [$peserta_event_id])->result();

        // =========================
        // JUMLAH JAWABAN BENAR
        // =========================
        $jumlah_benar = $this->db
            ->where('peserta_event_id', $peserta_event_id)
            ->where('is_correct', 1)
            ->where('is_deleted', 0)
            ->count_all_results('answers');

        // =========================
        // TOTAL SOAL
        // =========================
        $total_soal = $this->db
            ->where('event_id', $info->event_id)
            ->where('is_deleted', 0)
            ->count_all_results('questions');

        // =========================
        // JUMLAH BENAR PER KATEGORI
        // =========================
        $per_kategori = $this->db->query("
            SELECT q.category, COUNT(*) AS benar
            FROM answers a
            JOIN questions q ON q.id = a.question_id
            WHERE a.peserta_event_id = ?
              AND a.is_correct = 1
              AND a.is_deleted = 0
            GROUP BY q.category
        ", [$peserta_event_id])->result();

        // =========================
        // TOTAL SOAL PER KATEGORI
        // =========================
        $total_per_kategori = $this->db->query("
            SELECT q.category, COUNT(*) AS total
            FROM questions q
            WHERE q.event_id = ?
              AND q.is_deleted = 0
            GROUP BY q.category
        ", [$info->event_id])->result();

        // =========================
        // GABUNG NILAI KATEGORI
        // =========================
        $kategori_nilai = [];

        foreach ($total_per_kategori as $t) {
            $kategori_nilai[$t->category] = [
                'total'  => $t->total,
                'benar'  => 0,
                'persen' => 0
            ];
        }

        foreach ($per_kategori as $k) {
            if (isset($kategori_nilai[$k->category])) {
                $kategori_nilai[$k->category]['benar'] = $k->benar;
                $kategori_nilai[$k->category]['persen'] = round(
                    ($k->benar / $kategori_nilai[$k->category]['total']) * 100,
                    2
                );
            }
        }

        // =========================
        // NILAI AKHIR (2 DESIMAL)
        // =========================
        $nilai_total = $total_soal > 0
            ? round(($jumlah_benar / $total_soal) * 100, 2)
            : 0;

        // =========================
        // KIRIM KE VIEW
        // =========================
        $this->load->view('hasil/index', [
            'info'            => $info,
            'jawaban'         => $jawaban,
            'jumlah_benar'    => $jumlah_benar,
            'total_soal'      => $total_soal,
            'kategori_nilai'  => $kategori_nilai,
            'nilai_total'     => $nilai_total
        ]);
    }
}
