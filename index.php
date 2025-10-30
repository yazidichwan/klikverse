<?php
include 'db.php';

// Tambah transaksi
if (isset($_POST['submit'])) {
    $kategori = $_POST['kategori'];
    $nama_barang = $_POST['nama_barang'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $harga = $_POST['harga'];

    // Modal dan keuntungan otomatis
    if ($kategori == 'barang') {
        $modal = $harga - 5000;
        $keuntungan = 5000;
    } else {
        $modal = 0;
        $keuntungan = $harga;
    }

    $sql = "INSERT INTO transaksi (kategori, nama_barang, nama_pembeli, harga, modal, keuntungan) 
            VALUES ('$kategori', '$nama_barang', '$nama_pembeli', '$harga', '$modal', '$keuntungan')";
    mysqli_query($conn, $sql);
}

// Hapus transaksi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM transaksi WHERE id=$id");
    header("Location: index.php");
}

// Ambil data transaksi
$result = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC");

// Hitung total keuntungan hari ini
$total_harian_query = mysqli_query($conn, "SELECT SUM(keuntungan) AS total_harian FROM transaksi WHERE DATE(tanggal) = CURDATE()");
$total_harian_data = mysqli_fetch_assoc($total_harian_query);
$total_harian = $total_harian_data['total_harian'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KlikVerse Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

        <h1 class="judul">Dashboard KlikVerse</h1>
        <p class="quote">“Kerja, Kerja, Kerja”</p>

        <form method="POST" class="input-form">
            <select name="kategori" required>
                <option value="barang">Barang</option>
                <option value="jasa">Jasa</option>
            </select>
            <input type="text" name="nama_barang" placeholder="Nama Barang/Jasa" required>
            <input type="text" name="nama_pembeli" placeholder="Nama Pembeli" required>
            <input type="number" name="harga" placeholder="Harga (Rp)" required>
            <button type="submit" name="submit" class="btn-tambah">Tambah</button>
        </form>

        <div class="total-harian">
            💰 Total Keuntungan Hari Ini: <b>Rp <?= number_format($total_harian, 0, ',', '.') ?></b>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Kategori</th>
                <th>Nama Barang/Jasa</th>
                <th>Nama Pembeli</th>
                <th>Harga</th>
                <th>Modal</th>
                <th>Keuntungan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= ucfirst($row['kategori']) ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['nama_pembeli'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($row['modal'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($row['keuntungan'], 0, ',', '.') ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏️</a>
                    <a href="index.php?delete=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Yakin ingin hapus?')">🗑️</a>
                </td>
            </tr>
            <?php } ?>
        </table>

        <form action="clear.php" method="POST" class="clear-form">
            <button type="submit" class="btn-clear" onclick="return confirm('Yakin hapus semua transaksi?')">🧹 Clear Semua Transaksi</button>
        </form>

        <a href="logout.php" class="btn-logout">🚪 Logout</a>
    </div>
</body>
</html>
