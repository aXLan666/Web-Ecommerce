<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        /* CSS untuk mencetak tabel dengan garis di sekitar setiap sel */
        @media print {
            table {
                border-collapse: collapse;
                width: 100%;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <!-- <div class="modal show d-block" id="ModalBuyer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 font-weight-bold text-center">Laporan Pembayaran</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-start">
                                        Alamat : <br>
                                        Telpon : <br>
                                        Tanggal :
                                    </th>
                                    <th class="text-end">
                                        Jl. Jalan <br>
                                        08123456789 <br>
                                        2022-01-01
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Barang 1</td>
                                    <td>Rp. 100.000</td>
                                    <td>2</td>
                                    <td>Rp. 200.000</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th>Rp. 200.000</th>
                                </tr>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3 mb-3">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                </div>
            </div>
        </div>
    </div> -->

    <div class="modal show d-block" id="ModalBuyer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 font-weight-bold text-center">Laporan Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="card">
                                <div class="card-body p-5 d-flex absolute">
                                    <input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" aria-label="..." style="position: absolute; top: 5px; left: 9px; width: 25px; height: 25px; font-size: 24px;">

                                    <img src="" alt="" class="img-fluid" style="width: 100px; height: 100px;">
                                    <div class="ms-3 w-100">
                                        <h4></h4>
                                        <p class="mb-0"></p>
                                        <input type="number" class="form-control" name="jumlah" style="width: 70px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <p class="fw-bold fs-7 mb-0">Total <br> Rp. </p>
                    <button type="button" class="btn btn-primary" id="saveButton">Beli</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables untuk tabel

            // Tambahkan data ke tabel header
            var headerData = [
                ["Alamat :", "Telpon :", "Tanggal :"],
                ["Jl. Jalan", "08123456789", "2022-01-01"]
            ];

            var tableHeader = $('#dataTableHeader').DataTable({
                paging: false,
                searching: false,
                ordering: false,
                info: false
            });

            for (var i = 0; i < headerData.length; i++) {
                tableHeader.row.add(headerData[i]).draw();
            }

            // Aksi ketika tombol "Save changes" ditekan
            $('#saveButton').click(function() {
                // Ambil konten modal
                var modalContent = $('#ModalBuyer .modal-content').html();

                // Buat jendela baru untuk mencetak
                var printWindow = window.open('', '_blank', 'height=600,width=800');

                // Tambahkan konten modal ke jendela baru
                printWindow.document.write('<html><head><title>Cetak Laporan Pembayaran</title>');
                printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
                printWindow.document.write('<style>@media print{table{border-collapse:collapse;width:100%}table,th,td{border:1px solid black}th,td{padding:8px;text-align:left}}</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<div class="container mt-3">');
                printWindow.document.write(modalContent);
                printWindow.document.write('</div></body></html>');

                // Panggil fungsi print
                printWindow.document.close();
                printWindow.print();
            });
        });
    </script>

</body>

</html>