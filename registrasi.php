<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Add your favicon here -->
  <link rel="icon" type="image/png" href="img/png/cashier-machine.png" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

  <link href="css/login-form-bs.min.css" rel="stylesheet">
</head>

<body>

  <style>
    .background-image {
      position: absolute;
      width: 100%;
      min-height: 100vh;
      background-size: cover;
      background-position: center;
      z-index: -1;
    }
  </style>
  <section class="vh-100 background-image" style="background-image: url('img/3d creative online shopping.jpg');">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-white mx-auto" style="border-radius: 1rem; background-color: rgba(0, 0, 0, 0.7);">
            <div class="card-body p-5 text-center">

              <form action="controller/add.php" class="" method="post">

                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                <?php
                if (isset($_GET['pesan'])) {
                  if ($_GET['pesan'] == "gagal") {
                    echo "<div class='text-red-50 mb-5'>Username and Password do not match!</div>";
                  }
                }
                ?>
                <div class="text-start mb-4">
                  <label class="text-white">Username</label>
                  <input type="text" class="form-control form-control-lg bg-white-50" name="username" />
                </div>

                <div class="text-start mb-4">
                  <label class="text-white">Password</label>
                  <input type="password" class="form-control form-control-lg bg-white-50" name="password" />
                </div>

                <div class="text-start mb-4">
                  <label class="text-white">Confirmasi Password</label>
                  <input type="password" class="form-control form-control-lg bg-white-50" name="ConfPassword" />
                </div>

                <div class="text-start mb-4">
                  <label class="text-white">Nomor Hp</label>
                  <input type="number" class="form-control form-control-lg bg-white-50" name="nomor_hp" />
                </div>

                <div class="text-start mb-4">
                  <label class="text-white">Alamat</label>
                  <input type="text" class="form-control form-control-lg bg-white-50" name="alamat" />
                </div>

                <p class="small"><a class="text-white-50" href="">Forgot password?</a></p>

                <button class="btn btn-outline-light btn-lg px-5" type="submit"
                  name="RegisterPelanggan">Registrasi</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End your project here-->

  <script type="text/javascript" src="js/mdb.min.js"></script>
  <script type="text/javascript"></script>

</body>

</html>