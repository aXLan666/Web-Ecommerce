<?php

include "koneksi.php";

if (isset($_POST['deleteUser'])) {
    if (isset($_POST['id_user'])) {
        $userId = $_POST['id_user'];

        $sql = mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$userId'");

        if ($sql) {
            header("location: ../admin.php?table=users");
        }
    } else {
        echo "users ID is missing.";
    }
}

if (isset($_POST['deleteProduk'])) {
        $id_barang = $_POST['id_barang'];
        $id_masuk = $_POST['id_masuk'];


        // Retrieve the image filename associated with the product
        $getImageQuery = "SELECT alamat_img FROM barang WHERE id_barang = '$id_barang'";
        $getImageResult = mysqli_query($koneksi, $getImageQuery);

        if ($getImageResult && $imageData = mysqli_fetch_assoc($getImageResult)) {
            $imageFilename = $imageData["alamat_img"];

            // Delete the image file from the server
            $imagePath = "../controller/uploads/" . $imageFilename;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the product from the database
        $deleteQuery = "DELETE FROM barang WHERE id_barang = '$id_barang'";
        $dStok = mysqli_query($koneksi, "DELETE FROM stok_masuk WHERE id_masuk = '$id_masuk'");
        $result = mysqli_query($koneksi, $deleteQuery);

        if ($result && $dStok) {
            echo "Data has been deleted successfully.";
            header("location: ../admin.php?table=barang");
        } else {
            echo "Error deleting data: " . mysqli_error($koneksi);
        }
    } else {
        echo "Product ID is missing.";
}

if (isset($_POST['deletePesanan'])) {
    $pesanan = $_POST['id_pesanan'];
    $id_barang = $_POST['id_barang'];

    $sql1 = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
    $sql2 = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan = '$pesanan'");
    $data2 = $sql2->fetch_assoc();
    $data1 = $sql1->fetch_assoc();
    $stok = $data1['stok'];
    $jumlah = $data2['jumlah'];
    $stok_baru = $stok + $jumlah;


    if ($sql2 && $sql1) {
        $sqlDlt = mysqli_query($koneksi, "DELETE FROM pesanan WHERE id_pesanan = '$pesanan'");
        $sqlUbahStok = mysqli_query($koneksi, "UPDATE barang SET stok = '$stok_baru' WHERE id_barang = '$id_barang'");
        if ($sqlUbahStok == true && $sqlDlt == true) {
            header("location: ../admin.php?table=pesanan");
        } else {
            echo "data gagal di hapus";
        }
    } else {
        echo "data gagal di hapus";
    };
}
