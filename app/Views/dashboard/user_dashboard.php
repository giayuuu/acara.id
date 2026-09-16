<?= $this->extend('template/layout_user') ?>

<?= $this->section('content') ?>

<?php if (session()->get('logged_in')): ?>
  <div class="navbar text-white p-4 rounded mb-4 shadow-sm d-flex justify-content-between align-items-center" style="min-height: 200px;">
    <div class="text-start">
      <h3 class="fw-bold mb-0">
        HAI!<br>
        <span class="text-uppercase"><?= esc(session()->get('full_name')) ?></span>
      </h3>
      <p class="mt-2" id="datetime">
        <?= date('l, d F Y H:i') ?> WIB
      </p>
    </div>
    <div>
      <img src="<?= base_url('template/assets/images/walp.png') ?>" alt="Logo" style="height: 100px;">
    </div>
  </div>

  <!-- TIMELINE PENDAFTARAN -->
  <div class="timeline-container mb-5">
    <h4 class="mb-4 text-center fw-bold fst-italic">Timeline Pendaftaran Acara</h4>
    <ul class="timeline list-unstyled p-0 m-0">
      <li class="timeline-item d-flex justify-content-start align-items-start gap-3 mb-4 odd">
        <div class="timeline-icon">
          <img src="<?= base_url('template/assets/images/registrasi.png') ?>" alt="Step 1" style="width: 80px; height: 80px;">
        </div>
        <div class="timeline-content text-start">
          <h5>1. Registrasi Akun</h5>
          <p>Buat akun baru dengan mengisi data lengkap pada form pendaftaran.</p>
        </div>
      </li>
      <li class="timeline-item d-flex justify-content-end align-items-start gap-3 mb-4 even">
        <div class="timeline-content text-end">
          <h5>2. Login</h5>
          <p>Masuk ke sistem menggunakan email dan password yang telah didaftarkan.</p>
        </div>
        <div class="timeline-icon">
          <img src="<?= base_url('template/assets/images/login.png') ?>" alt="Step 2" style="width: 80px; height: 80px;">
        </div>
      </li>
      <li class="timeline-item d-flex justify-content-start align-items-start gap-3 mb-4 odd">
        <div class="timeline-icon">
          <img src="<?= base_url('template/assets/images/event.png') ?>" alt="Step 3" style="width: 80px; height: 80px;">
        </div>
        <div class="timeline-content text-start">
          <h5>3. Pilih Acara</h5>
          <p>Pilih acara yang ingin Anda ikuti dari daftar acara yang tersedia.</p>
        </div>
      </li>
      <li class="timeline-item d-flex justify-content-end align-items-start gap-3 mb-4 even">
        <div class="timeline-content text-end">
          <h5>4. Isi Form Pendaftaran Acara</h5>
          <p>Isi data pendaftaran acara secara lengkap dan submit form pendaftaran.</p>
        </div>
        <div class="timeline-icon">
          <img src="<?= base_url('template/assets/images/form.png') ?>" alt="Step 4" style="width: 80px; height: 80px;">
        </div>
      </li>
      <li class="timeline-item d-flex justify-content-start align-items-start gap-3 odd">
        <div class="timeline-icon">
          <img src="<?= base_url('template/assets/images/confirm.png') ?>" alt="Step 5" style="width: 80px; height: 80px;">
        </div>
        <div class="timeline-content text-start">
          <h5>5. Konfirmasi & Hadir</h5>
          <p>Tunggu konfirmasi pendaftaran dan hadirkan diri Anda pada acara sesuai jadwal.</p>
        </div>
      </li>
    </ul>
  </div>

<?php endif; ?>

<script>
  function updateDateTime() {
    const now = new Date();
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      hour12: false,
      timeZone: 'Asia/Jakarta'
    };
    const formattedDate = now.toLocaleString('id-ID', options).replace(/\./g, ':') + ' WIB';
    document.getElementById('datetime').textContent = formattedDate;
  }

  setInterval(updateDateTime, 1000);
  updateDateTime();
</script>


<?= $this->endSection() ?>