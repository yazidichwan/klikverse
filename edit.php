<?php
include 'db.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $kategori = $_POST['kategori'];
    $nama_barang = $_POST['nama_barang'];
    $nama_pembeli = $_POST['nama_pembeli'];
    $harga = $_POST['harga'];

    if ($kategori == 'barang') {
        $modal = $harga - 5000;
        $keuntungan = 5000;
    } else {
        $modal = 0;
        $keuntungan = $harga;
    }

    mysqli_query($conn, "UPDATE transaksi SET 
        kategori='$kategori',
        nama_barang='$nama_barang',
        nama_pembeli='$nama_pembeli',
        harga='$harga',
        modal='$modal',
        keuntungan='$keuntungan'
        WHERE id='$id'");

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Transaksi - KlikVerse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1 class="title">Edit Transaksi</h1>
    <form method="POST" class="form-box">
        <select name="kategori" required>
            <option value="barang" <?= $data['kategori'] == 'barang' ? 'selected' : '' ?>>Barang</option>
            <option value="jasa" <?= $data['kategori'] == 'jasa' ? 'selected' : '' ?>>Jasa</option>
        </select>
        <input type="text" name="nama_barang" value="<?= $data['nama_barang'] ?>" required>
        <input type="text" name="nama_pembeli" value="<?= $data['nama_pembeli'] ?>" required>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
        <button type="submit" name="update">💾 Simpan Perubahan</button>
        <a href="index.php" class="cancel-btn">Batal</a>
    </form>
</div>
</body>
</html>
