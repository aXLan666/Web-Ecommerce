<?php
include "./controller/koneksi.php";
$fatchDataUser = mysqli_query($koneksi, "select * from users");
$dataAdmin = mysqli_num_rows(mysqli_query($koneksi, "select * from users where role = 'Admin'"));
$dataPelanggan = mysqli_num_rows(mysqli_query($koneksi, "select * from users where role = 'Pelanggan'"));
$dataKasir = mysqli_num_rows(mysqli_query($koneksi, "select * from users where role = 'Kasir'"));
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

            <div class="row">
                <div class="col col-md-4 col-sm-12 col-xs-12 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">Jumlah Pelanggan : <?= $dataPelanggan; ?></div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-12 col-xs-12 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">Jumlah Kasir : <?= $dataKasir; ?></div>
                    </div>
                </div>
                <div class="col col-md-4 col-sm-12 col-xs-12 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">Jumlah Admin : <?= $dataAdmin; ?></div>
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <!-- Button trigger modal -->
                <button type="button" class="btn-costom" data-toggle="modal" data-target="#ModalTambahUser" style="background-color: #4e73df; border-color: #4e73df;">
                    Tambah User
                </button>

                <!-- Modal -->
                <div class="modal fade" id="ModalTambahUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content text-black">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">
                                    Tambah User
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="./controller/add.php" method="post">

                                    <div class="form-outline mb-3">
                                        <label for="username" class="form-label">UserName</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>

                                    <div class="form-outline mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <div class="form-outline mb-3">
                                        <label for="role" class="form-label">Pilih Role:</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="Admin">Admin</option>
                                            <option value="Pelanggan">Pelanggan</option>
                                            <option value="Kasir">Kasir</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="TambahUser">Tambah barang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border border-4 bg-secondary rounded" style="width: 100%; height: 2px;">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableUsers" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id User</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th data-orderable="false">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = mysqli_fetch_array($fatchDataUser)) {
                        ?>
                            <tr>
                                <td> <?php echo $data["id_user"]; ?></td>
                                <td> <?php echo $data['username']; ?></td>
                                <td><?php echo $data['password']; ?></td>
                                <td> <?php echo $data['role']; ?></td>
                                <td class="d-flex">

                                    <!-- modal delete user -->
                                    <?php
                                    if ($data['id_user'] == $_SESSION['id_user']) {
                                    } else { ?>
                                        <form action="controller/delete.php" method="post">

                                            <!-- button modal -->
                                            <button value="<?php echo $data['id_user']; ?>" type="button" class="btn-costom text-light text-center" data-toggle="modal" data-target="#modalDeleteUser<?php echo $data['id_user']; ?>" style="background-color: red; border-color: red;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                </svg>
                                            </button>

                                            <!-- modal delete user -->
                                            <div class="modal fade" id="modalDeleteUser<?php echo $data['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                                    <?php echo $data['id_user']; ?>
                                                                </p>
                                                            </h5>

                                                            <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">

                                                            <div class="d-flex justify-content-between">
                                                                <button type="submit" class="btn btn-danger align-items-start" name="deleteUser">
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
                                    <?php } ?>

                                    <!-- modal update user -->
                                    <form id="updateForm" action="controller/update.php" method="post">

                                        <!-- button modal -->
                                        <button value="<?php echo $data['id_user']; ?>" type="button" class="btn-costom text-white" data-toggle="modal" data-target="#modalEditUser<?php echo $data['id_user']; ?>" style="background-color: #0D6EFD; border-color: #0D6EFD">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>

                                        <!-- modal update user -->
                                        <div class="modal fade" id="modalEditUser<?php echo $data['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title w-100 font-weight-bold">Edit User</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body mx-3">

                                                        <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">

                                                        <h5 class="text-center bold">Edit user id <?php echo $data['id_user']; ?> </h5>

                                                        <div class="form-outline mb-3">
                                                            <label for="username" class="form-label">Nama barang:</label>
                                                            <input type="text" class="form-control" id="username" name="username" required value="<?php echo $data['username']; ?>">
                                                        </div>

                                                        <div class="form-outline mb-3">
                                                            <label for="password" class="form-label">Password:</label>
                                                            <input type="password" class="form-control" id="password" name="password" required value="<?php echo $data['password']; ?>">
                                                        </div>

                                                        <div class="form-outline mb-3">
                                                            <label for="role" class="form-label">Pilih Role:</label>
                                                            <select class="form-select" id="role" name="role" required>
                                                                <option value="Admin" <?php echo ($data['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                                                <option value="Pelanggan" <?php echo ($data['role'] == 'Pelanggan') ? 'selected' : ''; ?>>Pelanggan</option>
                                                            </select>
                                                        </div>

                                                        <div class="d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-deep-orange btn-primary" name="updateUser">
                                                                Edit User
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
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTableUsers').DataTable({
                dom: 'Blfrtip', // "l" for length menu, "f" for filtering input, "r" for processing display element, "B" for buttons container
                buttons: [{
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2, 3] // Exclude the "action" column (index 4)
                    }
                }],
                "order": [], // Disable initial sorting
                "columnDefs": [{
                        "searchable": false,
                        "targets": [4]
                    } // Disable search for the Action column
                ],
                lengthMenu: [10, 25, 50, 100], // Set the length menu options
                pageLength: 10 // Set the default page length
            });
        });
    </script>
</body>


</html>