<?php
include "./controller/koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Table barang</h6>
        </div>
        <div class="card-body">

            <div class="d-flex justify-content-between">

                <!-- Button trigger modal -->
                <button type="button" class="btn-costom" data-toggle="modal" data-target="#ModalTambahBarang"
                    style="background-color: #4e73df; border-color: #4e73df">
                    Tambah Stok
                </button>

                <!-- Modal -->
                <div class="modal fade" id="ModalTambahBarang" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content text-black">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">
                                    Tambah barang
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="./controller/add.php" method="post" enctype="multipart/form-data"
                                    onsubmit="return validateQuantity()">

                                    <div class="form-outline mb-3">
                                        <label for="role" class="form-label">Pilih Barang:</label>
                                        <select class="form-select" id="role" name="id_barang" required>
                                            <?php
                                            $sqlB = mysqli_query($koneksi, "SELECT stok_masuk.jumlah, barang.nama_barang, barang.id_barang FROM stok_masuk INNER JOIN barang ON stok_masuk.id_barang = barang.id_barang");
                                            ;
                                            while ($data1 = mysqli_fetch_array($sqlB)) {
                                                ?>
                                                <option value="<?php echo $data1['id_barang']; ?>">
                                                    <?php echo $data1['nama_barang']; ?> (Stok :
                                                    <?php echo $data1['jumlah']; ?>)
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div class="form-outline mb-3">
                                        <label for="stok" class="form-label">Jumlah di Stok:</label>
                                        <input type="number" class="form-control" id="stok" min="1" name="stok"
                                            required>
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="addStok">Tambah barang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border border-4 bg-secondary rounded" style="width: 100%; height: 2px;">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableProduk" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>no</td>
                            <th>Nama barang</th>
                            <th>Stok</th>
                            <th>Tanggal Masuk</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $fatchDataProduk = mysqli_query($koneksi, "SELECT stok_masuk.*, barang.nama_barang from stok_masuk INNER JOIN barang ON stok_masuk.id_barang = barang.id_barang");
                        while ($data = mysqli_fetch_array($fatchDataProduk)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $no++; ?>
                                </td>
                                <td>
                                    <?php echo $data['nama_barang']; ?>
                                </td>
                                <td>
                                    <?php echo $data['jumlah']; ?>
                                </td>
                                <td>
                                    <?php echo $data['tanggal_masuk']; ?>
                                </td>
                                <td class="d-flex">

                                    <!-- modal delete user -->
                                    <form id="deleteForm" action="./controller/delete.php" method="post">

                                        <!-- button modal -->
                                        <button value="<?php echo $data['id_barang']; ?>" type="button"
                                            class="btn-costom text-light text-center" data-toggle="modal"
                                            data-target="#modalDeleteBarang<?php echo $data['id_barang']; ?>"
                                            style="background-color: red; border-color: red;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                            </svg>
                                        </button>

                                        <!-- modal delete user -->
                                        <div class="modal fade" id="modalDeleteBarang<?php echo $data['id_barang']; ?>"
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

                                                        <h5 class="text-center">Yakin ingin HAPUS data stok masuk
                                                            <p>
                                                                <?php echo $data['id_barang']; ?>
                                                            </p>
                                                        </h5>

                                                        <input type="hidden" name="id_barang"
                                                            value="<?php echo $data['id_barang']; ?>">
                                                        <input type="hidden" name="id_masuk"
                                                            value="<?php echo $data['id_masuk']; ?>">

                                                        <div class="d-flex justify-content-between">
                                                            <button type="submit" class="btn btn-danger align-items-start "
                                                                name="deleteProduk">
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

                                    <!-- modal update user -->
                                    <form id="updateForm" action="./controller/update.php" method="post"
                                        enctype="multipart/form-data">

                                        <!-- button modal -->
                                        <button value="<?php echo $data['id_barang']; ?>" type="button"
                                            class="btn-costom text-white" data-toggle="modal"
                                            data-target="#modalEditProduk<?php echo $data['id_barang']; ?>"
                                            style="background-color: #0D6EFD; border-color: #0D6EFD">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>

                                        <!-- modal update user -->
                                        <div class="modal fade" id="modalEditProduk<?php echo $data['id_barang']; ?>"
                                            tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title w-100 font-weight-bold">Edit User</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body mx-3">

                                                        <h5 class="text-center bold">Edit user id
                                                            <?php echo $data['id_barang']; ?>
                                                        </h5>

                                                        <input type="hidden" name="id_barang"
                                                            value="<?php echo $data['id_barang'] ?>">

                                                        <div class="form-outline mb-3">
                                                            <label for="nama_barang" class="form-label">Nama barang:</label>
                                                            <input type="text" class="form-control" id="nama_barang"
                                                                name="nama_barang" required
                                                                value="<?php echo $data['nama_barang']; ?>">
                                                        </div>

                                                        <div class="form-outline mb-3">
                                                            <label for="harga" class="form-label">Harga:</label>
                                                            <input type="number" class="form-control" id="harga"
                                                                name="harga" required value="<?php echo $data['harga']; ?>">
                                                        </div>

                                                        <label for="alamat_img" class="form-label">Alamat Gambar:</label>
                                                        <div class="form-img-costom form-outline mb-3">
                                                            <input type="file" class="upload-img" name="form-img">
                                                        </div>

                                                        <div class="d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-deep-orange btn-primary"
                                                                name="editProduk">
                                                                Edit barang
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </td>
                            </tr>
                            <?php
                        }
                        // Close the database connection
                        $koneksi->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#dataTableProduk').DataTable({
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'print',
                    text: 'Print',
                }],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 25,
            });
        });
    </script>


    <script>
        function validateQuantity() {
            var quantity = document.getElementById("stok").value;
            if (quantity < 0) {
                alert("Quantity in stock cannot be negative. Please enter a valid quantity.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</body>

</html>