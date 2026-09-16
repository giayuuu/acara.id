<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Dashboard Admin'; ?></title>
    <!-- Font & CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="stylesheet" href="<?= base_url('template/css/style.css') ?>" />
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex align-items-center">
                <img src="<?= base_url('template/assets/images/logo.png') ?>" alt="Logo" style="width: 40px; height: 40px; margin-right: 5px;" />
                <h3 class="mb-0">Dashboard Admin</h3>
            </div>

            <ul class="list-unstyled components">
                <p>Menu Admin</p>
                <li><a href="/dashboard"><i class="fas fa-home mr-2"></i>Home</a></li>
                <li><a href="/profile"><i class="fas fa-user mr-2"></i>Profil</a></li>

                <!-- Dropdown Menu Acara -->
                <li>
                    <a href="#acaraSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-calendar-alt mr-2"></i>Acara
                    </a>
                    <ul class="collapse list-unstyled" id="acaraSubmenu">
                        <li><a href="/admin/event/add"><i class="fas fa-plus-circle mr-2"></i>Tambah Acara</a></li>
                        <li><a href="/admin/event/data"><i class="fas fa-table mr-2"></i>Data Acara</a></li>
                    </ul>
                </li>

                <!-- Dropdown Menu Kehadiran -->
                <li>
                    <a href="#kehadiranSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-check-square mr-2"></i>Kehadiran
                    </a>
                    <ul class="collapse list-unstyled" id="kehadiranSubmenu">
                        <li><a href="/admin/scan"><i class="fas fa-qrcode mr-2"></i>Cek Kehadiran</a></li>
                        <li><a href="/admin/attendance"><i class="fas fa-list-alt mr-2"></i>Data Kehadiran</a></li>
                    </ul>
                </li>

                <li><a href="/admin/participants"><i class="fas fa-users mr-2"></i>Data Peserta</a></li>

                <?php if (session('role') !== 'admindinas'): ?>
                    <li><a href="/admin/approval"><i class="fas fa-user-clock mr-2"></i>Acc Admin</a></li>
                <?php endif; ?>

                <li><a href="/logout"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="/dashboard">Home</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Konten Dinamis -->
            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('template/js/scripts.js') ?>"></script>
</body>

</html>
