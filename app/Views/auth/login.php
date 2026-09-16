<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="template/css/styleLog.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
  <div class="wrapper wrapper-login">
    <div class="logo text-center">
      <img src="template/assets/images/logo.png" alt="Logo">
    </div>
    <div class="text-center mt-4 name">
      Acara.id
    </div>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger mx-4"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success mx-4"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form class="p-3 mt-2" method="post" action="/login">
      <div class="form-field d-flex align-items-center">
        <span class="far fa-user"></span>
        <input type="text" name="email" id="userName" placeholder="Username (Email)" required>
      </div>
      <div class="form-field d-flex align-items-center">
        <span class="fas fa-key"></span>
        <input type="password" name="password" id="pwd" placeholder="Password" required>
      </div>
      <div class="my-3 captcha-wrapper">
        <div class="g-recaptcha" data-sitekey="<?= config('Recaptcha')->siteKey ?>"></div>
      </div>

      <button class="btn mt-3" type="submit">Login</button>
    </form>
    <div class="text-center fs-6">
      belum punya akun? <a href="/register-choice">Sign up</a>
    </div>
    <div class="text-center fs-6 ">
      <a href="/forgot-password">Lupa kata sandi?</a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>