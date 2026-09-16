<?= $this->extend('template/layout_admin'); ?>
<?= $this->section('content'); ?>

<div style="max-width: 600px; margin: 20px 0;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 10px;">Selamat Datang, Admin <?= esc($dinas); ?></h2>
        <p>Gunakan menu di samping untuk mengelola acara dan data peserta.</p>
    </div>
</div>

<?= $this->endSection(); ?>
