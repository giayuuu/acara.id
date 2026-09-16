<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/css/styleLog.css">
</head>

<body>

    <div class="register-card text-center">
        <h3 class="mb-4">Buat Akun</h3>
        <p class="mb-4 text-muted">Silakan pilih jenis akun yang ingin Anda buat:</p>

        <div class="d-grid gap-3">
            <a href="<?= site_url('/register') ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-user"></i> Daftar sebagai Pengguna
            </a>
            <a href="<?= site_url('/register-admindinas') ?>" class="btn btn-warning btn-lg text-white">
                <i class="fas fa-user-shield"></i> Daftar sebagai Admin Dinas
            </a>
        </div>
    </div>

</body>

</html>