<?php 
/*
 * Panggil session start
 * session_start digunakan untuk memulai session pada halaman ini
 * Karena kita hendak menggunakan global variabel $_SESSION, maka wajib menggunakannya
 */
session_start();

/*
 * Cek sudah ada session belum.
 * Jika sudah jangan tampilkan halaman login, pengguna akan di paksa ke halaman admin
 */
if($_SESSION){
	header("Location: ".$base_url.'admin/admin.php');
}


/*
 * Include file connection.php dan helper.php
 */
include("connection.php"); 
include("helper.php"); 

/*
 * Proses login pada halaman login.php terjadi pada satu file yang sama (login.php)
 * Cek data yang di post dari halaman login
 * Jika ada, maka jalankan tahapan login
 */
if($_POST){

	/*
	 * Tampung semua data post ke dalam variabel
	 */
	$username = addslashes($_POST['username']);
	$password = addslashes($_POST['password']);

	/*
	 * Cek apakah yang mau login sudah masukkan username & passwordnya
	 * Jika ya, maka jalankan perintah pengecekan ke table user
	 * Jika tidak, maka tampilkan pesan tertentu
	 */
	if($username && $password){

		/*
		 * Karena semua password yang disimpan itu dalam md5, maka ceknya harus di md5 dulu
		 */
		$password = md5($password);
		$query_users = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
		$result_users = mysqli_fetch_all($query_users, MYSQLI_ASSOC);

		/*
		 * Cek apakah user ada atau tidak
		 * Jika tidak, maka tampilkan pesan tertentu
		 * Jika ada, simpan informasi user ke global $_SESSION
		 */
		if(!$result_users){
			$notif['type'] = 'danger';
			$notif['message'] = 'Username or password incorect';
		} else {
			$_SESSION['user_id']  = $result_users[0]['id'];
			$_SESSION['username'] = $result_users[0]['username'];
			$_SESSION['fullname'] = $result_users[0]['fullname'];
			$_SESSION['email']    = $result_users[0]['email'];

			/*
			 * Kalau sudah disimpan ke $_SESSION lalu redirect ke dashboard
			 */
			header("Location: ".$base_url.'admin/admin.php');
		}

		// Set Session
	} else {
		$notif['type'] = 'danger';
		$notif['message'] = 'Username or password incorect';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login Admin</title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="p-0">
        <!-- Page Content-->
        <div class="container-fluid mt-4">


        	<?php 
        	/*
			 * Tampilkan notifikasi kalau variabel $notif telah di set
        	 */
        	if(isset($notif)) { ?>
        	<div class="alert alert-<?=$notif['type']?>" role="alert">
				<?=$notif['message']?>
			</div>
			<?php } ?>

			
        	<div class="col-md-4 offset-md-4 shadow-sm p-4 mb-5 bg-white rounded">
                <h1 class="mb-0">
                    Admin
                    <span class="text-primary">Login</span>
                </h1>
        		<form action="<?=$base_url . 'login.php'?>" method="POST">
				    <div class="form-group">
				        <label for="username">Username</label>
				        <input type="text" name="username" class="form-control" id="username" aria-describedby="username">
				    </div>
				    <div class="form-group">
				        <label for="password">Password</label>
				        <input type="password" name="password" class="form-control" id="password">
				    </div>
				    <button type="submit" class="btn btn-primary">Log In</button>
				</form>
			</div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
