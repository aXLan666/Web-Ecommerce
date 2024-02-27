<?php

include "koneksi.php";

if (isset($_POST["TambahUser"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username) || empty($password) || empty($role)) {
        echo "Input tidak boleh kosong. Silakan lengkapi semua field.";
        die(); // Berhenti eksekusi kode
    }

    $insert = mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");

    if ($insert) {
        header("location: ../admin.php?table=users");
    }
    ;
}
;

if (isset($_POST["RegisterPelanggan"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $Confpassword = $_POST['ConfPassword'];
    $no = $_POST['nomor_hp'];
    $alamat = $_POST['alamat'];

    if (empty($username) || empty($password) || empty($Confpassword) || empty($no) || empty($alamat)) {
        echo "Input tidak boleh kosong. Silakan lengkapi semua field.";
        die(); // Berhenti eksekusi kode
    }

    if ($password === $Confpassword) {
        $insert = mysqli_query($koneksi, "INSERT INTO users (`username`, `password`, `nomor_Hp`, `alamat`, `role`) VALUES ('$username','$password','$no','$alamat','Pelangan')");
        if ($insert) {
            header("location: ../admin.php?table=users");
        }
    } else {
        echo "password harus sama";
    }


}
;

if (isset($_POST['addProduk'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Check if 'image' is set in $_FILES array
    if (isset($_FILES["alamat_img"])) {
        $targetDirectory = "uploads/";  // Specify the folder where images will be stored
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES["alamat_img"]["name"], PATHINFO_EXTENSION));

        // Generate a unique name for the image using MD5 hash
        $hashedFileName = md5(uniqid() . $_FILES["alamat_img"]["name"]);
        $targetFile = $hashedFileName . "." . $imageFileType;

        // Check if the image file is an actual image
        $check = getimagesize($_FILES["alamat_img"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["alamat_img"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }

        $alamat_img = $targetFile;

        // Insert data into the database only if upload was successful
        if ($uploadOk) {
            $insertQuery = mysqli_query(
                $koneksi,
                "INSERT INTO barang (nama_barang, harga, stok, alamat_img) VALUES ('$nama_barang', '$harga', '$stok', '$alamat_img')"
            );
            if ($insertQuery) {
                $tanggal_masuk = date('Y-m-d H:i:s');
                $sqlFB = mysqli_query($koneksi, "SELECT id_barang FROM barang WHERE alamat_img = '$alamat_img'");
                $dataFB = $sqlFB->fetch_assoc();
                $id_barang = $dataFB['id_barang'];
                $sqlStokMasuk = mysqli_query($koneksi, "INSERT INTO stok_masuk
                (id_barang, jumlah, tanggal_masuk) VALUES ('$id_barang', '$stok', '$tanggal_masuk')");
                if ($sqlStokMasuk) {
                    echo "Data has been inserted into the database.";
                    header("location: ../admin.php?table=barang");
                } else {
                    echo "Error inserting data into the database: " . mysqli_error($koneksi);
                }
            } else {
                echo "Error inserting data into the database: " . mysqli_error($koneksi);
            }
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["alamat_img"]["tmp_name"], $targetDirectory . $targetFile)) {
                echo "The file " . $hashedFileName . "." . $imageFileType . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Image file is not set.";
    }
    // }
}

if (isset($_POST['addStok'])) {
    $id_barang = $_POST['id_barang'];
    $stok = $_POST['stok'];
    $tanggal_masuk = date('Y-m-d H:i:s');

    $sqlGDB = mysqli_query($koneksi, "SELECT stok FROM barang WHERE id_barang = '$id_barang'");
    $data = $sqlGDB->fetch_assoc();
    $stokBarang = $data['stok'];
    $stok_baru = $stok + $stokBarang;
    $sqlAS = mysqli_query($koneksi, "INSERT INTO stok_masuk (id_barang, jumlah, tanggal_masuk) VALUES ('$id_barang', '$stok', '$tanggal_masuk')");
    $sqlAB = mysqli_query($koneksi, "UPDATE barang SET stok = '$stok_baru' WHERE id_barang = '$id_barang'");

    if ($sqlAS && $sqlAB) {
        header('location: ../admin.php?table=stok');
    } else {
        echo "gagal masukan stok";
    }
}

if (isset($_POST['addPesan'])) {
    if ($id_user = $_POST['id_user'] === null) {
        $id_user = 20;
    } else {
        $id_user = $_POST['id_user'];
    };
    $role = $_POST['role'];
    $id_barang = $_POST['id_barang'];
    $jumlah_baru = $_POST['jumlah_pesanan'];

    // cek data barang
    $sqlGetDataBarang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
    $data = $sqlGetDataBarang->fetch_assoc();
    $harga = $data['harga'];

    $sqlCheckPesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_user = '$id_user' AND id_barang = '$id_barang'");
    $sqlCheckPL = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_user = '$id_user'");
    $data2 = $sqlCheckPL->fetch_assoc();
    $data1 = $sqlCheckPesanan->fetch_assoc();


    // cek jika data barang dan cek di pesanan terdapat baris data user yang sudah pesan
    if ($sqlCheckPesanan->num_rows === 1) {
        $jumlah = $data1['jumlah'] + $jumlah_baru;
        $total_harga = $data1['sub_total'] + ($data['harga'] * $jumlah_baru);
        $stok = $data['stok'] - $jumlah_baru;
        $id_item = $data1['id_item'];

        $sqlAddPesanan = mysqli_query($koneksi, "UPDATE pesanan SET id_item = '$id_item', jumlah = '$jumlah', sub_total = '$total_harga' WHERE id_user = '$id_user' AND id_barang = '$id_barang'");
        if ($sqlAddPesanan) {
            $sqlUbahStok = mysqli_query($koneksi, "UPDATE barang SET stok = '$stok' WHERE id_barang = '$id_barang'");
            if ($sqlUbahStok) {
                if ($role === "Pelanggan") {
                    header("location: ../pelanggan/index.php");
                } else {
                    header("location: ../admin.php?table=pesanan");
                }
            } else {
                echo "gagal ubah stok";
            }
        } else {
            echo "gagal ubah data item";
        }
        echo "stok tidak mencukupi";
    }
    // jika user belum melakukan pesanan
    // tidak ada data yang di temukan
    elseif ($data2['id_user'] === $id_user) {
        $total_harga = $harga * $jumlah_baru;
        $id_item = $data2['id_item'];

        if ($jumlah_baru > $data['stok']) {
            echo '<script>
            alert("stok tidak mencukupi, silahkan periksa kembali pesanan anda");
            var conf = confirm("apakah anda ingin melanjutkan pesanan?");
            if(conf == true){
                window.location.href="../admin.php?table=pesanan";
            }
            </script>';
        } else {
            $stok = $data['stok'] - $jumlah_baru;
            $sqlAddPesanan = mysqli_query($koneksi, "INSERT INTO pesanan (id_item, id_user, id_barang, jumlah, sub_total) VALUE ('$id_item', '$id_user', '$id_barang', '$jumlah_baru', '$total_harga')");
            if ($sqlAddPesanan) {
                $sqlUbahStok = mysqli_query($koneksi, "UPDATE barang SET stok = '$stok' WHERE id_barang = '$id_barang'");
                if ($sqlUbahStok) {
                    if ($role === "Pelanggan") {
                        header("location: ../pelanggan/index.php");
                    } else {
                        header("location: ../admin.php?table=pesanan");
                    }
                } else {
                    echo "gagal ubah stok";
                }
            } else {
                echo "data pesanan gagal di tambahkan";
            }
        }
    } else {
        $total_harga = $harga * $jumlah_baru;
        $id_item = mt_rand(100, 999);
        if ($jumlah_baru > $data['stok']) {
            echo '<script>
            alert("stok tidak mencukupi, silahkan periksa kembali pesanan anda");
            var conf = confirm("apakah anda ingin melanjutkan pesanan?");
            if(conf == true){
                window.location.href="../admin.php?table=pesanan";
            }
            </script>';
        } else {
            $stok = $data['stok'] - $jumlah_baru;
            $sqlAddPesanan = mysqli_query($koneksi, "INSERT INTO pesanan
            (id_item, id_user, id_barang, jumlah, sub_total)
            VALUE ('$id_item', '$id_user', '$id_barang', '$jumlah_baru', '$total_harga')");
            if ($sqlAddPesanan) {
                $sqlUbahStok = mysqli_query($koneksi, "UPDATE barang SET stok = '$stok' WHERE id_barang = '$id_barang'");
                if ($sqlUbahStok) {
                    if ($role === "Pelanggan") {
                        header("location: ../pelanggan/index.php");
                    } else {
                        header("location: ../admin.php?table=pesanan");
                    }
                } else {
                    echo "gagal ubah stok";
                }
            } else {
                echo "data pesanan gagal di tambahkan";
            }
        }
    }
}

if (isset($_POST['buatPembayaran'])) {
    $id_item = $_POST['id_item'];

    $sqlSD = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_item = '$id_item'");
    while ($data = $sqlSD->fetch_assoc()) {
        $jumlah = $data['jumlah'];
        $sub_total = $data['sub_total'];

        $sqlCB = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_item = '$id_item'");
        if ($sqlCB->num_rows === 0) {
            $sqlAB = mysqli_query($koneksi, "INSERT INTO `pembayaran`(`id_item`, `jumlah`, `harga`) VALUES ('$id_item','$jumlah','$sub_total')");
            if ($sqlAB == true) {
                header("location: ../pelanggan/index.php");
            } else {
                echo "gagal";
            }
        } elseif ($sqlCB->num_rows > 0) {
            $data = $sqlCB->fetch_assoc();
            $harga = $data['harga'];
            $total_pembayaran = $harga + $sub_total;
            $sqlAB = mysqli_query($koneksi, "UPDATE pembayaran SET harga = '$total_pembayaran' WHERE id_item = '$id_item'");
            if ($sqlAB == true) {
                header("location: ../pelanggan/index.php");
            } else {
                echo "gagal";
            }
        }
    }
}

if (isset($_POST['BayarPesanan'])) {
    $pembayaran = (int) filter_var($_POST['pembayaran'], FILTER_SANITIZE_NUMBER_INT);
    $pesanan = $_POST['id_pesanan'];
    $id_order = $_POST['id_item'];

    $sqlPembayaran = mysqli_query($koneksi, "SELECT pembayaran.*, pesanan.* FROM pembayaran INNER JOIN pesanan ON pembayaran.id_item = pesanan.id_item");
    $data = $sqlPembayaran->fetch_assoc();
    $id_user = $data['id_user'];
    $total_harga = $data['harga'];

    $kembalian = $pembayaran - $total_harga;
    $tanggal_transaksi = date('Y-m-d H:i:s');

    if ($kembalian < 0) {
        echo "uang anda kurang";
    } else {
        $sqlUbahPembayaran = mysqli_query($koneksi, "INSERT INTO riwayat_pesanan (`id_user`, `total_harga`, `total_uang`, `kembalian`, `tanggal_transaksi`)
        VALUES ('$id_user', '$total_harga', '$pembayaran', '$kembalian', '$tanggal_transaksi')");

        if ($sqlUbahPembayaran) {
            $sqlHapusPembayaran = mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_item = '$id_order'");

            $sqlSD = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_item = '$id_item'");
            while ($sqlSD) {
                $sqlI = mysqli_query($koneksi, "INSERT INTO ");
            }
            if ($sqlHapusPembayaran) {
                $sqlHapusPesanan = mysqli_query($koneksi, "DELETE FROM pesanan WHERE id_item = '$id_order'");
                if ($sqlHapusPesanan) {
                    header("location: ../admin.php?table=riwayat");
                } else {
                    echo "gagal menghapus";
                }
            } else {
                echo "gagal menghapus";
            }
        } else {
            echo "gagal mengubah";
        }
    }
}
;
