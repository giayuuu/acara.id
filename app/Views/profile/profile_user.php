 <?= $this->extend('template/layout_user') ?>

 <?= $this->section('content') ?>

 <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
     <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
     <li class="breadcrumb-item active" aria-current="page">Profile</li>
 </ol>
 <h1>Profile</h1>
 <?php if (session()->getFlashdata('success')): ?>
     <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
 <?php endif; ?>

 <?php if (session()->getFlashdata('errors')): ?>
     <div class="alert alert-danger">
         <ul>
             <?php foreach (session()->getFlashdata('errors') as $error): ?>
                 <li><?= esc($error) ?></li>
             <?php endforeach; ?>
         </ul>
     </div>
 <?php endif; ?>

 <div class="card shadow-sm">
     <div class="card-body">
         <div class="row">
             <div class="col-md-12">
                 <ul class="list-group list-group-flush">
                     <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                         <i class="fa-solid fa-pen-to-square"></i>
                     </button>
                     <li class="list-group-item"><strong>Nama Lengkap:</strong> <?= esc($user['full_name']); ?></li>
                     <li class="list-group-item"><strong>Jenis Kelamin:</strong> <?= esc($user['gender']); ?></li>
                     <li class="list-group-item"><strong>NIP:</strong> <?= esc($user['nip']); ?></li>
                     <li class="list-group-item"><strong>No. Telepon:</strong> <?= esc($user['phone']); ?></li>
                     <li class="list-group-item"><strong>Instansi:</strong> <?= esc($user['institution']); ?></li>
                     <li class="list-group-item"><strong>Dinas:</strong> <?= esc($user['dinas']); ?></li>
                     <li class="list-group-item"><strong>Jabatan:</strong> <?= esc($user['position']); ?></li>
                     <li class="list-group-item"><strong>Email:</strong> <?= esc($user['email']); ?></li>
                 </ul>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Edit Profil -->
 <!-- Modal Edit Profil -->
 <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <form action="/profile/update" method="post">
                 <div class="modal-header">
                     <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                 </div>
                 <div class="modal-body">
                     <div class="mb-3">
                         <label for="full_name" class="form-label">Nama Lengkap</label>
                         <input type="text" name="full_name" id="full_name" class="form-control" value="<?= $user['full_name']; ?>" required>
                     </div>

                     <div class="mb-3">
                         <label for="gender" class="form-label">Jenis Kelamin</label>
                         <select name="gender" id="gender" class="form-select" required>
                             <option value="">-- Pilih Jenis Kelamin --</option>
                             <option value="Laki-laki" <?= $user['gender'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                             <option value="Perempuan" <?= $user['gender'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                         </select>
                     </div>

                     <div class="mb-3">
                         <label for="nip" class="form-label">NIP</label>
                         <input type="text" name="nip" id="nip" class="form-control" value="<?= $user['nip']; ?>" required>
                     </div>

                     <div class="mb-3">
                         <label for="phone" class="form-label">No. Telepon</label>
                         <input type="text" name="phone" id="phone" class="form-control" value="<?= $user['phone']; ?>" required>
                     </div>

                     <div class="mb-3">
                         <label for="institution" class="form-label">Instansi</label>
                         <input type="text" name="institution" id="institution" class="form-control" value="<?= $user['institution']; ?>" required>
                     </div>

                     <div class="mb-3">
                         <label for="dinas" class="form-label">Dinas</label>
                         <select name="dinas" id="dinas" class="form-select" required>
                             <option value="">-- Pilih Dinas --</option>
                             <?php
                                $dinasList = [
                                    "Dinas Komunikasi dan Informatika",
                                    "Dinas Kesehatan",
                                    "Dinas Pendidikan",
                                    "Dinas Pemuda dan Olahraga",
                                    "Dinas Sosial",
                                    "Dinas Tenaga Kerja",
                                    "Dinas Perhubungan",
                                    "Dinas Kependudukan dan Pencatatan Sipil",
                                    "Dinas Pariwisata dan Kebudayaan",
                                    "Dinas Pekerjaan Umum Bina Marga",
                                    "Dinas Pekerjaan Umum Sumber Daya Air",
                                    "Dinas Perumahan, Kawasan Permukiman dan Cipta Karya",
                                    "Dinas Perindustrian dan Perdagangan",
                                    "Dinas Koperasi dan Usaha Mikro"
                                ];
                                foreach ($dinasList as $dinas) {
                                    $selected = $user['dinas'] == $dinas ? 'selected' : '';
                                    echo "<option value=\"$dinas\" $selected>$dinas</option>";
                                }
                                ?>
                         </select>
                     </div>

                     <div class="mb-3">
                         <label for="position" class="form-label">Jabatan</label>
                         <select name="position" id="position" class="form-select" required>
                             <option value="">-- Pilih Jabatan --</option>
                             <option value="Kepala Dinas" <?= $user['position'] == 'Kepala Dinas' ? 'selected' : '' ?>>Kepala Dinas</option>
                             <option value="Sekretaris" <?= $user['position'] == 'Sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
                             <option value="Kepala Bidang" <?= $user['position'] == 'Kepala Bidang' ? 'selected' : '' ?>>Kepala Bidang</option>
                             <option value="Kepala Seksi" <?= $user['position'] == 'Kepala Seksi' ? 'selected' : '' ?>>Kepala Seksi</option>
                             <option value="Staff" <?= $user['position'] == 'Staff' ? 'selected' : '' ?>>Staff</option>
                         </select>
                     </div>

                     <div class="mb-3">
                         <label for="email" class="form-label">Email (username)</label>
                         <input type="email" name="email" id="email" class="form-control" value="<?= $user['email']; ?>" required>
                     </div>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <?= $this->endSection() ?>