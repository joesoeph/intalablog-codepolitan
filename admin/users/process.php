<?php
/*
 * Panggil session start
 * session_start digunakan untuk memulai session pada halaman ini
 * Karena kita hendak menggunakan global variabel $_SESSION, maka wajib menggunakannya
 */
session_start();


/*
 * Include file connection.php dan helper.php
 */
include("../../connection.php"); 
include("../../helper.php"); 


/*
 * Halaman admin perlu login dulu untuk aksesnya
 * Disini harus di cek dulu apakah sudah ada login sessionnya atau belum?
 * Jika sudah, maka halaman dapat diakses
 * Jika belum, maka arahkan ke halaman index.php
 */
if(!$_SESSION){
	header("Location: ".$base_url.'index.php');
}

$table = 'users';


/*
 * Cek data yang di post dari halaman admin form about
 * Jika ada, maka simpan nilai tersebut kedalam variabel-variabel
 */
if($_POST){
	$username        = isset($_POST['username']) ? addslashes($_POST['username']) : '';
	$password        = isset($_POST['password']) ? addslashes($_POST['password']) : '';
	$retype_password = isset($_POST['retype_password']) ? addslashes($_POST['retype_password']) : '';
	$fullname        = isset($_POST['fullname']) ? addslashes($_POST['fullname']) : '';
	$address         = isset($_POST['address']) ? addslashes($_POST['address']) : '';
	$email           = isset($_POST['email']) ? addslashes($_POST['email']) : '';
	$phone           = isset($_POST['phone']) ? addslashes($_POST['phone']) : '';
	$linkedin_url    = isset($_POST['linkedin_url']) ? addslashes($_POST['linkedin_url']) : '';
	$facebook_url    = isset($_POST['facebook_url']) ? addslashes($_POST['facebook_url']) : '';
	$github_url      = isset($_POST['github_url']) ? addslashes($_POST['github_url']) : '';
	$about           = isset($_POST['about']) ? addslashes($_POST['about']) : '';
	$interest        = isset($_POST['interest']) ? addslashes($_POST['interest']) : '';
	
	$valid_extensions = array('png','jpg');
	$picture_name     = isset($_FILES['picture']['name']) ? addslashes($_FILES['picture']['name']) : '';
	$picture          = round(microtime(true)) . '.' . $picture_name;
	$x                = explode('.', $picture);
	$extension        = strtolower(end($x));
	$size             = isset($_FILES['picture']['size']) ? addslashes($_FILES['picture']['size']) : '';
	$file_tmp         = isset($_FILES['picture']['tmp_name']) ? addslashes($_FILES['picture']['tmp_name']) : '';	
}


/*
 * Cek apakah nilai GET kosong?
 * Jika tidak kosong maka jalankan kode selanjutnya
 */
