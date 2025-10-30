CREATE DATABASE klikverse;
USE klikverse;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) VALUES ('admin', '12345');

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori ENUM('Barang','Jasa') NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    nama_pembeli VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    modal INT NOT NULL,
    keuntungan INT NOT NULL,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
