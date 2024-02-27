<?php
include "./controller/koneksi.php";
$fatchDataPemesanan = mysqli_query($koneksi, "SELECT * from pesanan");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" type="text/css" href="./css/jquery/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"> -->
</head>

<body>

    <div class="mb-4 row flex-wrap justify-content-between">

        <div class="col-sm-4">
            <div class="card card-primary mb-3">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fa fa-search"></i> Cari Barang</h5>
                </div>
                <div class="card-body">
                    <input type="text" id="cari" class="form-control" name="cari" placeholder="Masukan : Nama Barang  [ENTER]">
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card card-primary mb-3">
                <div class="card-header bg-primary text-white">
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
            <h6 class="m-0 font-weight-bold text-warning">Table Pesanan</h6>
        </div>
        <div class="card-body">
            <hr class="border border-4 bg-secondary rounded" style="width: 100%; height: 2px;">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablePesanan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Foto Barang</th>
                            <th>Kasir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        while ($data = mysqli_fetch_array($fatchDataPemesanan)) {
                        ?>
                            <tr>
                                <td><?php $no++; ?></td>
                                <td><?php echo $data['nama_barang']; ?></td>
                                <td><?php echo $data['jumlah']; ?></td>
                                <td><?php
                                    $harga = $data['total_harga'];
                                    $format_rupiah = number_format($harga, 0, ',', '.');
                                    echo 'Rp ' . $format_rupiah; ?></td>
                                <td>
                                    <img src="./controller/uploads/<?php echo $data['foto_barang']; ?>" width="80px" alt="" />
                                </td>
                                <td>
                                    <?php echo $data['id_user']; ?>
                                </td>
                                <td class="d-flex">

                                    <button type="button" class="btn-costom-edit text-light text-center">
                                        <i class="fa fa-edit"></i>
                                    </button>


                                    <form action="controller/Controller.php" method="post">

                                        <!-- button modal -->
                                        <button type="button" class="btn-costom-delete text-light text-center" data-toggle="modal" data-target="#modalPesanan<?php echo $data['id_pesanan']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3 d-lg-none" viewBox="0 0 16 16">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                            <span class="ms-2 d-lg-inline d-sm-none">Delete</span>
                                        </button>

                                        <!-- modal delete user -->
                                        <div class="modal fade" id="modalDeleteUser<?php echo $data['id_pesanan']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title w-100 font-weight-bold">Hapus User</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body mx-3">

                                                        <h5 class="text-center">Yakin ingin HAPUS user id
                                                            <p>
                                                                <?php echo $data['id_pesanan']; ?>
                                                            </p>
                                                        </h5>

                                                        <div class="d-flex justify-content-between">
                                                            <button type="submit" class="btn btn-danger align-items-start " name="delete">
                                                                Hapus
                                                            </button>
                                                            <button type="button" class="btn btn-secondary align-items-end " data-dismiss="modal">
                                                                Batalkan
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
                        ?>
                    </tbody>
                </table>
            </div>

            <script src="./vendors/jquery/jquery.js"></script>
            <script src="./vendors/jquery/jquery.dataTables.min.js"></script>
            <script src="./vendors/datatables/dataTables.buttons.min.js"></script>
            <script src="./vendors/datatables/buttons.print.min.js"></script>
            <script src="./vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="./vendors/bootstrap/js/bootstrap.bundle.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#dataTablePesanan').DataTable({
                        dom: 'Blfrtip',
                        buttons: [{
                            extend: 'print',
                            text: 'Print',
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
                $(document).ready(function() {
                    $("#cari").change(function() {
                        $.ajax({
                            type: "POST",
                            url: "./controller/Controller.php?cari_barang=yes",
                            data: 'keyword=' + $(this).val(),
                            beforeSend: function() {
                                $("#hasil_cari").hide();
                                $("#tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
                            },
                            success: function(html) {
                                $("#tunggu").html('');
                                $("#hasil_cari").show();
                                $("#hasil_cari").html(html);
                            }
                        });
                    });
                });
                //To select country name
            </script>

</body>

</html>