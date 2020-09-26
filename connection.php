<?php
$db_host = "localhost"; // Hostnya. Defaultnya localhost
$db_user = "root"; // Username databasenya
$db_pass = ""; // Password databasenya. Untuk xampp biasanya defaultnya kosong
$db_name = "intalablog_db"; // Nama databasenya

/*
 * Tampung connection ke dalam variabel $connection
 */
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

/*
 * Melakukan pengecekan apakah koneksi ke database gagal?
 * Jika gagal tampilkan pesan "Failed connect to database"
 * Jika berhasil konek, tidak menampilkan pesan error
 */
if(mysqli_connect_errno()){
	echo 'Failed connect to database : '.mysqli_connect_error();
}
?>