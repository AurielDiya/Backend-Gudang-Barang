<?php
// Buat koneksi ke database
require 'function.php';
require 'ceklogin.php';
$pekerja = $_SESSION['nama_pekerja'];

// Eksekusi query untuk mendapatkan data dari view "view_transaksi"
$result = mysqli_query($koneksi, "SELECT * FROM view_transaksi_stock");

// Jika data tidak ditemukan, tampilkan pesan error
if(mysqli_num_rows($result) == 0) {
    echo "Tidak ada data transaksi";
}
else {
    // Tampilkan data transaksi di laman web dengan menggunakan tabel
    echo "<table>
            <thead>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>";

    while($row = mysqli_fetch_assoc($result)) {// looping untuk mengambil data dari hasil query pada variabel $result
        echo "<tr>
                <td>".$row['id_barang']."</td>
                <td>".$row['nama_barang']."</td>
                <td>".$row['jumlah']."</td>
                <td>".$row['ket']."</td>
                <td>".$row['tanggal']."</td>
            </tr>";
    }

    echo "</tbody></table>";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Hasil Jumlah Stok</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
	<style>
		table {
			font-size: 20px;
			border-collapse: collapse;
			text-align: center;
            background-color: #f2f2f2;
			color: black;
            position: absolute; /* agar posisi tabel dapat diatur relatif terhadap parent element */
            bottom: 0; 
            left: 310px; 
            margin-bottom: 250px;
            margin-right: 0px; 
		}
		th, td {
			padding: 40px;
			border: 3px solid black;
		}
	</style>
    <title>View Transaksi</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            /* background-color: #f2f2f2; */
            background-color:cornflowerblue;
        }
    </style>
</head>
<body>
<body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Thrifty Treasures</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <p class="nav-link"> 
                                Selamat datang, <?php echo $pekerja; ?>
                            </p>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="deskripsi.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Deskripsi Barang
                            </a>
                            <a class="nav-link" href="Total_Stok.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Total Keseluruhan
                            </a>
                            <a class="nav-link" href="view_transaksi.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                View Transaksi
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
	<table>
    <h1>View Transaksi</h1>
</body>
</html>