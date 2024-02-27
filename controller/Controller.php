<?php

include 'koneksi.php';
session_start();

if (isset($_POST['Login'])) {
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $stmt->close();

    if ($data) {
        if ($data['role'] == 'Admin' || $data['role'] == 'Kasir') {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = "Admin";
            $_SESSION['id_user'] = $data['id_user'];
            header("location: ../admin.php?table=users");
        } elseif ($data['role'] == 'Pelanggan') {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = "Pelanggan";
            $_SESSION['id_user'] = $data['id_user'];
            header("location: ../pelanggan/index.php");
        }
    } else {
        header("location:../index.php?pesan=gagal");
    }
}

if (isset($_POST['logout'])) {
    session_start();
    session_destroy();
    header("location: ../index.php");
}

if (!empty($_GET['cari_barang'])) {
    $cari = trim(strip_tags($_POST['keyword']));
    if ($cari != '') {
        $sql = "SELECT * FROM barang WHERE id_barang LIKE '%$cari%' OR nama_barang LIKE '%$cari%'";
        $result = mysqli_query($koneksi, $sql);
        if ($result) {
            ?>
            <table class="table table-stripped" width="100%" id="example2">
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga keranjang</th>
                    <th>Stok</th>
                    <th>Foto Barang</th>
                    <th>Aksi</th>
                </tr>
                <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td>
                            <?php echo $data['nama_barang']; ?>
                        </td>
                        <td>
                            <?php
                            $harga = $data['harga'];
                            $format_rupiah = number_format($harga, 0, ',', '.');
                            echo 'Rp ' . $format_rupiah;
                            ?>
                        </td>
                        <td>
                            <?php echo $data['stok']; ?>
                        </td>
                        <td>
                            <img src="./controller/uploads/<?php echo $data['alamat_img']; ?>" width="80px" alt="" name="alamat_img" />
                        </td>
                        <td>
                            <form action="controller/add.php" method="post">

                                <?php
                                if ($data['stok'] > 0) { ?>
                                    <!-- button modal -->
                                    <button type="button" class="btn-costom-keranjang text-light text-center" data-toggle="modal"
                                        data-target="#modalPesanan<?php echo $data['id_barang']; ?>">
                                        <i class="fa fa-shopping-cart"></i>
                                    </button>
                                <?php } else {
                                }
                                ?>


                                <!-- modal tambah keranjang -->
                                <div class="modal fade" id="modalPesanan<?php echo $data['id_barang']; ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title font-weight-bold">Buat keranjang</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body mx-3">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <img src="./controller/uploads/<?php echo $data['alamat_img']; ?>" alt=""
                                                            class="rounded" style="width: 150px; height: 150px;">
                                                        <div class="ml-3 my-auto ">
                                                            <h4>
                                                                <?php echo $data['nama_barang']; ?>
                                                            </h4>
                                                            <p>
                                                                <?php
                                                                $harga = $data['harga'];
                                                                $format_rupiah = number_format($harga, 0, ',', '.');
                                                                echo 'Rp ' . $format_rupiah;
                                                                ?>
                                                            </p>
                                                            <div class="form-outline">
                                                                jumlah
                                                                <input type="number" class="form-control" name="jumlah_pesanan"
                                                                    value="1" min="1" class="form-control"
                                                                    max="<?php $data['jumlah'] ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div style=" position: absolute; top: 21px; right: 6px;">
                                                        <label for="id">Umum</label>
                                                        <input type="checkbox" id="id" name="id_user"
                                                            value="<?php echo $_SESSION['id_user']; ?>"
                                                            style="width: 16px; height: 16px;">
                                                    </div>
                                                    <input type="hidden" name="role" value="<?php echo $_SESSION['role']; ?>">
                                                    <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">

                                                    <button name="addPesan" type="submit" class="btn btn-primary align-self-end">
                                                        Pesan
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