if($_GET){
	$id   = isset($_GET['id']) ? $_GET['id'] : isset($_GET['id']);
	$type = $_GET['type'];

	/*
	 * Cek typenya untuk menentukan prosesnya
	 * change_password, type untuk merubah password
	 * edit, type untuk merubah data tentang admin
	 */
	if($type === 'change_password'){

		/*
		 * Cek password dengan re-type nya sudah sama atau belum
		 * Jika tidak sama, buat session untuk menyimpan pesan notifikasi
		 * Jika sama, lanjutkan ke proses ubah akses login
		 */
		if($password !== $retype_password){
			$_SESSION['notif_type'] = 'danger';
			$_SESSION['notif_message'] = 'Confirm password failed';
		} else {
			/*
			 * Buat dan jalankan perintah query untuk mengecek user yang mau diedit ada atau tidak
			*/
			$check = mysqli_query($connection, "SELECT * FROM users WHERE id = $id");
			$result_check = mysqli_fetch_all($check, MYSQLI_ASSOC);

			/*
			 * Check apakah data usernya ada?
			 * Jika ada, maka update sesuai data inputnya
			 * Jika tidak ada (tidak terdaftar), maka tampilkan pesan "user not found"
			 */
			if($result_check){
				$password = md5($password);
				$update = mysqli_query($connection, "
					UPDATE $table SET 
						username   = '$username',
						password   = '$password'
					WHERE id = $id
				");

				/*
				 * Notif untuk ditampilkan pada file admin/admin.php
				 */
				$_SESSION['notif_type'] = 'success';
				$_SESSION['notif_message'] = 'Password changed. You can check by re-login';
			} else {

				/*
				 * Notif untuk ditampilkan pada file admin/admin.php
				 */
				$_SESSION['notif_type'] = 'danger';
				$_SESSION['notif_message'] = 'User not found';
			}
		}


	/*
	 * Cek typenya untuk menentukan prosesnya
	 * change_password, type untuk merubah password
	 * edit, type untuk merubah data tentang admin
	 */
	} else if($type === 'edit') {

		/*
		 * Cek id user ada atau tidak
		 * Jika ada, jalankan proses update data sesuai id user nya
		 * Jika tidak ada, tampilkan pesan "ID Unknown"
		 */
		if($id){
			if($picture_name){
				if(in_array($extension, $valid_extensions) === true){
					if($size < 1044070){	
						$query_users = mysqli_query($connection, "SELECT * FROM users WHERE id = $id");
						$post = mysqli_fetch_all($query_users, MYSQLI_ASSOC);
						unlink('../../upload/'.$post[0]['picture']);
						move_uploaded_file($file_tmp, '../../upload/'.$picture);
						$update = mysqli_query($connection, "
							UPDATE $table SET 
								picture      = '$picture', 
								fullname     = '$fullname', 
								address      = '$address', 
								email        = '$email',
								phone        = '$phone',
								linkedin_url = '$linkedin_url',
								facebook_url = '$facebook_url',
								github_url   = '$github_url',
								about        = '$about',
								interest     = '$interest'
							WHERE id = $id
						");

						if($update){

							/*
							 * Notif untuk ditampilkan pada file admin/admin.php
							 */
							$_SESSION['notif_type'] = 'success';
							$_SESSION['notif_message'] = 'Update success';
						} else {

							/*
							 * Notif untuk ditampilkan pada file admin/admin.php
							 */
							$_SESSION['notif_type'] = 'danger';
							$_SESSION['notif_message'] = 'Update failed';
						}
					}else{

						/*
						 * Notif untuk ditampilkan pada file admin/admin.php
						 */
						$_SESSION['notif_type'] = 'danger';
						$_SESSION['notif_message'] = 'File size too big';
					}
				}else{

					/*
					 * Notif untuk ditampilkan pada file admin/admin.php
					 */
					$_SESSION['notif_type'] = 'danger';
					$_SESSION['notif_message'] = 'Please use valid extensions (png, jpg)';
				}
			} else {
				$update = mysqli_query($connection, "
					UPDATE $table SET 
						fullname     = '$fullname', 
						address      = '$address', 
						email        = '$email',
						phone        = '$phone',
						linkedin_url = '$linkedin_url',
						facebook_url = '$facebook_url',
						github_url   = '$github_url',
						about        = '$about',
						interest     = '$interest'
					WHERE id = $id
				");

				if($update){

					/*
					 * Notif untuk ditampilkan pada file admin/admin.php
					 */
					$_SESSION['notif_type'] = 'success';
					$_SESSION['notif_message'] = 'Update success';
				} else {

					/*
					 * Notif untuk ditampilkan pada file admin/admin.php
					 */
					$_SESSION['notif_type'] = 'danger';
					$_SESSION['notif_message'] = 'Update failed';
				}
			}

		} else {

			/*
			 * Notif untuk ditampilkan pada file admin/admin.php
			 */
			$_SESSION['notif_type'] = 'danger';
			$_SESSION['notif_message'] = 'ID unknown';
		}



	/*
	 * Cek typenya untuk menentukan prosesnya
	 * change_password, type untuk merubah password
	 * edit, type untuk merubah data tentang admin
	 * tampilkan pesan "Unknown process typer" untuk type yang tidak terdaftar
	 */
	} else {

		/*
		 * Notif untuk ditampilkan pada file admin/admin.php
		 */
		$_SESSION['notif_type'] = 'danger';
		$_SESSION['notif_message'] = 'Unknown process type';
	}

}


/*
 * Jika proses diatas telah selesai, redirect ke dashboard
 */
header("Location: ".$base_url.'admin/admin.php');

?>