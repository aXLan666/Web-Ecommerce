<?php

include "koneksi.php";

if (isset($_POST['updateUser'])) {
    if (isset($_POST['id_user'])) {

        $id_user = $_POST['id_user'];

        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $update = mysqli_query($koneksi, "UPDATE `users` SET username='$username', password='$password', role='$role' WHERE id_user='$id_user'");

        if ($update) {
            header("location: ../admin.php?table=users");
        };
    } else {
        echo "users ID is missing.";
    }
}


if (isset($_POST['editProduk'])) {
    $id_barang = $_POST['id_barang'];
    $id_user = $_POST['id_user'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];

    // Check if a new image is uploaded
    if (empty($_FILES["form-img"]) || $_FILES["form-img"]["error"] == UPLOAD_ERR_NO_FILE) {
        // No new image uploaded, retain the existing one
        $getImageQuery = "SELECT alamat_img FROM barang WHERE id_barang = '$id_barang'";
        $getImageResult = mysqli_query($koneksi, $getImageQuery);
        if ($getImageResult && $imageData = mysqli_fetch_assoc($getImageResult)) {
            $alamat_img = $imageData["alamat_img"];
        }
    } elseif (isset($_FILES["form-img"])) {
        $targetDirectory = "uploads/";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES["form-img"]["name"], PATHINFO_EXTENSION));
        $hashedFileName = md5(uniqid() . $_FILES["form-img"]["name"]);
        $targetFile = $hashedFileName . "." . $imageFileType;

        // Check file size
        if ($_FILES["form-img"]["size"] > 5000000) {
            die("Sorry, your file is too large.");
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            die("Sorry, only JPG, JPEG, PNG, and GIF files are allowed.");
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["form-img"]["tmp_name"], $targetDirectory . $targetFile)) {
                echo "The file " . $hashedFileName . "." . $imageFileType . " has been uploaded.";
                // Delete the old image file if it exists
                $getImageQuery = "SELECT alamat_img FROM barang WHERE id_barang = '$id_barang'";
                $getImageResult = mysqli_query($koneksi, $getImageQuery);
                if ($getImageResult && $imageData = mysqli_fetch_assoc($getImageResult)) {
                    $oldImageFilename = $imageData["alamat_img"];
                    $oldImagePath = "uploads/" . $oldImageFilename;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }
        }
        $alamat_img = $targetFile;
    }

    // Update data in the database
    $updateQuery = mysqli_query(
        $koneksi,
        "UPDATE barang SET id_user = '$id_user', nama_barang = '$nama_barang', harga = '$harga', alamat_img = '$alamat_img' WHERE id_barang = '$id_barang'"
    );

    if ($updateQuery) {
        echo "Data has been updated successfully.";
        header("location: ../admin.php?table=barang");
    } else {
        echo "Error updating data: " . mysqli_error($koneksi);
    }
}

if (isset($_POST["editJumlah"])) {
    session_start();
    $id_pesanan = $_POST['id_pesanan'];
    $jumlah = $_POST['jumlah'];
    $id_barang = $_POST['id_barang'];
    $role = $_SESSION['role'];

    $sql = mysqli_query($koneksi, "SELECT jumlah FROM pesanan WHERE id_pesanan = $id_pesanan");
    $data2 = $sql->fetch_assoc();
    $jumlah_sekarang = $data2['jumlah'];
    $sql1 = mysqli_query($koneksi, "SELECT harga,stok FROM barang WHERE id_barang = $id_barang");
    $data1 = $sql1->fetch_assoc();
    $harga = $data1['harga'];
    $stok = $data1['stok'];

    $total_harga = $jumlah * $harga;

    if ($jumlah_sekarang > $jumlah && $jumlah > 0) {
        $stok_baru = $stok + ($jumlah_sekarang - $jumlah);
        $sqlUbahStok = mysqli_query($koneksi, "UPDATE barang SET stok = $stok_baru WHERE id_barang = $id_barang");
        $sqlEdit = mysqli_query($koneksi, "UPDATE pesanan SET jumlah = $jumlah, sub_total = $total_harga WHERE id_pesanan = $id_pesanan");
        if ($sqlEdit == true && $sqlUbahStok == true) {
            if ($role === "Pelanggan") {
                header("location: ../pelanggan/index.php");
            } else {
                header("location: ../admin.php?table=pesanan");
            }
        } else {
            echo "data jumlah gagal di ubah";
        }
    } elseif ($jumlah_sekarang < $jumlah) {
        $stok_baru = $stok - ($jumlah - $jumlah_sekarang);
        $sqlUbahStok = mysqli_query($koneksi, "UPDATE barang SET stok = $stok_baru WHERE id_barang = $id_barang");
        $sqlEdit = mysqli_query($koneksi, "UPDATE pesanan SET jumlah = $jumlah, sub_total = $total_harga WHERE id_pesanan = $id_pesanan");
        if ($sqlEdit == true && $sqlUbahStok == true) {
            if ($role === "Pelanggan") {
                header("location: ../pelanggan/index.php");
            } else {
                header("location: ../admin.php?table=pesanan");
            }
        } else {
            echo "data jumlah gagal di ubah";
        };
    } elseif ($jumlah === 0) {
        $stok_baru = $stok + $jumlah;
        $sqlUbahStok = mysqli_query($koneksi, "UPDATE barang SET stok = $stok_baru WHERE id_barang = $id_barang");
        $sqlDP = mysqli_query($koneksi, "DELETE FROM pesanan WHERE id_pesanan = $id_pesanan");
        if ($sqlDP == true && $sqlUbahStok == true) {
            if ($role === "Pelanggan") {
                header("location: ../pelanggan/index.php");
            } else {
                header("location: ../admin.php?table=pesanan");
            }
        } else {
            echo "data jumlah gagal di ubah";
        }
    }
};
