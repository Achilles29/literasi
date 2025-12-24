<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Voucher Festival Literasi'; ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- html2canvas -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
        body {
            background: linear-gradient(180deg, #6f1d1b, #3a0ca3);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system;
        }

        /* ===== HERO ===== */
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
            height: 50px;
        }

        .hero-title {
            line-height: 1.2;
        }

        .hero-title .instansi {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .hero-title .kabupaten {
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* ===== EXPORT AREA ===== */
        .voucher-wrapper {
            margin-top: -18px;
            padding-bottom: 40px;
        }

        #voucherCanvas {
            max-width: 360px;
            margin: auto;
            border-radius: 26px;
            overflow: hidden;
            background: linear-gradient(160deg, #7b1e1e, #8d1b3d, #3a0ca3);
            color: #fff;
            box-shadow: 0 20px 55px rgba(0, 0, 0, .45);
            position: relative;
        }

        /* Decorative blobs */
        #voucherCanvas::before {
            content: "";
            position: absolute;
            top: -60px;
            right: -60px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, .08);
            border-radius: 50%;
        }

        #voucherCanvas::after {
            content: "";
            position: absolute;
            bottom: -70px;
            left: -70px;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
        }

        .voucher-top {
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .voucher-top img {
            height: 34px;
        }

        .voucher-event {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: .9;
        }

        .voucher-body {
            padding: 32px 24px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .voucher-discount {
            font-size: 3.2rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 4px;
        }

        .voucher-discount span {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .voucher-label {
            font-size: .75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: .9;
        }

        .voucher-code {
            background: #ffffff;
            color: #000;
            border-radius: 16px;
            padding: 14px 12px;
            margin: 22px 0;
        }

        .voucher-code small {
            font-size: .7rem;
            color: #666;
            display: block;
        }

        .voucher-code h4 {
            margin: 2px 0 0;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .voucher-info {
            font-size: .8rem;
            opacity: .95;
        }

        .voucher-footer {
            padding: 16px 18px;
            background: rgba(0, 0, 0, .18);
            font-size: .7rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .btn-download {
            background: linear-gradient(135deg, #f77f00, #fcbf49);
            border: none;
            color: #000;
            font-weight: 700;
            padding: 14px;
            border-radius: 14px;
            width: 100%;
        }

        .btn-download:hover {
            opacity: .9;
        }
    </style>
</head>

<body>

    <!-- HERO -->
    <div class="hero">
        <div class="hero-logos">
            <img src="<?= base_url('assets/img/pemkab_rembang.png'); ?>" alt="Pemkab Rembang">

            <div class="hero-title">
                <div class="instansi">PERPUSTAKAAN UMUM</div>
                <div class="kabupaten">KABUPATEN REMBANG</div>
            </div>

            <img src="<?= base_url('assets/img/perpusnas.png'); ?>" alt="Perpusnas">
        </div>

        <h1 class="mt-2">Voucher Festival Literasi</h1>
        <p>Simpan voucher ini & tunjukkan ke kasir</p>
    </div>

    <!-- VOUCHER -->
    <div class="container voucher-wrapper px-3">
        <div class="row justify-content-center">
            <div class="col-12">

                <!-- AREA YANG DIEKSPORT -->
                <div id="voucherCanvas">

                    <div class="voucher-top">
                        <img src="<?= base_url('assets/img/namua_logo.png'); ?>" alt="Namua">
                        <div class="voucher-event">Festival Literasi</div>
                    </div>

                    <div class="voucher-body">
                        <div class="voucher-discount">
                            <?= $voucher->nilai; ?><span>%</span>
                        </div>
                        <div class="voucher-label">Diskon Spesial</div>

                        <div class="voucher-code">
                            <small>KODE VOUCHER</small>
                            <h4><?= $voucher->kode_voucher; ?></h4>
                        </div>

                        <div class="voucher-info">
                            Berlaku hingga<br>
                            <strong><?= date('d M Y', strtotime($voucher->tanggal_berakhir)); ?></strong>
                        </div>
                    </div>

                    <div class="voucher-footer">
                        Berlaku 1x transaksi • Tidak digabung promo lain<br>
                        <strong>Namua Coffee & Eatery</strong>
                    </div>

                </div>

                <button class="btn-download mt-4" onclick="downloadVoucher()">
                    <i class="bi bi-download"></i> Download Voucher (PNG)
                </button>

            </div>
        </div>
    </div>

    <script>
        function downloadVoucher() {
            const element = document.getElementById('voucherCanvas');

            html2canvas(element, {
                scale: 3,
                backgroundColor: null,
                useCORS: true
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = '<?= $voucher->kode_voucher; ?>.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>

</body>

</html>