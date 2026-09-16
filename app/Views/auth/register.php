<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="template/css/styleLog.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
  <div class="wrapper wrapper-signup">
    <div class="logo">
      <img src="template/assets/images/logo.png" alt="Logo">
    </div>
    <div class="text-center mt-4 name">
      Acara.id
    </div>
    <form method="post" action="/register" class="p-3 mt-3">
      <div class="form-field d-flex align-items-center">
        <input type="text" name="full_name" class="form-control" placeholder="Nama Lengkap" required>
      </div>
      <div class="form-field d-flex align-items-center">
        <select name="gender" class="form-select" required>
          <option value="">-- Pilih Jenis Kelamin --</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>
      <div class="form-field d-flex align-items-center">
        <input type="text" name="nip" class="form-control" placeholder="NIP" required>
      </div>
      <div class="form-field d-flex align-items-center">
        <input type="text" name="phone" class="form-control" placeholder="No. Telepon" required>
      </div>
      <div class="form-field d-flex align-items-center">
        <input type="text" name="institution" class="form-control" placeholder="Instansi" required>
      </div>
      <div class="form-field d-flex align-items-center">
        <select name="dinas" id="dinas" class="form-select" required>
          <option value="">-- Pilih Dinas --</option>
          <option value="Dinas Komunikasi dan Informatika">Dinas Komunikasi dan Informatika</option>
          <option value="Dinas Kesehatan">Dinas Kesehatan</option>
          <option value="Dinas Pendidikan">Dinas Pendidikan</option>
          <option value="Dinas Pemuda dan Olahraga">Dinas Pemuda dan Olahraga</option>
          <option value="Dinas Sosial">Dinas Sosial</option>
          <option value="Dinas Tenaga Kerja">Dinas Tenaga Kerja</option>
          <option value="Dinas Perhubungan">Dinas Perhubungan</option>
          <option value="Dinas Kependudukan dan Pencatatan Sipil">Dinas Kependudukan dan Pencatatan Sipil</option>
          <option value="Dinas Pariwisata dan Kebudayaan">Dinas Pariwisata dan Kebudayaan</option>
          <option value="Dinas Pekerjaan Umum Bina Marga">Dinas Pekerjaan Umum Bina Marga</option>
          <option value="Dinas Pekerjaan Umum Sumber Daya Air">Dinas Pekerjaan Umum Sumber Daya Air</option>
          <option value="Dinas Perumahan, Kawasan Permukiman dan Cipta Karya">Dinas Perumahan, Kawasan Permukiman dan Cipta Karya</option>
          <option value="Dinas Perindustrian dan Perdagangan">Dinas Perindustrian dan Perdagangan</option>
          <option value="Dinas Koperasi dan Usaha Mikro">Dinas Koperasi dan Usaha Mikro</option>
        </select>
      </div>



      <div class="form-field d-flex align-items-center">
        <select name="position" class="form-select" required>
          <option value="">-- Pilih Jabatan --</option>
          <option value="Kepala Dinas">Kepala Dinas</option>
          <option value="Sekretaris">Sekretaris</option>
          <option value="Kepala Bidang">Kepala Bidang</option>
          <option value="Kepala Seksi">Kepala Seksi</option>
          <option value="Staff">Staff</option>
        </select>
      </div>
      <div class="form-field d-flex align-items-center">
        <input type="email" name="email" class="form-control" placeholder="Email (digunakan sebagai username)" required>
      </div>
      <div class="form-field d-flex align-items-center">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-field d-flex align-items-center">
        <input type="password" name="repeat_password" class="form-control" placeholder="Ulangi Password" required>
      </div>
      <div class="my-3 text-center">
        <div class="g-recaptcha d-inline-block" data-sitekey="<?= config('Recaptcha')->siteKey ?>"></div>
      </div>
      <button class="btn btn-primary mt-3">Daftar Sekarang</button>
    </form>
    <div class="text-center fs-6">
      <p>Sudah punya akun? <a href="/login">Login</a></p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>