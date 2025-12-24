<!DOCTYPE html>
<html>

<head>
    <title>Hasil Lomba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .result-card {
            border-radius: 12px;
        }

        .score-box {
            background: linear-gradient(135deg, #d1f2eb, #e8f8f5);
            border-radius: 12px;
        }

        .score-value {
            font-size: 2rem;
            font-weight: 700;
            color: #198754;
        }

        table thead th {
            background: #f1f3f5;
            font-size: .8rem;
            text-transform: uppercase;
        }

        @media (max-width:768px) {
            .score-value {
                font-size: 1.6rem;
            }

            table {
                font-size: .85rem;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex">

        <?php $this->load->view('templates/sidebar'); ?>

        <div class="flex-grow-1">

            <!-- MOBILE BAR -->
            <div class="d-md-none bg-white border-bottom p-2 d-flex align-items-center">
                <button class="btn btn-outline-secondary btn-sm me-2"
                    onclick="toggleSidebar()">☰</button>
                <strong class="small">Hasil Lomba</strong>
            </div>

            <main class="p-3 p-md-4">

                <!-- RINGKASAN -->
                <div class="card mb-4 shadow-sm result-card">
                    <div class="card-body">
                        <h5 class="mb-3"><?= $info->event_name ?></h5>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <div><strong>Nama:</strong> <?= $info->name ?></div>
                                <div><strong>Sekolah:</strong> <?= $info->school_name ?></div>
                                <div>
                                    <strong>Jawaban Benar:</strong>
                                    <?= $jumlah_benar ?> / <?= $total_soal ?>
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                <div class="score-box p-3">
                                    <small class="text-muted">Nilai Akhir</small>
                                    <div class="score-value">
                                        <?= number_format($nilai_total, 2) ?>
                                    </div>
                                    <small class="text-muted">Skala 100</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PER KATEGORI -->
                <div class="card mb-4 shadow-sm result-card">
                    <div class="card-header fw-semibold">Nilai per Kategori</div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th class="text-center">Hasil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kategori_nilai as $k => $v): ?>
                                    <tr>
                                        <td><?= ucfirst($k) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">
                                                <?= number_format($v['persen'], 2) ?>%
                                            </span>
                                            <div class="text-muted small">
                                                (<?= $v['benar'] ?>/<?= $v['total'] ?>)
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- DETAIL -->
                <div class="card shadow-sm result-card">
                    <div class="card-header fw-semibold">Detail Jawaban</div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Soal</th>
                                    <th>Kategori</th>
                                    <th>A</th>
                                    <th>B</th>
                                    <th>C</th>
                                    <th>D</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jawaban as $i => $j): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $j->soal ?></td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                <?= ucfirst($j->category) ?>
                                            </span>
                                        </td>
                                        <td><?= $j->option_a ?></td>
                                        <td><?= $j->option_b ?></td>
                                        <td><?= $j->option_c ?></td>
                                        <td><?= $j->option_d ?></td>
                                        <td class="text-center">
                                            <?= $j->is_correct
                                                ? '<span class="badge bg-success">Benar</span>'
                                                : '<span class="badge bg-danger">Salah</span>' ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar')
                .classList.toggle('collapsed');
        }
    </script>

</body>

</html>