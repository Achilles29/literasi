<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Festival Literasi'; ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #6f1d1b, #3a0ca3);
            min-height: 100vh;
        }

        .hero {
            padding: 28px 20px 18px;
            text-align: center;
            color: #fff;
        }

        .hero-logos {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 12px;
            max-width: 520px;
            margin: 0 auto 10px;
        }

        .hero-logos img {
            height: 64px;
            /* 🔼 diperbesar sedikit */
        }

        .hero-title {
            text-align: center;
            line-height: 1.2;
        }

        .hero-title .instansi {
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .hero-title .kabupaten {
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Mobile tweak */
        @media (max-width: 480px) {
            .hero-logos img {
                height: 52px;
            }

            .hero-title .instansi {
                font-size: 0.8rem;
            }

            .hero-title .kabupaten {
                font-size: 0.9rem;
            }
        }

        .hero h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .hero p {
            font-size: 0.9rem;
            opacity: .9;
        }


        .hero img {
            height: 60px;
            margin-bottom: 10px;
        }


        .form-card {
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .25);
            margin-top: -20px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px 14px;
        }

        .btn-literasi {
            background: linear-gradient(135deg, #f77f00, #fcbf49);
            border: none;
            color: #000;
            font-weight: 600;
            padding: 14px;
            border-radius: 14px;
        }

        .btn-literasi:hover {
            opacity: .9;
        }

        .footer-note {
            font-size: 0.75rem;
            color: #555;
            text-align: center;
            margin-top: 10px;
        }

        label {
            font-weight: 600;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <!-- HERO -->
    <div class="hero">

        <div class="hero-logos">
            <!-- Logo Pemkab -->
            <img src="<?= base_url('assets/img/pemkab_rembang.png'); ?>" alt="Pemkab Rembang">

            <!-- Teks Tengah -->
            <div class="hero-title">
                <div class="instansi">PERPUSTAKAAN UMUM</div>
                <div class="kabupaten">KABUPATEN REMBANG</div>
            </div>

            <!-- Logo Perpusnas -->
            <img src="<?= base_url('assets/img/perpusnas.png'); ?>" alt="Perpusnas">
        </div>

        <h1 class="mt-2">Festival Literasi</h1>
        <p>Isi daftar hadir & dapatkan voucher Namua Coffee ☕</p>

    </div>



    <!-- FORM -->
    <div class="container px-3 pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">

                <div class="card form-card">
                    <div class="card-body p-4">

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger small">
                                <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('literasi/submit'); ?>">

                            <div class="mb-3">
                                <label><i class="bi bi-person"></i> Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Anda" required>
                            </div>

                            <div class="mb-3">
                                <label><i class="bi bi-gender-ambiguous"></i> Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label><i class="bi bi-whatsapp"></i> No. HP / WhatsApp</label>
                                <input type="tel" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                            </div>

                            <div class="mb-3">
                                <label><i class="bi bi-briefcase"></i> Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" placeholder="Pelajar / Guru / Umum">
                            </div>

                            <div class="mb-3">
                                <label><i class="bi bi-mortarboard"></i> Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" class="form-select">
                                    <option value="">Pilih Pendidikan</option>
                                    <option>SD</option>
                                    <option>SMP</option>
                                    <option>SMA</option>
                                    <option>D3</option>
                                    <option>S1</option>
                                    <option>S2</option>
                                    <option>S3</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label><i class="bi bi-geo-alt"></i> Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat singkat"></textarea>
                            </div>

                            <button type="submit" class="btn btn-literasi w-100">
                                🎁 Daftar & Dapatkan Voucher
                            </button>

                            <div class="footer-note mt-3">
                                Voucher berlaku di <strong>Namua Coffee & Eatery</strong><br>
                                Berlaku 14 hari sejak pendaftaran
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>