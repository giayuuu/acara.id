<?= $this->extend('template/layout_admin'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </nav>

    <h1 class="text-left mb-4" style="font-size: 1.5rem;">Profil Pengguna</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>No. Telepon:</strong> <?= esc($user['phone']); ?></li>
                        <li class="list-group-item"><strong>Instansi:</strong> <?= esc($user['institution']); ?></li>
                        <li class="list-group-item"><strong>Jabatan:</strong> <?= esc($user['position']); ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?= esc($user['email']); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>