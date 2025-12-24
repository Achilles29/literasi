<?php
// Untuk tampilan
$label_lomba_view = [
    'MAPEL'    => 'MAPEL',
    'STORY'    => 'STORY TELLING',
    'MEWARNAI' => 'MEWARNAI',
    'PIDATO'   => 'PIDATO',
    'REELS'    => 'REELS'
];

// Untuk nama file
$label_lomba_file = [
    'MAPEL'    => 'mapel',
    'STORY'    => 'story',
    'MEWARNAI' => 'mewarnai',
    'PIDATO'   => 'pidato',
    'REELS'    => 'reels'
];
$map_kelas = [
    'I'   => 1,
    'II'  => 2,
    'III' => 3,
    'IV'  => 4,
    'V'   => 5,
    'VI'  => 6
];

$label_juara = [
    'JUARA I'   => 'juara_i',
    'JUARA II'  => 'juara_ii',
    'JUARA III' => 'juara_iii'
];
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Peserta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #6f1d1b, #3a0ca3);
            min-height: 100vh;
            font-family: system-ui;
        }

        .box {
            max-width: 520px;
            margin: 40px auto;
            background: #fff;
            border-radius: 22px;
            padding: 26px;
        }

        .peserta-card {
            border: 1px solid #eee;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 20px;
        }

        .btn-main {
            background: linear-gradient(135deg, #f77f00, #fcbf49);
            border: none;
            font-weight: 700;
            border-radius: 14px;
            padding: 12px;
        }
    </style>
</head>

<body>

    <div class="box">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <img src="<?= base_url('assets/img/pemkab_rembang.png'); ?>" height="42">
            <img src="<?= base_url('assets/img/perpusnas.png'); ?>" height="42">
        </div>

        <h4 class="fw-bold text-center mb-3">
            <?= htmlspecialchars((string) ($no_hp ?? '-')) ?>
        </h4>

        <?php foreach ($peserta_list as $peserta): ?>
            <?php $nama_lomba = $label_lomba_view[$peserta->jenis_lomba] ?? $peserta->jenis_lomba;
            ?>

            <div class="peserta-card">

                <h5 class="fw-bold mb-2"><?= $peserta->nama ?></h5>

                <table class="table table-sm mb-2">
                    <tr>
                        <td>TTL</td>
                        <td><?= $peserta->ttl ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>JK</td>
                        <td><?= $peserta->jenis_kelamin ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Sekolah</td>
                        <td><?= $peserta->asal_sekolah ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td><?= $peserta->kelas ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Lomba</td>
                        <td><strong><?= $nama_lomba ?></strong></td>
                    </tr>
                </table>

                <!-- PREVIEW SERTIFIKAT -->
                <a href="<?= base_url('sertifikat/preview/' . $peserta->id) ?>"
                    class="btn btn-outline-primary w-100 mb-2"
                    style="border-radius:14px; font-weight:700;">
                    Preview Sertifikat
                </a>
                <?php
                $url_piagam = null;

                if (
                    !empty($peserta->keterangan)
                    && isset($label_juara[$peserta->keterangan])
                    && isset($label_lomba_file[$peserta->jenis_lomba])
                ) {
                    $juara       = $label_juara[$peserta->keterangan];
                    $jenis_lomba = $label_lomba_file[$peserta->jenis_lomba];

                    // KHUSUS MAPEL → pakai kelas
                    if ($peserta->jenis_lomba === 'MAPEL') {

                        $kelas_angka = null;

                        if (!empty($peserta->kelas)) {

                            // Ambil romawi dari "Kelas I" s/d "Kelas VI"
                            if (preg_match('/\b(VI|IV|V|III|II|I)\b/', $peserta->kelas, $match)) {
                                $romawi = $match[1];
                                $kelas_angka = $map_kelas[$romawi] ?? null;
                            }
                        }

                        if ($kelas_angka) {
                            $file_piagam = "{$juara}_mapel_kelas_{$kelas_angka}.png";
                        } else {
                            // fallback (harusnya jarang terjadi)
                            $file_piagam = "{$juara}_mapel.png";
                        }
                    } else {
                        // lomba selain MAPEL
                        $file_piagam = "{$juara}_{$jenis_lomba}.png";
                    }


                    if (!empty($file_piagam)) {
                        $url_piagam = base_url("assets/img/" . $file_piagam);
                    }
                }
                ?>

                <?php if ($url_piagam): ?>
                    <a href="<?= base_url('assets/img/' . $file_piagam) ?>"
                        class="btn btn-outline-success w-100 mb-2"
                        style="border-radius:14px; font-weight:700;">
                        ⬇️ Download Piagam <?= htmlspecialchars($peserta->keterangan ?? '') ?>
                    </a>
                <?php endif; ?>


                <!-- CLAIM VOUCHER -->
                <form method="post" action="<?= base_url('lomba/do_claim'); ?>">
                    <input type="hidden" name="id" value="<?= $peserta->id ?>">
                    <button class="btn btn-main w-100">
                        Claim Voucher 20%
                    </button>
                </form>

            </div>
        <?php endforeach; ?>

    </div>

</body>

</html>