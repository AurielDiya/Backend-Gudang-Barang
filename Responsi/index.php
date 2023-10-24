<?php
    require 'function.php';
    require 'ceklogin.php';
    $pekerja = $_SESSION['nama_pekerja'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
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
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                            </div>
                            <div class="card-body">
                                <?php
                                    $cekstock = mysqli_query($koneksi, "select * from stock where stok < 5");
                                    while($data = mysqli_fetch_array($cekstock)){
                                        $barang = $data['nama'];
                                ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Perhatian!</strong> Stok <?=$barang;?> Tersisa Sedikit
                                </div>
                                <?php
                                    }
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr align = "center">
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Jumlah Stok</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $liststock = mysqli_query($koneksi, "select * from stock s, deskripsi d where s.fdeskripsi = d.id");
                                                $i = 1;
                                                while($data = mysqli_fetch_array($liststock)){
                                                    $namabarang = $data['nama'];
                                                    $deskripsi = $data['deskripsi'];
                                                    $stock = $data['stok'];
                                                    $idb = $data['id_barang'];                                                
                                            ?>
                                            <tr align = "center">
                                                <td><?=$i++;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stock;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idb;?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idb;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <div class="form-control"><?= $namabarang; ?></div>
                                                                <br>
                                                                <select name="listdesc" class="form-control">
                                                                    <?php
                                                                        $ambildata = mysqli_query($koneksi, "select * from deskripsi");
                                                                        while($fetcharray = mysqli_fetch_array($ambildata)){
                                                                            $id = $fetcharray['id'];
                                                                            $deskripsi = $fetcharray['deskripsi']; //ambil nilai desk
                                                                    ?>
                                                                    <option value="<?=$id;?>"><?=$deskripsi;?></option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">      
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" name="updatebarang">Edit</button>
                                                                </div>                  
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idb;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Yakin ingin menghapus <?=$namabarang?>?
                                                                <br> <br>
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                                </div>                  
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                };
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Thrifty Treasures 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
                        <br>
                        <select name="listdesc" class="form-control">
                            <?php
                                $ambildata = mysqli_query($koneksi, "select * from deskripsi");
                                while($fetcharray = mysqli_fetch_array($ambildata)){
                                    $id = $fetcharray['id'];
                                    $deskripsi = $fetcharray['deskripsi'];
                            ?>
                            <option value="<?=$id;?>"><?=$deskripsi;?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <br>
                        <input type="number" name="stok" placeholder="Stok" class="form-control" required>      
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>                  
                    </div>
                </form>
             </div>
        </div>
    </div>
    <div class="modal-header" id="eror">
        <?php 
            if(isset($_SESSION['error'])){
                echo "<script>alert('".$_SESSION['error']."');</script>";
                unset($_SESSION['error']);
            }
        ?>      
    </div>

</html>