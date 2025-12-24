<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <style>
        body {
            background: #f5f6fa;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
        }

        .table th {
            background: #1d3557;
            color: #fff;
            vertical-align: middle;
        }

        .badge-kelas {
            background: #457b9d;
            font-size: 14px;
            padding: 6px 10px;
        }

        .search-input {
            max-width: 320px;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        <div class="card">
            <div class="card-body">

                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">📚 Peserta Lomba MEWARNAI</h4>

                    <input type="text"
                        id="search"
                        class="form-control search-input"
                        placeholder="Cari nama / sekolah / kelas..."
                        value="<?= htmlspecialchars($keyword) ?>">
                </div>

                <!-- TABEL -->
                <div id="table-wrapper">
                    <?php $this->load->view('peserta/_mewarnai_table'); ?>
                </div>

            </div>
        </div>

    </div>

    <script>
        let typingTimer;

        $('#search').on('keyup', function() {
            clearTimeout(typingTimer);
            const keyword = $(this).val();

            typingTimer = setTimeout(() => {
                $.get('<?= base_url("peserta/mewarnai") ?>', {
                    q: keyword
                }, function(html) {
                    $('#table-wrapper').html(html);
                });
            }, 400);
        });
    </script>

</body>

</html>