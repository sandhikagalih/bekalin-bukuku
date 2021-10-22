<?php 

function koneksi() {
  $conn = mysqli_connect('localhost', 'root', 'root', 'db_pw') or die('koneksi DB gagal!');
  return $conn;
}

function query($query) {
  $conn = koneksi();
  $result = mysqli_query($conn, $query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}


function tambah($data) {
  $conn = koneksi();

  // sanitasi data
  $judul = mysqli_real_escape_string($conn, htmlspecialchars($data['judul']));
  $penulis = mysqli_real_escape_string($conn, htmlspecialchars($data['penulis']));
  $penerbit = mysqli_real_escape_string($conn, htmlspecialchars($data['penerbit']));
  $kategori = mysqli_real_escape_string($conn, htmlspecialchars($data['kategori']));
  $cover = mysqli_real_escape_string($conn, htmlspecialchars($data['cover']));

  // query
  $query = "INSERT INTO buku
              VALUES (null, '$judul', '$penulis', '$penerbit', '$kategori', '$cover')";

  mysqli_query($conn, $query) or die("Query Gagal! Error: " . mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

function hapus($id) {
  $conn = koneksi();

  mysqli_query($conn, "DELETE FROM buku WHERE id = $id") or die("Query Gagal! Error: " . mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

function ubah($data) {
  $conn = koneksi();

  // sanitasi data
  $id = $data['id'];
  $judul = mysqli_real_escape_string($conn, htmlspecialchars($data['judul']));
  $penulis = mysqli_real_escape_string($conn, htmlspecialchars($data['penulis']));
  $penerbit = mysqli_real_escape_string($conn, htmlspecialchars($data['penerbit']));
  $kategori = mysqli_real_escape_string($conn, htmlspecialchars($data['kategori']));
  $cover = mysqli_real_escape_string($conn, htmlspecialchars($data['cover']));

  // query
  $query = "UPDATE buku
              SET
            judul = '$judul',
            penulis = '$penulis',
            penerbit = '$penerbit',
            kategori = '$kategori',
            cover = '$cover'
              WHERE id = $id";

  mysqli_query($conn, $query) or die("Query Gagal! Error: " . mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

?>