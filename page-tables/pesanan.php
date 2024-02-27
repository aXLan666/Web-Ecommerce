<?php
include "./controller/koneksi.php";
$fatchDataPemesanan = mysqli_query(
    $koneksi,
    "SELECT pesanan.*, users.*, barang.* FROM pesanan INNER JOIN users ON pesanan.id_user = users.id_user INNER JOIN barang ON pesanan.id_barang = barang.id_barang"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="mb-4 row flex-wrap justify-content-between">
        <div class="col-sm-4">
            <div class="card mb-3">
                <div class="card-header text-warning">
                    <h5><i class="fa fa-search"></i> Cari Barang</h5>
                </div>
                <div class="card-body">
                    <input type="text" id="cari" class="form-control" name="cari"
                        placeholder="Masukan : Nama Barang  [ENTER]">
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card mb-3">
                <div class="card-header text-warning">
                    <h5><i class="fa fa-list"></i> Hasil Pencarian</h5>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <div id="hasil_cari"></div>
                        <div id="tunggu"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Table pesanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablePesanan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Sub Total</th>
                            <th>Foto Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        while ($data = mysqli_fetch_array($fatchDataPemesanan)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo ++$no; ?>
                                </td>
                                <td>
                                    <?php echo $data['username']; ?>
                                </td>
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
                                    <?php echo $data['jumlah']; ?>
                                </td>
                                <td>
                                    <?php
                                    $harga = $data['sub_total'];
                                    $format_rupiah = number_format($harga, 0, ',', '.');
                                    echo 'Rp ' . $format_rupiah;
                                    ?>
                                </td>
                                <td>
                                    <img src="./controller/uploads/<?php echo $data['alamat_img']; ?>" alt=""
                                        style="width: 80px; height: 80px;">
                                </td>
                                <td class="d-flex">

                                    <!-- button modal update jumlah -->

                                    <form action="./controller/delete.php" method="post">
                                        <input type="hidden" name="id_pesanan" value="<?php echo $data['id_pesanan']; ?>">
                                        <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">
                                        <input type="hidden" name="jumlah" value="<?php echo $data['jumlah']; ?>">

                                        <!-- button modal -->
                                        <button type="button" class="btn-costom text-light text-center" data-toggle="modal"
                                            data-target="#modalHapusPesanan<?php echo $data['id_pesanan']; ?>"
                                            style="background-color: red; border-color: red;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                        </button>

                                        <!-- modal delete user -->
                                        <div class="modal fade" id="modalHapusPesanan<?php echo $data['id_pesanan']; ?>"
                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title w-100 font-weight-bold">Hapus User</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body mx-3">

                                                        <h5 class="text-center">Yakin ingin HAPUS user id
                                                            <?php echo $data['id_pesanan']; ?>
                                                        </h5>

                                                        <div class="d-flex justify-content-between">
                                                            <button type="submit" class="btn btn-danger align-items-start "
                                                                name="deletePesanan">
                                                                Hapus
                                                            </button>
                                                            <button type="button" class="btn btn-secondary align-items-end "
                                                                data-dismiss="modal">
                                                                Batalkan
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                    <form action="./controller/update.php" method="post">
                                        <input type="hidden" name="id_pesanan" value="<?= $data['id_pesanan']; ?>">
                                        <input type="hidden" name="id_brg" value="<?= $data['id_barang']; ?>">
                                        <button type="button" class="btn-costom text-light text-center" data-toggle="modal"
                                            data-target="#modalUpdatePesanan<?php echo $data['id_pesanan']; ?>"
                                            style="background-color: #4e73df; border-color: #4e73df">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>

                                        <div class="modal fade" id="modalUpdatePesanan<?php echo $data['id_pesanan']; ?>"
                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title w-100 font-weight-bold">Ubah Jumlah Pesanan
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body mx-3">
                                                        <div class="form-group mb-3">
                                                            <label for="stok">Jumlah Pesanan</label>
                                                            <input type="number" class="form-control" name="jumlah"
                                                                value="<?= $data['jumlah'] ?>" style="width: 70px;"
                                                                max="<?= $data['stok'] ?>" id="stok">
                                                        </div>

                                                        <button type="submit" class="btn btn-danger align-items-start"
                                                            name="editJumlah">
                                                            Ubah
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#dataTablePesanan').DataTable({
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        stripHtml: false,
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
            });
        });

        function validateQuantity() {
            var quantity = document.getElementById("stok").value;
            if (quantity < 0) {
                alert("Quantity in stock cannot be negative. Please enter a valid quantity.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        // AJAX call for autocomplete 
        $(document).ready(function () {
            $("#cari").change(function () {
                $.ajax({
                    type: "POST",
                    url: "./controller/Controller.php?cari_barang=yes",
                    data: 'keyword=' + $(this).val(),
                    beforeSend: function () {
                        $("#hasil_cari").hide();
                        $("#tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
                    },
                    success: function (html) {
                        $("#tunggu").html('');
                        $("#hasil_cari").show();
                        $("#hasil_cari").html(html);
                    }
                });
            });
        });
    </script>

</body>

</html>