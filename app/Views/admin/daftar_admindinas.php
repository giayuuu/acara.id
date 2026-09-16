<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4 class="mb-3">Admin Dinas Menunggu Persetujuan</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Dinas</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($admindinas)): ?>
                    <?php foreach ($admindinas as $row): ?>
                        <tr>
                            <td><?= esc($row['full_name']) ?></td>
                            <td><?= esc($row['email']) ?></td>
                            <td><?= esc($row['dinas']) ?></td>
                            <td class="text-center">
                                <a href="/admin/approval/approve/<?= $row['id'] ?>" class="btn btn-success btn-sm me-1" title="Setujui">
                                    <i class="bi bi-check-lg"></i> Setujui
                                </a>
                                <a href="/admin/approval/reject/<?= $row['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menolak dan menghapus admin ini?')" 
                                   title="Tolak">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada admin dinas yang menunggu persetujuan.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>

    <hr class="my-5">

    <h4 class="mb-3">Daftar Admin Dinas</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Dinas</th>
                    <th class="text-center">Aksi</th> <!-- Tambah kolom aksi -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($approvedAdmins)): ?>
                    <?php foreach ($approvedAdmins as $row): ?>
                        <tr>
                            <td><?= esc($row['full_name']) ?></td>
                            <td><?= esc($row['email']) ?></td>
                            <td><?= esc($row['dinas']) ?></td>
                            <td class="text-center">
                                <a href="/admin/approval/delete/<?= $row['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus admin ini?')" 
                                   title="Hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada admin dinas yang disetujui.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
