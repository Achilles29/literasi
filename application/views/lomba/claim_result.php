<?php
$warna = [
    'MAPEL'    => 'linear-gradient(135deg,#1e3c72,#2a5298)',
    'STORY'    => 'linear-gradient(135deg,#6a11cb,#2575fc)',
    'MEWARNAI' => 'linear-gradient(135deg,#f7971e,#ffd200)',
    'PIDATO'   => 'linear-gradient(135deg,#7b1e1e,#b93a3a)',
    'REELS'    => 'linear-gradient(135deg,#11998e,#38ef7d)'
];
$bg = $warna[$peserta->jenis_lomba] ?? '#333';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voucher Lomba</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
        body {
            background: linear-gradient(180deg, #6f1d1b, #3a0ca3);
            min-height: 100vh;
            font-family: system-ui, -apple-system;
        }

        .voucher-box {
            max-width: 360px;
            margin: 50px auto;
            border-radius: 24px;
            overflow: hidden;
            color: #fff;
            background: <?= $bg ?>;
            box-shadow: 0 20px 55px rgba(0, 0, 0, .45);
        }

        .voucher-body {
            padding: 28px 22px;
            text-align: center;
        }

        .voucher-body h2 {
            font-size: 1.2rem;
            font-weight: 800;
        }

        .kode {
            background: #fff;
            color: #000;
            border-radius: 14px;
            padding: 12px;
            margin: 18px 0;
            font-weight: 800;
            letter-spacing: 1px;
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
    </style>
</head>

<body>

    <div id="voucherCanvas" class="voucher-box">

        <div class="voucher-body">
            <h2><?= strtoupper($peserta->jenis_lomba); ?></h2>
            <div class="small mb-2">Festival Literasi</div>

            <div class="display-5 fw-bold mb-2">10%</div>
            <div>Diskon Namua Coffee</div>

            <div class="kode"><?= $peserta->kode_voucher; ?></div>

            <div class="small">
                Atas nama:<br>
                <strong><?= $peserta->nama; ?></strong>
            </div>
        </div>

    </div>

    <div class="container mt-4">
        <button class="btn-download" onclick="downloadVoucher()">
            Download Voucher (PNG)
        </button>
    </div>

    <script>
        function downloadVoucher() {
            html2canvas(document.getElementById('voucherCanvas'), {
                scale: 3,
                backgroundColor: null
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = '<?= $peserta->kode_voucher; ?>.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>

</body>

</html>