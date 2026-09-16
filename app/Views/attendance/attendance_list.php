<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Kehadiran</li>
    </ol>
</nav>

<div class="container">
    <h2 class="mb-4" style="font-size: 1.5rem;">Daftar Kehadiran Peserta</h2>

    <form method="GET" action="">
        <div class="row mb-3">
            <div class="col-md-6 d-flex align-items-center">
                <label for="event_id" class="me-2 mb-0">
                    <i class="fas fa-calendar-alt fa-lg"></i>
                </label>
                <select name="event_id" id="event_id" class="form-control" onchange="this.form.submit()">
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

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-users fa-2x mb-2 text-success"></i>
                    <h5 class="card-title mt-2">Kuota Peserta</h5>
                    <p id="kuotaPeserta" class="card-text fw-bold"><?= esc($stats['quota'] ?? '-'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-user-check fa-2x mb-2 text-info"></i>
                    <h5 class="card-title mt-2">Peserta Terdaftar</h5>
                    <p id="terdaftar" class="card-text fw-bold"><?= esc($stats['total_registered'] ?? '-'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-user fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title mt-2">Total Hadir</h5>
                    <p id="totalHadir" class="card-text fw-bold"><?= esc($stats['total_attended'] ?? '-'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-user-times fa-2x mb-2 text-danger"></i>
                    <h5 class="card-title mt-2">Belum Hadir</h5>
                    <p id="belumHadir" class="card-text fw-bold"><?= esc($stats['total_absent'] ?? '-'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-child fa-2x mb-2"></i>
                    <h5 class="card-title mt-2">Laki-laki</h5>
                    <p id="laki" class="card-text fw-bold"><?= esc($stats['male_attended'] ?? '-'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-person-dress fa-2x mb-2" style="color: #183152;"></i>
                    <h5 class="card-title mt-2">Perempuan</h5>
                    <p id="perempuan" class="card-text fw-bold"><?= esc($stats['female_attended'] ?? '-'); ?></p>
                </div>
            </div>
        </div>
    </div>


    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Acara</th>
                    <th>Tanggal Acara</th>
                    <th>Nama Peserta</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Dinas</th>
                    <th>Tanggal Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($attendances)): ?>
                    <?php foreach ($attendances as $index => $attendance): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($attendance['event_name']) ?></td>
                            <td><?= esc($attendance['event_date']) ?></td>
                            <td><?= esc($attendance['full_name']) ?></td>
                            <td><?= esc($attendance['nip']) ?></td>
                            <td><?= esc($attendance['position']) ?></td>
                            <td><?= esc($attendance['dinas']) ?></td>
                            <td><?= esc($attendance['attendance_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-muted fst-italic">Belum Ada Peserta Yang Hadir</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>