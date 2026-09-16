<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Peserta</li>
    </ol>
</nav>

<div class="container mt-4">
    <h2 style="font-size: 1.5rem">Data Peserta</h2>

    <!-- Dropdown Filter Event -->
    <form method="get" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="event_id" class="col-form-label">Pilih Acara:</label>
            </div>
            <div class="col-auto">
                <select name="event_id" id="event_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Acara --</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= esc($event['id']) ?>" <?= ($selectedEventId == $event['id']) ? 'selected' : '' ?>>
                            <?= esc($event['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <!-- Statistik -->
    <?php if (!empty($selectedEventId)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Statistik Acara</h5>
                <ul class="mb-0">
                    <li><strong>Kuota:</strong> <?= esc($stats['quota']) ?></li>
                    <li><strong>Jumlah Pendaftar:</strong> <?= esc($stats['total_registered']) ?></li>
                    <li><strong>Laki-laki:</strong> <?= esc($stats['male_registered']) ?></li>
                    <li><strong>Perempuan:</strong> <?= esc($stats['female_registered']) ?></li>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tabel Peserta -->
    <?php if (!empty($participants)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Nama Acara</th>
                        <th>Nama Peserta</th>
                        <th>Dinas</th>
                        <th>Jabatan</th>
                        <th>NIP</th>
                        <th>Telp</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $row): ?>
                        <tr>
                            <td><?= esc($row['event_name'] ?? '') ?></td>
                            <td><?= esc($row['full_name']) ?></td>
                            <td><?= esc($row['dinas'] ?? '-') ?></td>
                            <td><?= esc($row['position'] ?? '-') ?></td>
                            <td><?= esc($row['nip'] ?? '-') ?></td>
                            <td><?= esc($row['phone'] ?? '-') ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row['registered_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-3" role="alert">
            Tidak ada peserta yang terdaftar untuk acara ini.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>