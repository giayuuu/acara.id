<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data acara</li>
  </ol>
</nav>

<div class="container mt-4">
  <h4>Daftar Acara</h4>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Lokasi</th>
        <th>Kuota</th>
        <th>Materi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($events as $event): ?>
      <tr>
        <td><?= esc($event['name']) ?></td>
        <td><?= esc($event['date']) ?></td>
        <td><?= esc($event['time']) ?></td>
        <td><?= esc($event['location']) ?></td>
        <td><?= esc($event['quota']) ?></td>
        <td><a href="<?= esc($event['material_link']) ?>" target="_blank">Link</a></td>
        <td>
          <!-- Tombol Edit -->
          <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal<?= $event['id'] ?>">Edit</button>

          <!-- Tombol Hapus -->
          <form action="/admin/event/delete" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin hapus acara ini?')">
            <input type="hidden" name="id" value="<?= $event['id'] ?>">
            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
          </form>
        </td>
      </tr>

      <!-- Modal Edit -->
      <div class="modal fade" id="editModal<?= $event['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <form method="post" action="/admin/event/update">
            <input type="hidden" name="id" value="<?= $event['id'] ?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Acara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>Nama Acara:</label>
                <input type="text" name="name" class="form-control" value="<?= esc($event['name']) ?>" required>

                <label class="mt-2">Tanggal:</label>
                <input type="date" name="date" class="form-control" value="<?= esc($event['date']) ?>" required>

                <label class="mt-2">Jam:</label>
                <input type="time" name="time" class="form-control" value="<?= esc($event['time']) ?>" required>

                <label class="mt-2">Lokasi:</label>
                <input type="text" name="location" class="form-control" value="<?= esc($event['location']) ?>" required>

                <label class="mt-2">Kuota:</label>
                <input type="number" name="quota" class="form-control" value="<?= esc($event['quota']) ?>" required>

                <label class="mt-2">Link Materi:</label>
                <input type="text" name="material_link" class="form-control" value="<?= esc($event['material_link']) ?>">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection(); ?>
