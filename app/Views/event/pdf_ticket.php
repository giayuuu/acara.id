<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Kartu Acara</title>
  <style>
    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 0 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
      border: 4px solid #ddd;
      background-color: #f5f5f5;
    }

    td {
      padding: 10px;
      border: 4px solid #ddd;
      vertical-align: top;
    }

    .confirmation-table {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin-bottom: 15px;
      border: none;
      /* Hilangkan border */
      border-radius: 10px;
      /* Menambahkan kelengkungan pada sudut */
    }

    .confirmation-table td {
      padding: 10px;
      font-size: 14px;
      text-align: left;
      font-weight: bold;
      background-color: #dff0d8;
      color: #57784d;
      border: none;
      border-radius: 4px;
    }

    .row-event-header td {
      background-color: #ffffff;
      font-weight: bold;
      font-size: 18px;
    }

    .row-event-details td,
    .row-participant td,
    .row-registration td {
      background-color: #ffffff;
      font-size: 14px;
    }

    .row-registration td {
      text-align: center;
    }

    .col-logo,
    .col-qrcode {
      text-align: center;
      vertical-align: middle;
      padding: 15px;
    }

    .col-logo img,
    .col-qrcode img {
      max-width: 100px;
      max-height: 100px;
      display: block;
      margin: 0 auto;
    }

    .col-event-name {
      text-transform: uppercase;
    }

    .col-time,
    .col-location,
    .col-registered-at {
      line-height: 1.5;
      text-align: right;
    }

    .gray-label {
      color: gray;
    }

    .footer {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin-top: 15px;
    }

    .col-qrcode-box {
      border: 2px solid #333;
      padding: 5px;
      display: inline-block;
      border-radius: 3px;
    }

    .scan-me {
      font-size: 10px;
      color: gray;
      margin-bottom: 5px;
      display: block;
    }

    .line-above-instansi {
      border-top: 1px solid #ddd;
      margin: 10px 0 5px 0;
    }
  </style>
</head>

<body>

  <div class="container">
    <table class="confirmation-table">
      <tr>
        <td>
          Mohon tunjukan bukti konfirmasi ini pada saat acara belangsung
        </td>
      </tr>
    </table>

    <table>
      <tr class="row-event-header">
        <td colspan="2" class="col-event-name">
          acara<br>
          <?= $event['name'] ?>
        </td>
        <td rowspan="2" class="col-logo">
          <img src="<?= $logo_path ?>" alt="Logo">


        </td>
      </tr>
      <tr class="row-event-details">
        <td class="col-time">
          <span class="gray-label">Waktu</span><br>
          <?= $date ?><br>
          <?= $event['time'] ?>
        </td>
        <td class="col-location">
          <span class="gray-label">Lokasi</span><br>
          <?= $event['location'] ?>
        </td>
      </tr>
      <tr class="row-participant">
        <td colspan="2" class="col-participant-info">
          <span class="gray-label">Peserta</span><br>
          <strong><?= $user['full_name'] ?></strong><br>
          <?= $user['nip'] ?><br>
          <?= $user['position'] ?><br>
          <div class="line-above-instansi"></div>
          <span class="gray-label">Dinas</span><br>
          <?= $user['dinas'] ?>
        </td>
        <td rowspan="2" class="col-qrcode">
          <div class="col-qrcode-box">
            <span class="scan-me">scan me</span>
            <img src="data:image/png;base64,<?= $qr_code_path ?>" alt="QR Code">
          </div>
        </td>
      </tr>
      <tr class="row-registration">
        <td colspan="2" class="col-registered-at">
          Registrasi pada: <?= $registered_at ?>
        </td>
      </tr>
    </table>

    <div class="footer">
      <p>Catatan:</p>
      <ol>
        <li>Harap bukti registrasi ini dibawa pada saat acara.</li>
        <li>Harap hadir 30 menit sebelum acara dimulai.</li>
      </ol>
    </div>
  </div>

</body>

</html>