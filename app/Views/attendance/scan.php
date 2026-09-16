<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Scan QRCode</li>
    </ol>
</nav>

<div class="container mt-4">
    <h2 style="font-size: 1.5rem">Scan QR Code untuk Daftar Hadir</h2>
    <div id="reader" style="width: 300px;"></div>
    <p id="result" class="mt-3 fw-bold"></p>

</div>

<!-- Audio Elements -->
<audio id="successSound" src="<?= base_url('template/assets/sounds/success.mp3') ?>"></audio>
<audio id="errorSound" src="<?= base_url('template/assets/sounds/error.mp3') ?>"></audio>

<!-- HTML5 QR Code Library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    function playSound(type) {
        const sound = type === 'success' ? document.getElementById('successSound') : document.getElementById('errorSound');
        if (sound) sound.play();
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan scanner sementara untuk menghindari double scan
        html5QrcodeScanner.clear().then(() => {
            document.getElementById('result').innerText = "QR Terdeteksi, mengirim data...";

            fetch("/event/scanQr", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        qr_data: decodedText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        playSound('success');
                        document.getElementById('result').innerText = `✅ ${data.message}`;
                    } else {
                        playSound('error');
                        document.getElementById('result').innerText = `❌ ${data.message}`;
                    }

                    setTimeout(() => {
                        html5QrcodeScanner.render(onScanSuccess);
                    }, 2000);
                })
                .catch(err => {
                    playSound('error');
                    document.getElementById('result').innerText = `❌ Error: ${err}`;
                    setTimeout(() => {
                        html5QrcodeScanner.render(onScanSuccess);
                    }, 3000);
                });
        }).catch(error => {
            console.error("Gagal membersihkan scanner:", error);
        });
    }

    const html5QrcodeScanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbox: 250
    });

    html5QrcodeScanner.render(onScanSuccess);
</script>

<?= $this->endSection(); ?>