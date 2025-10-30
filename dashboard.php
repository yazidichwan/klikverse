<?php
session_start();
include 'db.php';

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Tambah transaksi
if (isset($_POST['submit'])) {
    $kategori = $_POST['kategori'];
    $nama_barang = $_POST['nama_barang'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $harga = $_POST['harga'];
    $modal = $_POST['modal'];

    if ($kategori == 'jasa') {
        $keuntungan = $harga; // jasa = sesuai harga
    } else {
        $keuntungan = 5000; // barang = 5000
    }

    $query = "INSERT INTO transaksi (kategori, nama_barang, nama_pembeli, harga, modal, keuntungan)
              VALUES ('$kategori', '$nama_barang', '$nama_pembeli', '$harga', '$modal', '$keuntungan')";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
    exit();
}

// Hapus transaksi
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM transaksi WHERE id=$id");
    header("Location: dashboard.php");
    exit();
}

// Clear semua transaksi
if (isset($_POST['clear'])) {
    mysqli_query($conn, "TRUNCATE TABLE transaksi");
    header("Location: dashboard.php");
    exit();
}

// Ambil data
$transaksi = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>KlikVerse Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Dashboard KlikVerse</h1>
        <p class="quote">"Kerja, kerja, kerja"</p>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="form-container">
        <h2>Tambah Transaksi</h2>
        <form method="POST">
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="barang">Barang</option>
                <option value="jasa">Jasa</option>
            </select>
            <input type="text" name="nama_barang" placeholder="Nama Barang / Jasa" required>
            <input type="text" name="nama_pembeli" placeholder="Nama Pembeli" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <input type="number" name="modal" placeholder="Modal" required>
            <button type="submit" name="submit">Tambah</button>
        </form>
    </div>

    <div class="table-container">
        <h2>Data Transaksi</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Nama Pembeli</th>
                <th>Harga</th>
                <th>Modal</th>
                <th>Keuntungan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($transaksi)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['kategori'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['nama_pembeli'] ?></td>
                <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>Rp<?= number_format($row['modal'], 0, ',', '.') ?></td>
                <td>Rp<?= number_format($row['keuntungan'], 0, ',', '.') ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td>
                    <a href="?hapus=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Hapus transaksi ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>

        <form method="POST" onsubmit="return confirm('Hapus semua transaksi?')">
            <button type="submit" name="clear" class="clear-btn">Clear Semua Transaksi</button>
        </form>
    </div>
</div>
</body>
</html>
