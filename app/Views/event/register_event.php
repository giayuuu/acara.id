<?= $this->extend('template/layout_user') ?>
<?= $this->section('content') ?>

<ol class="breadcrumb bg-light p-3 rounded shadow-sm">
  <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Daftar Acara</li>
</ol>

<div class="container mt-4 mb-5">
  <h2>Form Registrasi Acara</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= esc($error) ?></div>
  <?php endif; ?>

  <form id="registrationForm" action="/event/register/submit" method="post" onsubmit="prepareSignature()">
    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">

    <div class="form-group">
      <label><strong>Nama Acara:</strong></label>
      <input type="text" class="form-control" value="<?= $event['name'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>Tanggal:</strong></label>
      <input type="text" class="form-control" value="<?= $event['date'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>Jam:</strong></label>
      <input type="text" class="form-control" value="<?= $event['time'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>Lokasi:</strong></label>
      <input type="text" class="form-control" value="<?= $event['location'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>Nama Lengkap:</strong></label>
      <input type="text" class="form-control" value="<?= $user['full_name'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>NIP:</strong></label>
      <input type="text" class="form-control" value="<?= $user['nip'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>No. Telepon:</strong></label>
      <input type="text" class="form-control" value="<?= $user['phone'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>Instansi:</strong></label>
      <input type="text" class="form-control" value="<?= $user['institution'] ?>" readonly>
    </div>

    <div class="form-group">
      <label><strong>Dinas:</strong></label>
      <select name="dinas" class="form-control" required>
        <option value="">-- Pilih Dinas --</option>
        <option value="Dinas Komunikasi dan Informatika" <?= $user['dinas'] == 'Dinas Komunikasi dan Informatika' ? 'selected' : '' ?>>Dinas Komunikasi dan Informatika</option>
        <option value="Dinas Kesehatan" <?= $user['dinas'] == 'Dinas Kesehatan' ? 'selected' : '' ?>>Dinas Kesehatan</option>
        <option value="Dinas Pendidikan" <?= $user['dinas'] == 'Dinas Pendidikan' ? 'selected' : '' ?>>Dinas Pendidikan</option>
        <option value="Dinas Pemuda dan Olahraga" <?= $user['dinas'] == 'Dinas Pemuda dan Olahraga' ? 'selected' : '' ?>>Dinas Pemuda dan Olahraga</option>
        <option value="Dinas Sosial" <?= $user['dinas'] == 'Dinas Sosial' ? 'selected' : '' ?>>Dinas Sosial</option>
        <option value="Dinas Tenaga Kerja" <?= $user['dinas'] == 'Dinas Tenaga Kerja' ? 'selected' : '' ?>>Dinas Tenaga Kerja</option>
        <option value="Dinas Perhubungan" <?= $user['dinas'] == 'Dinas Perhubungan' ? 'selected' : '' ?>>Dinas Perhubungan</option>
        <option value="Dinas Kependudukan dan Pencatatan Sipil" <?= $user['dinas'] == 'Dinas Kependudukan dan Pencatatan Sipil' ? 'selected' : '' ?>>Dinas Kependudukan dan Pencatatan Sipil</option>
        <option value="Dinas Pariwisata dan Kebudayaan" <?= $user['dinas'] == 'Dinas Pariwisata dan Kebudayaan' ? 'selected' : '' ?>>Dinas Pariwisata dan Kebudayaan</option>
        <option value="Dinas Pekerjaan Umum Bina Marga" <?= $user['dinas'] == 'Dinas Pekerjaan Umum Bina Marga' ? 'selected' : '' ?>>Dinas Pekerjaan Umum Bina Marga</option>
        <option value="Dinas Pekerjaan Umum Sumber Daya Air" <?= $user['dinas'] == 'Dinas Pekerjaan Umum Sumber Daya Air' ? 'selected' : '' ?>>Dinas Pekerjaan Umum Sumber Daya Air</option>
        <option value="Dinas Perumahan, Kawasan Permukiman dan Cipta Karya" <?= $user['dinas'] == 'Dinas Perumahan, Kawasan Permukiman dan Cipta Karya' ? 'selected' : '' ?>>Dinas Perumahan, Kawasan Permukiman dan Cipta Karya</option>
        <option value="Dinas Perindustrian dan Perdagangan" <?= $user['dinas'] == 'Dinas Perindustrian dan Perdagangan' ? 'selected' : '' ?>>Dinas Perindustrian dan Perdagangan</option>
        <option value="Dinas Koperasi dan Usaha Mikro" <?= $user['dinas'] == 'Dinas Koperasi dan Usaha Mikro' ? 'selected' : '' ?>>Dinas Koperasi dan Usaha Mikro</option>
      </select>
    </div>

    <div class="form-group">
      <label><strong>Jabatan:</strong></label>
      <select name="jabatan" class="form-control" required>
        <option value="Kepala Dinas" <?= $user['position'] == 'Kepala Dinas' ? 'selected' : '' ?>>Kepala Dinas</option>
        <option value="Sekretaris" <?= $user['position'] == 'Sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
        <option value="Kepala Bidang" <?= $user['position'] == 'Kepala Bidang' ? 'selected' : '' ?>>Kepala Bidang</option>
        <option value="Kepala Seksi" <?= $user['position'] == 'Kepala Seksi' ? 'selected' : '' ?>>Kepala Seksi</option>
        <option value="Staff" <?= $user['position'] == 'Staff' ? 'selected' : '' ?>>Staff</option>
      </select>
    </div>

    <div class="form-group">
      <label><strong>Tanda Tangan:</strong></label>
      <div class="signature-wrapper mb-2">
        <canvas id="signature-pad"></canvas>
      </div>
      <input type="hidden" name="signature" id="signature">
      <button type="button" class="btn btn-sm btn-secondary" onclick="clearCanvas()">Hapus Tanda Tangan</button>
    </div>

    <!-- Ubah tombol submit jadi tombol biasa agar tidak langsung submit -->
    <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#confirmModal">Daftar Sekarang</button>
  </form>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin mendaftar acara ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="confirmSubmitBtn">Ya, Daftar</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Kode canvas tanda tangan sama seperti sebelumnya
  const canvas = document.getElementById('signature-pad');
  const ctx = canvas.getContext('2d');
  let drawing = false;

  function resizeCanvas() {
    const ratio = window.devicePixelRatio || 1;
    const wrapper = canvas.parentElement;
    canvas.width = wrapper.offsetWidth * ratio;
    canvas.height = wrapper.offsetHeight * ratio;
    canvas.style.width = wrapper.offsetWidth + 'px';
    canvas.style.height = wrapper.offsetHeight + 'px';
    ctx.setTransform(1, 0, 0, 1, 0, 0);
    ctx.scale(ratio, ratio);
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
  }

  function getRelativePos(x, y) {
    const rect = canvas.getBoundingClientRect();
    return {
      x: (x - rect.left),
      y: (y - rect.top)
    };
  }

  function startDrawing(x, y) {
    drawing = true;
    const pos = getRelativePos(x, y);
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
  }

  function draw(x, y) {
    if (!drawing) return;
    const pos = getRelativePos(x, y);
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
  }

  function stopDrawing() {
    drawing = false;
  }

  function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
  }

  function prepareSignature() {
    const dataURL = canvas.toDataURL();
    document.getElementById('signature').value = dataURL;
  }


  canvas.addEventListener('mousedown', (e) => startDrawing(e.clientX, e.clientY));
  canvas.addEventListener('mousemove', (e) => draw(e.clientX, e.clientY));
  canvas.addEventListener('mouseup', stopDrawing);
  canvas.addEventListener('mouseleave', stopDrawing);

  canvas.addEventListener('touchstart', (e) => {
    e.preventDefault();
    const touch = e.touches[0];
    startDrawing(touch.clientX, touch.clientY);
  });
  canvas.addEventListener('touchmove', (e) => {
    e.preventDefault();
    const touch = e.touches[0];
    draw(touch.clientX, touch.clientY);
  });
  canvas.addEventListener('touchend', stopDrawing);

  window.addEventListener('resize', resizeCanvas);
  resizeCanvas();

  // Handle tombol konfirmasi modal
  document.getElementById('confirmSubmitBtn').addEventListener('click', function () {
    prepareSignature();  // Pastikan tanda tangan sudah disiapkan
    document.getElementById('registrationForm').submit(); // Submit form
  });
</script>

<?= $this->endSection() ?>
