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

$table = 'posts';



/*
 * Cek data yang di post dari halaman admin form about
 * Jika ada, maka simpan nilai tersebut kedalam variabel-variabel
 */
if($_POST){
	$title        = addslashes($_POST['title']);
	$content      = addslashes($_POST['content']);
	$user_id      = $_SESSION['user_id'];
	$published_at = date('Y-m-d');
	
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
	 * Jika type adalah delete
	 * Jalankan perintah delete data pada tabel
	 */
	if($type === 'delete'){

		$query_posts = mysqli_query($connection, "SELECT * FROM posts WHERE id = $id");
		$post = mysqli_fetch_all($query_posts, MYSQLI_ASSOC);

		/* Hapus gambar di folder upload sesuai dengan nama yang tersimpan dalam tabel */
		unlink('../../upload/'.$post[0]['picture']);

		$delete = mysqli_query($connection, "DELETE FROM $table WHERE id = $id");

		if($delete){

			/*
			 * Notif untuk ditampilkan pada file admin/admin.php
			 */
			$_SESSION['notif_type'] = 'success';
			$_SESSION['notif_message'] = 'Delete success';
		} else {

			/*
			 * Notif untuk ditampilkan pada file admin/admin.php
			 */
			$_SESSION['notif_type'] = 'danger';
			$_SESSION['notif_message'] = 'Delete failed';
		}
	} else if($type === 'edit') {

		/*
		 * Cek id posts ada atau tidak
		 * Jika ada, jalankan proses update data sesuai id posts nya
		 * Jika tidak ada, tampilkan pesan "ID Unknown"
		 */
		if($id){

			/*
			 * Jika ada gambar yang mau diupload, update data dengan gambar
			 */
			if($picture_name){
				if(in_array($extension, $valid_extensions) === true){
					if($size < 1044070){	
						$query_posts = mysqli_query($connection, "SELECT * FROM posts WHERE id = $id");
						$post = mysqli_fetch_all($query_posts, MYSQLI_ASSOC);
						unlink('../../upload/'.$post[0]['picture']);
						move_uploaded_file($file_tmp, '../../upload/'.$picture);
						$update = mysqli_query($connection, "
							UPDATE $table SET 
								title   = '$title', 
								picture = '$picture', 
								content = '$content',
								user_id = '$user_id'
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


			/*
			 * Jika tidak ada gambar yang diupload, update data tanpa gambar
			 */
			} else {
				$update = mysqli_query($connection, "
					UPDATE $table SET 
						title   = '$title', 
						content = '$content',
						user_id = '$user_id'
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
	} else { // Handle Create
		if($picture_name){
			if(in_array($extension, $valid_extensions) === true){
				if($size < 1044070){			
					move_uploaded_file($file_tmp, '../../upload/'.$picture);
					$insert = mysqli_query($connection, "INSERT INTO $table 
						(
							title,
							picture,
							content,
							user_id,
							published_at
						) 
						VALUES 
						(
							'$title',
							'$picture',
							'$content',
							'$user_id',
							'$published_at'
						)
					");

					if($insert){

						/*
						 * Notif untuk ditampilkan pada file admin/admin.php
						 */
						$_SESSION['notif_type'] = 'success';
						$_SESSION['notif_message'] = 'Create success';
					} else {

						/*
						 * Notif untuk ditampilkan pada file admin/admin.php
						 */
						$_SESSION['notif_type'] = 'danger';
						$_SESSION['notif_message'] = 'Create failed';
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
			$insert = mysqli_query($connection, "INSERT INTO $table 
				(
					title,
					content,
					user_id,
					published_at
				) 
				VALUES 
				(
					'$title',
					'$content',
					'$user_id',
					'$published_at'
				)
			");

			if($insert){

				/*
				 * Notif untuk ditampilkan pada file admin/admin.php
				 */
				$_SESSION['notif_type'] = 'success';
				$_SESSION['notif_message'] = 'Create success';
			} else {

				/*
				 * Notif untuk ditampilkan pada file admin/admin.php
				 */
				$_SESSION['notif_type'] = 'danger';
				$_SESSION['notif_message'] = 'Create failed';
			}
		}

	}

}


/*
 * Jika proses diatas telah selesai, redirect ke dashboard
 */
header("Location: ".$base_url.'admin/admin.php');

?>