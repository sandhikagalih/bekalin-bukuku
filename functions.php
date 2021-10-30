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
  // $cover = mysqli_real_escape_string($conn, htmlspecialchars($data['cover']));

  // upload gambar
  $gambar = upload();
  if(!$gambar) {
    return false;
  }

  // query
  $query = "INSERT INTO buku
              VALUES (null, '$judul', '$penulis', '$penerbit', '$kategori', '$gambar')";

  mysqli_query($conn, $query) or die("Query Gagal! Error: " . mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

function hapus($id) {
  $conn = koneksi();

  // hapus gambar jika bukan default.jpg
  $buku = query("SELECT * FROM buku WHERE id = $id")[0];
  if($buku['cover'] !== 'default.jpeg') {
    unlink('img/' . $buku['cover']);
  }

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
  $gambarLama = mysqli_real_escape_string($conn, htmlspecialchars($data['gambarLama']));

  // Upload Gambar
  $gambar = upload();
  // kalo ga ada gambar baru yang diupload
  if(!$gambar || $gambar == 'default.jpeg') {
    $gambar = $gambarLama;
  } else {
    // hapus gambarLama
    if($gambarLama !== 'default.jpg') {
      unlink('img/' . $gambarLama);
    }  
  }

  // query
  $query = "UPDATE buku
              SET
            judul = '$judul',
            penulis = '$penulis',
            penerbit = '$penerbit',
            kategori = '$kategori',
            cover = '$gambar'
              WHERE id = $id";

  mysqli_query($conn, $query) or die("Query Gagal! Error: " . mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

function upload() {
  $namaFile = $_FILES['cover']['name'];
  $tipeFile = $_FILES['cover']['type'];
  $ukuranFile = $_FILES['cover']['size'];
  $ekstensiFile = pathinfo($namaFile, PATHINFO_EXTENSION);
  $error = $_FILES['cover']['error'];
  $tmpName = $_FILES['cover']['tmp_name'];

  // cek apakah tidak ada gambar yang diupload
  // beri gambar default
  if($error === 4) {
    return 'default.jpeg';
  }

  // cek apakah file yang diupload adalah gambar
  $tipeGambarValid = ['image/jpg', 'image/jpeg', 'image/png'];
  if(!in_array($tipeFile, $tipeGambarValid)) {
    echo "<script>
            alert('yang anda upload bukan gambar!');
            document.location.href = 'index.php';
         </script>";
    return false;
  }

  // cek ukuran file gambar
  // cek php.ini
  // MAX_UPLOADED_FILE
  if($ukuranFile > 1000000) {
    echo "<script>
            alert('ukuran gambar terlalu besar!');
            document.location.href = 'index.php';
         </script>";
    return false;
  }

  // lolos pengecekan, gambar siap diupload
  // generate nama gambar baru
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiFile;

  // upload gambar
  move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
  return $namaFileBaru;

}

?>