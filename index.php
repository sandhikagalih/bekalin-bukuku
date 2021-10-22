<?php 
require 'functions.php';
$buku = query("SELECT * FROM buku");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />

    <title>Daftar Buku</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand" href="#">BukuKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Daftar Buku</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tambah.php">Tambah Buku</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-3">
      <div class="row">
        <div class="col">
          <h2>Daftar Buku</h2>
        </div>
      </div>
      <div class="row">

        <?php foreach($buku as $b) : ?>
          <div class="col-md-4 col-sm-6">
            <div class="card mb-3">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="img/<?= $b['cover']; ?>" class="img-fluid rounded-start" alt="<?= $b['judul']; ?>" />
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <span class="position-absolute top-0 end-0 bg-dark text-white py-1 px-2 opacity-75 text-capitalize"><small><?= $b['kategori']; ?></small></span>
                    <h5 class="card-title"><?= $b['judul']; ?></h5>
                    <p class="card-text text-muted m-0"><?= $b['penulis']; ?></p>
                    <p class="card-text"><small><?= $b['penerbit']; ?></small></p>
                    <a href="ubah.php?id=<?= $b['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus.php?id=<?= $b['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('yakin?');">Delete</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>  

      </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>
