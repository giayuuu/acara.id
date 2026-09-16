<?= $this->extend('template/layout_user') ?>

<?= $this->section('content') ?>

<ol class="breadcrumb bg-light p-3 rounded shadow-sm">
  <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Daftar Acara</li>
</ol>

<head>
  <title>Daftar Acara</title>
  <!-- Menautkan file CSS eksternal -->
  <link rel="stylesheet" href="<?= base_url('template/css/style2.css') ?>" />
</head>

<body>
  <div class="d-flex justify-content-between align-items-center px-3 mb-3 flex-wrap">
    <h2>Daftar Acara</h2>
    <div class="d-flex gap-2 flex-wrap">

      <div class="input-group">
        <button class="btn btn-outline-primary" id="searchBtn" title="Cari Acara">
          <i class="fa fa-search"></i>
        </button>
        <input type="text" id="searchInput" class="form-control" placeholder="Cari acara..." style="display: none;">
      </div>

      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-sort"></i> Urutkan
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item sort-option" data-sort="asc"><i class="fa fa-arrow-up"></i> Lama</a></li>
          <li><a class="dropdown-item sort-option" data-sort="desc"><i class="fa fa-arrow-down"></i> Terbaru</a></li>
        </ul>
      </div>
      <form method="get" action="" class="d-flex align-items-center gap-2">
        <div class="input-group">
          <span class="input-group-text bg-white border-primary text-primary">
            <i class="fa fa-building" title="Filter Instansi"></i>
          </span>
          <select name="dinas" class="form-select border-primary text-primary" onchange="this.form.submit()">
            <option value="" <?= empty($selectedDinas) ? 'selected' : '' ?>>-- Semua Dinas --</option>
            <?php foreach ($dinasList as $dinas): ?>
              <option value="<?= esc($dinas) ?>" <?= ($selectedDinas == $dinas) ? 'selected' : '' ?>>
                <?= esc($dinas) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </form>

    </div>
  </div>

  <div class="card-container">

    <?php foreach ($events as $event): ?>
      <div class="card">
        <h3><?= $event['name'] ?></h3>
        <p><strong>Tanggal:</strong> <?= $event['formatted_date'] ?></p>
        <p><strong>Jam:</strong> <?= $event['formatted_time'] ?>WIB</p>
        <p><strong>Lokasi:</strong> <?= $event['location'] ?></p>
        <p><strong>Sisa Kuota:</strong> <?= $event['quota_remaining'] ?></p>
        <p><strong>Diselenggarakan oleh:</strong> <?= esc($event['creator_name'] ?? 'Tidak diketahui') ?></p>

        <p><strong>Status:</strong>
          <?php
          date_default_timezone_set('Asia/Jakarta');

          $now = date('Y-m-d H:i:s');
          $eventDateTime = $event['date'] . ' ' . $event['time'];

          if (date('Y-m-d') === $event['date']) {
            echo '<span class="status sedang">Sedang Berlangsung</span>';
          } elseif (date('Y-m-d') < $event['date']) {
            echo '<span class="status belum">Belum Dimulai</span>';
          } else {
            echo '<span class="status terlaksana">Sudah Terlaksana</span>';
          }
          ?>
        </p>
        <?php
        if ($now < $eventDateTime && $event['quota_remaining'] > 0) {
          echo '<a href="/event/register/' . $event['id'] . '"><strong>Daftar Sekarang</strong></a>';
        } else {
          echo '<a class="CloseReg" disabled>Pendaftaran Ditutup</a>';
        }
        ?>

      </div>
    <?php endforeach; ?>

    <p id="noResultMessage" style="display: none; text-align: center; margin-top: 20px; font-weight: bold; color: #888;">
      <i class="fa fa-exclamation-circle"></i> Acara tidak ditemukan
    </p>

  </div>

  <nav aria-label="Page navigation" style="margin-top: 20px;">
    <ul class="pagination justify-content-center" id="pagination"></ul>
  </nav>

  <script>
    const searchBtn = document.getElementById('searchBtn');
    const searchInput = document.getElementById('searchInput');
    let cards = Array.from(document.querySelectorAll('.card'));
    const noResultMessage = document.getElementById('noResultMessage');
    const pagination = document.getElementById('pagination');

    const cardsPerPage = 4;
    let currentPage = 1;

    // Fungsi menampilkan halaman tertentu dengan daftar kartu yang di-passing
    function showPage(page, list = cards) {
      currentPage = page;

      // sembunyikan semua kartu
      cards.forEach(card => card.style.display = 'none');

      // ambil kartu untuk halaman ini
      const start = (page - 1) * cardsPerPage;
      const end = start + cardsPerPage;
      const pageCards = list.slice(start, end);

      // tampilkan kartu yang sesuai halaman
      pageCards.forEach(card => card.style.display = '');

      // Tampilkan / sembunyikan pesan "Acara tidak ditemukan"
      if (pageCards.length === 0) {
        noResultMessage.style.display = 'block';
      } else {
        noResultMessage.style.display = 'none';
      }

      renderPagination(list);
    }

    // Fungsi buat tombol pagination
    function renderPagination(list) {
      pagination.innerHTML = '';

      const pageCount = Math.ceil(list.length / cardsPerPage);

      if (pageCount <= 1) return; // tidak perlu pagination jika cuma 1 halaman atau kurang

      // Tombol Previous
      const prevLi = document.createElement('li');
      prevLi.classList.add('page-item');
      if (currentPage === 1) prevLi.classList.add('disabled');
      prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous">&laquo;</a>`;
      prevLi.addEventListener('click', e => {
        e.preventDefault();
        if (currentPage > 1) showPage(currentPage - 1);
      });
      pagination.appendChild(prevLi);

      // Tombol halaman
      for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === currentPage) li.classList.add('active');
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', e => {
          e.preventDefault();
          showPage(i);
        });
        pagination.appendChild(li);
      }

      // Tombol Next
      const nextLi = document.createElement('li');
      nextLi.classList.add('page-item');
      if (currentPage === pageCount) nextLi.classList.add('disabled');
      nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next">&raquo;</a>`;
      nextLi.addEventListener('click', e => {
        e.preventDefault();
        if (currentPage < pageCount) showPage(currentPage + 1);
      });
      pagination.appendChild(nextLi);
    }

    // Toggle pencarian
    searchBtn.addEventListener('click', () => {
      if (searchInput.style.display === 'none') {
        searchInput.style.display = 'block';
        searchInput.focus();
      } else {
        searchInput.value = '';
        searchInput.style.display = 'none';
        // reset tampilkan semua kartu
        cards = Array.from(document.querySelectorAll('.card'));
        showPage(1, cards);
      }
    });

    // Fungsi pencarian & filter kartu
    searchInput.addEventListener('keyup', () => {
      const query = searchInput.value.toLowerCase();
      const filtered = cards.filter(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        return title.includes(query);
      });

      showPage(1, filtered);
    });

    // Sorting
    document.querySelectorAll('.sort-option').forEach(option => {
      option.addEventListener('click', function() {
        const order = this.getAttribute('data-sort');

        cards.sort((a, b) => {
          const dateA = new Date(a.querySelector('p:nth-child(2)').textContent.replace('Tanggal:', '').trim());
          const dateB = new Date(b.querySelector('p:nth-child(2)').textContent.replace('Tanggal:', '').trim());
          return order === 'asc' ? dateA - dateB : dateB - dateA;
        });

        showPage(1, cards);
      });
    });

    // Tampilkan halaman pertama saat load
    showPage(1);
  </script>

</body>

<?= $this->endSection() ?>