<?php
$warna = [
    'MAPEL' => 'linear-gradient(135deg,#1e3c72,#2a5298)',
    'STORY' => 'linear-gradient(135deg,#6a11cb,#2575fc)',
    'MEWARNAI' => 'linear-gradient(135deg,#f7971e,#ffd200)',
    'PIDATO' => 'linear-gradient(135deg,#7b1e1e,#b93a3a)',
    'REELS' => 'linear-gradient(135deg,#11998e,#38ef7d)'
];
$bg = $warna[$peserta->jenis_lomba] ?? '#333';
$valid_until = !empty($peserta->valid_until)
    ? date('d M Y', strtotime($peserta->valid_until))
    : '-';

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
        body {
            background: linear-gradient(180deg, #6f1d1b, #3a0ca3);
            min-height: 100vh;
        }

        .voucher {
            max-width: 360px;
            margin: 50px auto;
            border-radius: 24px;
            background: <?= $bg ?>;
            color: #fff;
            padding: 26px;
            text-align: center;
        }

        .kode {
            background: #fff;
            color: #000;
            border-radius: 14px;
            padding: 12px;
            margin: 18px 0;
            font-weight: 800;
        }

        .btn-main {
            background: linear-gradient(135deg, #f77f00, #fcbf49);
            border: none;
            font-weight: 700;
            border-radius: 14px;
            padding: 14px;
            width: 100%;
        }
    </style>
</head>

<body>

    <div id="voucherCanvas" class="voucher">

        <img src="<?= base_url('assets/img/namua_logo.png'); ?>" height="40">

        <h5 class="mt-2"><?= $peserta->jenis_lomba; ?></h5>
        <div class="display-4 fw-bold">20%</div>
        <div>Diskon Namua Coffee</div>

        <div class="kode"><?= $peserta->kode_voucher; ?></div>

        <div class="mt-2">
            <small class="opacity-75">Berlaku sampai</small>
            <div class="fw-semibold">
                <?= !empty($peserta->tanggal_berakhir)
                    ? date('d M Y', strtotime($peserta->tanggal_berakhir))
                    : '-' ?>
            </div>
        </div>

        <hr class="border-light opacity-25">

        <small>Atas nama</small>
        <div class="fw-bold"><?= $peserta->nama; ?></div>


    </div>

    <div class="container">
        <button class="btn-main" onclick="downloadVoucher()">
            Download Voucher (PNG)
        </button>
    </div>

    <script>
        function downloadVoucher() {
            html2canvas(document.getElementById('voucherCanvas'), {
                scale: 3
            }).then(c => {
                let a = document.createElement('a');
                a.href = c.toDataURL();
                a.download = '<?= $peserta->kode_voucher ?>.png';
                a.click();
            });
        }
    </script>

</body>

</html>