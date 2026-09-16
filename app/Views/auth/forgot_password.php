<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/css/styleLog.css">
</head>

<body>
    <div class="wrapper wrapper-login">
        <div class="logo text-center">
            <img src="template/assets/images/logo.png" alt="Logo">
        </div>
        <div class="text-center mt-4 name">
            Acara.id
        </div>

        <form class="p-3 mt-3" method="post" action="/forgot-password">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="form-field d-flex align-items-center">
                <span class="far fa-envelope"></span>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" placeholder="Password Baru" required>
            </div>

            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="repeat_password" placeholder="Ulangi Password" required>
            </div>

            <button class="btn mt-3" type="submit">Reset Password</button>
        </form>

        <div class="text-center fs-6 mt-3">
            <a href="/login">Kembali ke Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>