<table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th width="50">No</th>
            <th width="110">Kelas</th>
            <th>Nama Peserta</th>
            <th width="160">No. HP</th>
            <th>Sekolah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = ($page - 1) * $limit + 1;
        foreach ($peserta as $row): ?>
            <tr>
                <td><?= $no++ ?></td>

                <td>
                    <span class="badge bg-primary">
                        <?= htmlspecialchars($row->kelas ?? '-') ?>
                    </span>
                </td>

                <td class="fw-semibold text-uppercase">
                    <?= htmlspecialchars($row->nama) ?>
                </td>

                <td>
                    <?php if (!empty($row->no_hp)): ?>
                        <span class="text-nowrap">
                            📞 <?= htmlspecialchars($row->no_hp) ?>
                        </span>
                    <?php else: ?>
                        <span class="text-muted fst-italic">-</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?= htmlspecialchars($row->asal_sekolah ?? '-') ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<!-- PAGINATION -->
<?php if ($total_pages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center mt-3">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="javascript:void(0)"
                        onclick="loadPage(<?= $i ?>)">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <script>
        function loadPage(page) {
            $.get('<?= base_url("peserta/mewarnai") ?>', {
                page: page,
                q: $('#search').val()
            }, function(html) {
                $('#table-wrapper').html(html);
            });
        }
    </script>
<?php endif; ?>