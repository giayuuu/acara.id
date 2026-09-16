<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Acara</li>
  </ol>
</nav>

<div class="container py-4">
  <h2 style="font-size: 1.5rem">Form Tambah Acara</h2>
  <form method="post" action="/admin/event/save" class="mb-4">
    <?php $modalType = session()->getFlashdata('modal_type'); ?>

    <div class="mb-3">
      <label>Nama Acara:</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Tanggal:</label>
      <input type="date" name="date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Jam:</label>
      <input type="time" name="time" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Lokasi:</label>
      <input type="text" name="location" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Kuota:</label>
      <input type="number" name="quota" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Link Materi (GDrive):</label>
      <input type="text" name="material_link" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Acara</button>
  </form>
</div>
<div class="modal fade <?= $modalType === 'duplicate' ? 'show' : '' ?>" id="duplicateEventModal"
  tabindex="-1" aria-labelledby="duplicateEventModalLabel" aria-hidden="<?= $modalType !== 'duplicate' ? 'true' : 'false' ?>"
  style="<?= $modalType === 'duplicate' ? 'display:block; background: rgba(0,0,0,0.5);' : '' ?>">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fa fa-exclamation-circle"></i> Gagal</h5>
      </div>
      <div class="modal-body">
        Data acara dengan nama, tanggal, dan waktu tersebut sudah ada sebelumnya.
      </div>
      <div class="modal-footer">
        <a href="/admin/event/add" class="btn btn-secondary">Tutup</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade <?= $modalType === 'success' ? 'show' : '' ?>" id="successEventModal"
  tabindex="-1" aria-labelledby="successEventModalLabel" aria-hidden="<?= $modalType !== 'success' ? 'true' : 'false' ?>"
  style="<?= $modalType === 'success' ? 'display:block; background: rgba(0,0,0,0.5);' : '' ?>">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fa fa-check-circle"></i> Berhasil</h5>
      </div>
      <div class="modal-body">
        Acara berhasil ditambahkan.
      </div>
      <div class="modal-footer">
        <a href="/admin/event/add" class="btn btn-success">Oke</a>
      </div>
    </div>
  </div>
</div>
<?php if (session()->getFlashdata('show_duplicate_modal')): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const modal = new bootstrap.Modal(document.getElementById('duplicateEventModal'));
      modal.show();
    });
  </script>
<?php endif; ?>

<?php if (session()->getFlashdata('show_success_modal')): ?>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const modal = new bootstrap.Modal(document.getElementById('successEventModal'));
      modal.show();
    });
  </script>
<?php endif; ?>

<?= $this->endSection(); ?>