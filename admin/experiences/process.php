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

$table = 'experiences';



/*
 * Cek data yang di post dari halaman admin form about
 * Jika ada, maka simpan nilai tersebut kedalam variabel-variabel
 */
if($_POST){
	$name        = addslashes($_POST['name']);
	$place       = addslashes($_POST['place']);
	$date_start  = addslashes($_POST['date_start']);
	$date_end    = addslashes($_POST['date_end']);
	$description = addslashes($_POST['description']);
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

	/*
	 * Jika type adalah edit
	 * Jalankan perintah update data pada tabel
	 */
	} else if($type === 'edit') {

		/*
		 * Cek id experiences ada atau tidak
		 * Jika ada, jalankan proses update data sesuai id experiences nya
		 * Jika tidak ada, tampilkan pesan "ID Unknown"
		 */
		if($id){
			$update = mysqli_query($connection, "
				UPDATE $table SET 
					name        = '$name', 
					place       = '$place', 
					date_start  = '$date_start', 
					date_end    = '$date_end', 
					description = '$description' 
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

		} else {

			/*
			 * Notif untuk ditampilkan pada file admin/admin.php
			 */
			$_SESSION['notif_type'] = 'warning';
			$_SESSION['notif_message'] = 'ID unknown';
		}

	/*
	 * Jika type bukan delete/edit
	 * Jalankan perintah insert data pada tabel
	 */
	} else {
		$insert = mysqli_query($connection, "INSERT INTO $table 
			(
				name,
				place,
				date_start,
				date_end,
				description
			) 
			VALUES 
			(
				'$name',
				'$place',
				'$date_start',
				'$date_end',
				'$description'
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


/*
 * Jika proses diatas telah selesai, redirect ke dashboard
 */
header("Location: ".$base_url.'admin/admin.php');

?>