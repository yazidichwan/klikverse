<?php
include 'db.php';

mysqli_query($conn, "TRUNCATE TABLE transaksi");
header("Location: index.php");
exit();
?>
