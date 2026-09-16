<?= $this->extend('template/layout_user') ?>
<?= $this->section('content') ?>

<ol class="breadcrumb bg-light p-3 rounded shadow-sm">
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Histori</li>
</ol>

<link rel="stylesheet" href="<?= base_url('template/css/style2.css') ?>" />

<h2>Histori Acara</h2>

<div class="table-responsive-mobile" style="margin-bottom: 4rem;">
    <table>
        <thead>
            <tr>
                <th class="text-center">Nama Event</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Jam</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Download Materi</th>
                <th class="text-center">Cetak Tiket</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($history)): ?>
                <?php foreach ($history as $item): ?>
                    <tr>
                        <td><?= esc($item['event_name']) ?></td>
                        <td><?= date('d-m-Y', strtotime($item['event_date'])) ?></td>
                        <td><?= date('H:i', strtotime($item['event_time'])) ?></td>
                        <td><?= esc($item['event_location']) ?></td>
                       <td class="text-center">
                            <a href="<?= esc($item['material_link']) ?>" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download me-1"></i> 
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="<?= site_url('event/cetak_pdf/' . $item['registration_id']) ?>" target="_blank" class="btn btn-sm btn-danger">
                                <i class="fas fa-file-pdf me-1"></i> 
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Belum ada history pendaftaran.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
