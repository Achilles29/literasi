<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }

        .leaderboard-card {
            border-radius: 12px;
            overflow: hidden;
        }

        .rank-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #fff;
        }

        .rank-1 {
            background: linear-gradient(135deg, #f6d365, #fda085);
        }

        .rank-2 {
            background: linear-gradient(135deg, #cfd9df, #e2ebf0);
            color: #000;
        }

        .rank-3 {
            background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
        }

        .nilai-badge {
            font-size: .9rem;
            font-weight: 600;
        }

        table thead th {
            background: #f1f3f5;
            text-transform: uppercase;
            font-size: .8rem;
            letter-spacing: .04em;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        @media (max-width: 768px) {
            .nilai-badge {
                font-size: .85rem;
            }

            table {
                font-size: .85rem;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex">

        <!-- SIDEBAR -->
        <?php $this->load->view('templates/sidebar'); ?>

        <!-- CONTENT -->
        <div class="flex-grow-1">

            <!-- MOBILE TOP BAR -->
            <div class="d-md-none bg-white border-bottom p-2 d-flex align-items-center">
                <button class="btn btn-outline-secondary btn-sm me-2"
                    onclick="toggleSidebar()">☰</button>
                <strong class="small">Leaderboard</strong>
            </div>

            <main class="p-3 p-md-4">

                <!-- HEADER -->
                <div class="card mb-4 leaderboard-card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-1"><?= $event->name ?></h5>
                        <span class="badge bg-primary"><?= $level ?></span>
                        <p class="text-muted mb-0 small">
                            Peringkat berdasarkan <strong>nilai (skala 100)</strong> dan durasi pengerjaan
                        </p>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="card leaderboard-card shadow-sm">
                    <div class="table-responsive">

                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="70">Rank</th>
                                    <th>Nama Peserta</th>
                                    <th>Sekolah</th>
                                    <th class="text-center" width="120">Nilai</th>
                                    <th class="text-center" width="100">Durasi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($leaderboard as $i => $row): ?>
                                    <?php
                                    $nilai = ($row->benar ?? 0) > 0
                                        ? round(($row->benar / 75) * 100, 2)
                                        : 0;

                                    $rankClass = $i == 0 ? 'rank-1' : ($i == 1 ? 'rank-2' : ($i == 2 ? 'rank-3' : ''));
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if ($i < 3): ?>
                                                <span class="rank-badge <?= $rankClass ?>">
                                                    <?= $i + 1 ?>
                                                </span>
                                            <?php else: ?>
                                                <strong><?= $i + 1 ?></strong>
                                            <?php endif; ?>
                                        </td>

                                        <td class="fw-semibold">
                                            <?= strtoupper($row->name) ?>
                                        </td>

                                        <td><?= $row->school_name ?></td>

                                        <td class="text-center">
                                            <span class="badge bg-success nilai-badge">
                                                <?= number_format($nilai, 2) ?>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <?= gmdate('i:s', $row->duration_seconds) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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