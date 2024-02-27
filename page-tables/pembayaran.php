<?php
include "./controller/koneksi.php";
$fatchDataPembayaran = mysqli_query($koneksi, "SELECT pembayaran.*, users.username FROM pembayaran INNER JOIN users ON pembayaran.id_user = users.id_user");
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
            <h6 class="m-0 font-weight-bold text-warning">Table Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablePembayaran" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User Pelanggan</th>
                            <th>id Order</th>
                            <th>jumlah</th>
                            <th>harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        while ($data = mysqli_fetch_array($fatchDataPembayaran)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo ++$no; ?>
                                </td>
                                <td>
                                    <?php echo $data['username']; ?>
                                </td>
                                <td>
                                    <?php echo $data['id_item']; ?>
                                </td>
                                <td>
                                    <?php echo $data['jumlah']; ?>
                                </td>
                                <td>Rp.
                                    <?= number_format($data['harga'], 0, ',', '.'); ?>
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
            $('#dataTablePembayaran').DataTable({
                dom: 'Blfrtip', // "l" for length menu, "f" for filtering input, "r" for processing display element, "B" for buttons container
                buttons: [{
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2] // Exclude the "action" column (index 4)
                    }
                }],
                lengthMenu: [10, 25, 50, 100], // Set the length menu options
                pageLength: 10 // Set the default page length
            });
        });
    </script>
</body>

</html>