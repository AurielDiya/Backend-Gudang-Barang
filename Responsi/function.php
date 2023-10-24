<?php

    session_start();

    //Koneksi ke database
    $koneksi = mysqli_connect("localhost", "root", "", "thrifting");

    //input deskripsi
    if(isset($_POST['submitdeskripsi'])){
        $deskripsi = $_POST['deskripsi'];
        try {
           $adddeskripsi = mysqli_query($koneksi, "insert into deskripsi (deskripsi) values ('$deskripsi')");
           if($adddeskripsi){
                echo"
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
           }
        } catch (Exception $e) { // menangani error pada script 
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header('location:deskripsi.php#eror');
            exit;
        }
    }

    //delete deskripsi
    if(isset($_POST['hapusdeskripsi'])){
        $id = $_POST['idd'];
        
        $deletedeskripsi = mysqli_query($koneksi, "delete from deskripsi where id = '$id'");
        if($deletedeskripsi){
            echo"
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
       }
    }

    //input barang
    if(isset($_POST['submit'])){
        $namabarang = $_POST['namabarang'];
        $deskripsi = $_POST['listdesc'];
        $stok = $_POST['stok'];

        try {
            $addbarang = mysqli_query($koneksi, "call ManageStok('insert', 'null', '$namabarang', '$deskripsi', '$stok')");
            if($addbarang){
                echo"
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
            }
         } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header('location:index.php#eror');
                exit;
         }
    }

    //update barang
    if(isset($_POST['updatebarang'])){
        $idb = $_POST['idb'];
        $deskripsi = $_POST['listdesc'];

        $updatebarang = mysqli_query($koneksi, "call ManageStok('update', '$idb', 'null', '$deskripsi', 'null')");

        if($updatebarang){
            echo"
                <script>
                    alert('Data Berhasil Diperbarui!');    
                </script>
            ";
       }
    }

    //hapus barang
    if(isset($_POST['hapusbarang'])){
        $idb = $_POST['idb'];

        $hapusbarang = mysqli_query($koneksi, "call ManageStok('delete', '$idb', 'null', 'null', 'null')");

        if($hapusbarang){
            echo"
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
       }
    }

    //input barang masuk
    if(isset($_POST['barangmasuk'])){
        $listbarang = $_POST['listbarang'];
        $jumlahmasuk = $_POST['jumlahmasuk'];
        $listpegawai = $_SESSION['id_pekerja'];

        $addbarangmasuk = mysqli_query($koneksi, "call ManageTransaksi('insert', 'null', '$listbarang', '$listpegawai', '$jumlahmasuk','Masuk')");

        if($addbarangmasuk){
            echo"
                <script>
                    alert('Data Berhasil Ditambahkan!');    
                </script>
            ";
       }
    }

    //update barang masuk
    if(isset($_POST['updatebarangmasuk'])){
        $idt = $_POST['idt'];
        $jumlah = $_POST['jumlahmasuk'];

        $updatebarangmasuk = mysqli_query($koneksi, "call ManageTransaksi('update', '$idt', 'null', 'null', '$jumlah', 'Masuk')");

        if($updatebarangmasuk){
            echo"
                <script>
                    alert('Data Berhasil Diperbarui!');    
                </script>
            ";
       }
    }

    //delete barang masuk
    if(isset($_POST['hapusbarangmasuk'])){
        $idt = $_POST['idt'];
        
        $hapusbarangmasuk = mysqli_query($koneksi, "call ManageTransaksi('delete', '$idt', 'null', 'null', 'null', 'null')");

        if($hapusbarangmasuk){
            echo"
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
       }
    }


    //input barang keluar
    if(isset($_POST['barangkeluar'])){
        $listbarang = $_POST['listbarang'];
        $jumlahkeluar = $_POST['jumlahkeluar'];
        $listpegawai = $_SESSION['id_pekerja'];

        try {
            $addbarangkeluar = mysqli_query($koneksi, "call ManageTransaksi('insert', 'null', '$listbarang', '$listpegawai', '$jumlahkeluar','Out')");
            if($addbarangkeluar){
                echo"
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
           }
         } catch (Exception $e) {
             $_SESSION['error'] = "Error: " . $e->getMessage();
             header('location:keluar.php#eror');
             exit;
         }
    }
    
    //update barang keluar
    if(isset($_POST['updatebarangkeluar'])){
        $idt = $_POST['idt'];
        $jumlah = $_POST['jumlahkeluar'];

        try {
            $updatebarangkeluar = mysqli_query($koneksi, "call ManageTransaksi('update', '$idt', 'null', 'null', '$jumlah','Out')");
            if($updatebarangkeluar){
                echo"
                    <script>
                        alert('Data Berhasil Diperbarui!');    
                    </script>
                ";
           }
         } catch (Exception $e) {
             $_SESSION['error'] = "Error: " . $e->getMessage();
             header('location:keluar.php#eror');
             exit;
         }
    }

    //delete barang keluar
    if(isset($_POST['hapusbarangkeluar'])){
        $idt = $_POST['idt'];
        
        $hapusbarangkeluar = mysqli_query($koneksi, "call ManageTransaksi('delete', '$idt', null, null, 'null','null')");

        if($hapusbarangkeluar){
            echo"
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
       }
    }    

?>