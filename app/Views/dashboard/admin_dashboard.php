<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<h2>Selamat Datang, Admin</h2>
<p>Gunakan menu di samping untuk mengelola acara dan data peserta.</p>

<div class="line"></div>
<div class="container mt-4">
    <!-- Baris Pertama Card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-6">
                <div class="card-body text-center">
                    <i class="fas fa-calendar fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Total Acara</h5>
                    <p class="card-text"><?= $totalAcara; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-6">
                <div class="card-body text-center">
                    <i class="fas fa-hourglass-half fa-2x mb-2 text-warning"></i>
                    <h5 class="card-title">Acara Berlangsung</h5>
                    <p class="card-text"><?= $acaraBerlangsung; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Kedua Card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mt-4 ">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x mb-2 text-secondary"></i>
                    <h5 class="card-title">Event Selesai</h5>
                    <p class="card-text"><?= $acaraSelesai; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-2x mb-2 text-primary"></i>
                    <h5 class="card-title">Total Admin</h5>
                    <p class="card-text"><?= $totalAdmin; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>