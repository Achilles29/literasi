<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Daftar Hadir Festival Literasi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- QRCode -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    <!-- html2canvas -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #6f1d1b, #3a0ca3);
            min-height: 100vh;
            font-family: system-ui, -apple-system;
            color: #000;
        }

        .qr-wrapper {
            max-width: 520px;
            margin: 40px auto;
            padding: 28px 26px 32px;
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .35);
            text-align: center;
        }

        .qr-header {
            display: grid;
            grid-template-columns: 80px 1fr 80px;
            align-items: center;
            margin-bottom: 18px;
        }

        .qr-header img {
            height: 52px;
            margin: auto;
        }

        .qr-title h1 {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 2px;
        }

        .qr-title p {
            font-size: .95rem;
            margin: 0;
        }

        /* QR CENTER FIX */
        .qr-center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 28px 0 22px;
        }

        #qrcode {
            padding: 14px;
            background: #fff;
            border-radius: 16px;
        }

        .qr-footer {
            font-size: .95rem;
            margin-top: 10px;
        }

        .qr-footer strong {
            display: block;
            margin-top: 4px;
        }


        .qr-title {
            line-height: 1.25;
        }



        .btn-download {
            max-width: 520px;
            margin: 10px auto 40px;
            display: block;
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

    <!-- QR CARD -->
    <div id="qrCanvas" class="qr-wrapper">

        <!-- HEADER -->
        <div class="qr-header">
            <img src="<?= base_url('assets/img/pemkab_rembang.png'); ?>" alt="Pemkab Rembang">

            <div class="qr-title">
                <h1>Festival Literasi</h1>
                <p>Perpustakaan Umum<br>Kabupaten Rembang</p>
            </div>

            <img src="<?= base_url('assets/img/perpusnas.png'); ?>" alt="Perpusnas">
        </div>

        <!-- QR CENTER (FIX SIMETRI) -->
        <div class="qr-center">
            <div id="qrcode"></div>
        </div>

        <!-- FOOTER -->
        <div class="qr-footer">
            Scan QR ini untuk mengisi
            <strong>Daftar Hadir Festival Literasi</strong>
        </div>

    </div>


    <button class="btn-download" onclick="downloadQR()">
        ⬇️ Download QR Code (PNG)
    </button>

    <script>
        const url = "https://literasi.rembangkab.cloud";

        new QRCode(document.getElementById("qrcode"), {
            text: url,
            width: 260,
            height: 260,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        function downloadQR() {
            html2canvas(document.getElementById('qrCanvas'), {
                scale: 3,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'QR_Daftar_Hadir_Festival_Literasi.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>

</body>

</html>