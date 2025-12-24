<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Peserta Lomba</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #6f1d1b, #3a0ca3);
            min-height: 100vh;
            font-family: system-ui;
        }

        .card-box {
            max-width: 420px;
            margin: 80px auto;
            background: #fff;
            border-radius: 22px;
            padding: 28px;
            text-align: center;
        }

        .btn-main {
            background: linear-gradient(135deg, #f77f00, #fcbf49);
            border: none;
            font-weight: 700;
            border-radius: 14px;
            padding: 14px;
        }
    </style>
</head>

<body>

    <div class="card-box">

        <!-- LOGO -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <img src="<?= base_url('assets/img/pemkab_rembang.png'); ?>" height="48">
            <img src="<?= base_url('assets/img/perpusnas.png'); ?>" height="48">
        </div>

        <h4 class="fw-bold">Cek Peserta Lomba</h4>
        <p class="small text-muted">
            Festival Literasi<br>Perpustakaan Umum Kabupaten Rembang
        </p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger small">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('lomba/cek'); ?>">
            <input type="tel" name="no_hp" class="form-control mb-3"
                placeholder="Masukkan Nomor HP Peserta" required>

            <button class="btn btn-main w-100">
                Cek Data Peserta
            </button>
        </form>

    </div>

</body>

</html>