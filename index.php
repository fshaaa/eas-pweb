<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['nama'])) {
    header("Location: dashboard.php");
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($db, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        if ($row['role'] == "admin") {
            header("Location: admin.php");
        } else
            header("Location: index.php");
    } else {
        echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}

if (isset($_POST['register'])) {
  $nama = $_POST['nama_su'];
  $nik = $_POST['nik_su'];
  $email = $_POST['email_su'];
  $password = md5($_POST['password_su']);
  $cpassword = md5($_POST['cpassword_su']);

  if ($password == $cpassword) {
      $sql = "SELECT * FROM user WHERE email='$email'";
      $result = mysqli_query($db, $sql);
      $num = mysqli_num_rows($result);
      echo "$nama, $nik, $email, $password, $cpassword, $num";
      if ($num == 0) {
          $sql = "INSERT INTO users (`nik`, `nama`, `email`, `role`, `password`) VALUES ('$nik','$nama','$email','user','$password')";
          $result = mysqli_query($db, $sql);
          if ($result) {
              echo "<script>alert('Selamat, registrasi berhasil!')</script>";
              $nama = "";
              $email = "";
              $_POST['password_su'] = "";
              $_POST['cpassword_su'] = "";
              header('Location: index.php?status:berhasil');
          } else {
              echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
          }
      } else {
          echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
      }
  } else {
      echo "<script>alert('Password Tidak Sesuai')</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pendaftaran Peserta KKP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="./style.css">

</head>
<body class="body">
<!-- partial:index.partial.html -->
<div class="container right-panel-active">
	<!-- Sign Up -->
	<div class="container__form container--signup">
		<form action="" method="post" class="form" id="form1">
			<h2 class="form__title">Sign Up</h2>
			<input type="text" id="nama_su" name="nama_su" placeholder="Nama" class="input" value="<?php echo $nama; ?>" required />
			<input type="nik" id="nik_su" name="nik_su" placeholder="NIK" class="input" value="<?php echo $nik; ?>" required/>
			<input type="email" id="email_su" name="email_su" placeholder="Email" class="input" value="<?php echo $email; ?>" required/>
			<input type="password" id="password_su" name="password_su" placeholder="Password" class="input" value="<?php echo $_POST['password']; ?>" required/>
			<input type="password" id="cpassword_su" name="cpassword_su" placeholder="Confirmation Password" class="input" value="<?php echo $_POST['$cpassword']; ?>" required/>
			<button class="btn" type="submit" name="register" id="submit">Sign Up</button>
		</form>
	</div>

	<!-- Sign In -->
	<div class="container__form container--signin">
		<form action="" method="POST" class="form" id="form2">
			<h2 class="form__title sign_in">Sign In</h2>
			<input type="email" id="email" name="email" placeholder="email@gmail.com" value="<?php echo $email; ?>" required class="input"/>
			<input type="password" id="password" name="password" placeholder="Password"  value="<?php echo $_POST['password']; ?>" required class="input" />
			<a href="#" class="link">Forgot your password?</a>
			<button class="btn" type="submit" name="login" id="submit">Sign In</button>
		</form>
	</div>

	<!-- Overlay -->
	<div class="container__overlay">
		<div class="overlay">
			<div class="overlay__panel overlay--left">
				<button class="btn" id="signIn">Sign In</button>
			</div>
			<div class="overlay__panel overlay--right">
				<button class="btn" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>