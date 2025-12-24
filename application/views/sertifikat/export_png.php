<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
</head>

<body style="margin:0; overflow:hidden">

    <div id="capture">
        <?= $html ?>
    </div>

    <script>
        window.onload = function() {
            const el = document.querySelector(".page");

            html2canvas(document.querySelector(".page"), {
                scale: 1,
                useCORS: true,
                backgroundColor: null,
                width: 3508,
                height: 2480,
                windowWidth: 3508,
                windowHeight: 2480
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Sertifikat_<?= strtoupper(preg_replace("/[^A-Z0-9]/", "_", $peserta->nama)) ?>.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
            });

        };
    </script>

</body>

</html>