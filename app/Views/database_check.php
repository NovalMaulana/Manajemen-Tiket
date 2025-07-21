<?php
// Cek koneksi dan ambil data
$db      = \Config\Database::connect();
$version = $db->getVersion();
$dbName  = $db->database;

try {
    $db->initialize();
    $status  = 'Berhasil';
    $message = 'Koneksi ke database berhasil dilakukan.';
} catch (\Exception $e) {
    $status  = 'Gagal';
    $message = 'Koneksi gagal: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Status Koneksi Database</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      max-width: 600px;
      width: 90%;
      background-color: #ffffff;
      padding: 32px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    h1 {
      font-size: 24px;
      margin-bottom: 24px;
      color: #333;
      text-align: center;
    }

    .status {
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 24px;
    }

    .success {
      background-color: #e6f4ea;
      color: #2e7d32;
      border: 1px solid #c8e6c9;
    }

    .error {
      background-color: #fdecea;
      color: #c62828;
      border: 1px solid #f5c6cb;
    }

    .status h2 {
      margin: 0 0 8px 0;
      font-size: 20px;
    }

    .info {
      background-color: #f4f4f4;
      padding: 16px;
      border-radius: 8px;
      font-size: 14px;
      color: #333;
    }

    .info p {
      margin: 8px 0;
    }

    strong {
      color: #000;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Status Koneksi Database</h1>

    <div class="status <?= $status === 'Berhasil' ? 'success' : 'error' ?>">
      <h2><?= $status ?></h2>
      <p><?= $message ?></p>
    </div>

    <div class="info">
      <h3>Informasi Database</h3>
      <p><strong>Versi MySQL:</strong> <?= $version ?></p>
      <p><strong>Host:</strong> <?= getenv('database.default.hostname') ?: 'Tidak diketahui' ?></p>
      <p><strong>Nama Database yang Terhubung:</strong> <?= $dbName ?: 'Tidak diketahui' ?></p>
    </div>
  </div>
</body>
</html>
