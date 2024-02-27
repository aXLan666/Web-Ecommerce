<?php
if (isset($_GET['table'])) {
    $url = $_GET['table'];

    switch ($url) {
        case 'pembayaran';
            include './page-tables/pembayaran.php';
            break;
        case 'pesanan';
            include './page-tables/pesanan.php';
            break;
        case 'stok';
            include './page-tables/stok.php';
            break;                        
        case 'barang';
            include './page-tables/barang.php';
            break;
        case 'users';
            include './page-tables/user.php';
            break;
        default;
            include './admin.php';
            break;
    }
}
