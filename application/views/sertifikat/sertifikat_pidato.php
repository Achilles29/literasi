<?php
if ($mode === 'pdf') {
    // PATH ABSOLUT TANPA file://
    $bg = FCPATH . 'assets/img/lomba_pidato.jpg';
} else {
    $bg = base_url('assets/img/lomba_pidato.jpg');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>

    <style>
        @page { margin: 0; }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
        }

        .sertifikat {
            position: relative;
            width: 210mm;
            height: 297mm;
            overflow: hidden;
        }

        /* BACKGROUND */
        .bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* LAYER TEKS */
        .layer {
            position: absolute;
            inset: 0;
            z-index: 2;
        }

        .nama-peserta {
            position: absolute;
            top: 41.5%;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
            font-size: 33px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #0b2a4a;
            text-transform: uppercase;
        }

        .garis-nama {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translateX(-50%);
            width: 70%;
            border-bottom: 2px solid #1f3c88;
        }

        <?php if ($mode === 'preview'): ?>
        body { background:#eaeaea; }
        .sertifikat {
            margin: 20px auto;
            box-shadow: 0 0 20px rgba(0,0,0,.25);
        }
        .download-wrapper {
            text-align:center;
            margin:20px;
        }
        .btn-download {
            width:100%;
            max-width:420px;
            padding:18px;
            font-size:18px;
            font-weight:800;
            border:none;
            border-radius:16px;
            background:linear-gradient(135deg,#f77f00,#fcbf49);
            cursor:pointer;
        }
        <?php endif; ?>
    </style>
</head>

<body>

<?php if ($mode === 'preview'): ?>
<div class="download-wrapper">
    <button class="btn-download" onclick="downloadPNG()">⬇️ DOWNLOAD PNG</button>
</div>
<div class="download-wrapper">
    <button class="btn-download" onclick="downloadPDF()">⬇️ DOWNLOAD PDF</button>
</div>
<?php endif; ?>

<div class="sertifikat" id="area-sertifikat">

    <!-- BACKGROUND -->
    <img src="<?= $bg ?>" class="bg">

    <!-- TEKS -->
    <div class="layer">
        <div class="nama-peserta">
            <?= strtoupper($peserta->nama) ?>
        </div>
    </div>

</div>

<?php if ($mode === 'preview'): ?>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
function downloadPNG() {
    html2canvas(document.getElementById('area-sertifikat'), {
        scale: 2,
        useCORS: true
    }).then(c => {
        let a = document.createElement('a');
        a.href = c.toDataURL('image/png');
        a.download = 'Sertifikat_<?= strtoupper(preg_replace("/[^A-Z0-9]/","_", $peserta->nama)) ?>.png';
        a.click();
    });
}

function downloadPDF() {
    fetch("<?= base_url('sertifikat/download_pdf/'.$peserta->id) ?>")
        .then(r => r.blob())
        .then(b => {
            let a = document.createElement('a');
            a.href = URL.createObjectURL(b);
            a.download = 'Sertifikat_<?= strtoupper(preg_replace("/[^A-Z0-9]/","_", $peserta->nama)) ?>.pdf';
            a.click();
        });
}
</script>
<?php endif; ?>

</body>
</html>
