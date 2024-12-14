<div class="container opacity-100">
  <div class="row d-flex align-items-center" style="height: 100vh;">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card border-0 shadow rounded-3 ">
        <div class="card-body p-4 p-sm-5">
          <h3 class="card-title text-center fw-light fs-3">Registrasi</h3>
          <form action="" method="POST">
            <div class="mb-3">
              <label for="level">Pilih Peran</label>
              <select class="form-control" id="level" name="level" onchange="toggleInput()" required>
                <option value="">Pilih Peran</option>
                <option value="masyarakat">Masyarakat</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="mb-3" id="nikDiv" style="display: none;">
              <label for="nik" class="form-label">NIK</label>
              <input type="number" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK Anda" autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="nama_lengkap">Nama Lengkap</label>
              <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan Nama Lengkap" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="password">Password</label>
                <div class="input-group">
                   <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password" required autocomplete="off">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                      👁️
                    </button>
                </div>
            </div>
            <div class="mb-3">
              <label for="telp">Telepon</label>
              <input type="number" class="form-control" name="telp" id="telp" placeholder="Masukkan Nomor Telepon" required autocomplete="off">
            </div>
            <div class="d-grid">
              <button type="submit" name="kirim" class="btn btn-success">DAFTAR</button>
            </div>
          </form>
          <div class="row mt-2">
            <div class="col-6">
              <a href="index.php" class="btn btn-danger btn-block">Kembali</a>
            </div>
            <div class="col-6">
              <a href="index.php?page=login" class="btn btn-primary btn-block">Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleInput() {
    const level = document.getElementById('level').value;
    document.getElementById('nikDiv').style.display = level === 'masyarakat' ? 'block' : 'none';
  }
</script>

<?php
include 'config/koneksi.php';

if (isset($_POST["kirim"])) {
    $level = htmlspecialchars($_POST["level"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars(md5($_POST["password"]));
    $telp = htmlspecialchars($_POST["telp"]);
    $nama = htmlspecialchars($_POST["nama_lengkap"]);

    if ($level == "masyarakat") {
        $nik = htmlspecialchars($_POST["nik"]);

        // Validasi NIK
        if (empty($nik) || strlen($nik) != 10) {
            echo "<script>
                    alert('NIK harus terdiri dari 10 digit!');
                    document.location.href='index.php?page=registrasi';
                  </script>";
            exit();
        }

        // Masukkan data ke tabel masyarakat
        $query = mysqli_query($conn, "INSERT INTO masyarakat (nik, nama, username, password, telp, level) 
                                      VALUES ('$nik', '$nama', '$username', '$password', '$telp', '$level')");
    } elseif ($level == "admin") {
        // Masukkan data ke tabel petugas
        $query = mysqli_query($conn, "INSERT INTO petugas (nama_petugas, username, password, telp, level) 
                                      VALUES ('$nama', '$username', '$password', '$telp', '$level')");
    } else {
        echo "<script>
                alert('Peran tidak valid!');
                document.location.href='index.php?page=registrasi';
              </script>";
        exit();
    }

    // Notifikasi keberhasilan atau kegagalan
    if ($query) {
        echo "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href='index.php?page=login';
              </script>";
    } else {
        echo "<script>
                alert('Data Gagal Ditambahkan');
                document.location.href='index.php?page=registrasi';
              </script>";
    }
}
?>

<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', () => {
    // Toggle tipe input antara 'password' dan 'text'
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Ubah ikon mata
    togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
  });
</script>
