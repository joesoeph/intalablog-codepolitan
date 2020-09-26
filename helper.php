<?php

/*
 * helper.php adalah baris kode untuk membuat fungsi-fungsi
 * Semua fungsi yang sering digunakan sebaiknya diletakkan disini
 */

/*
 * $base_url adalah URL dasar dari aplikasi kita
 */
$base_url = "http://localhost/codepolitan/intalablog/";

/*
 * Fungsi human_date digunakan untuk menampilkan tanggal 
 * Formatnya yang mudah dibaca oleh manusia
 * Parameter pertama adalah tanggal dari tabel nya
 * Parameter kedua adalah style nya. Contoh: full (26 September 2020), default/none (September, 2020)
 */
function human_date($d, $style = 'none'){
	$date = date('d', strtotime($d)); // Tanggal dalam format angka (1-31)
	$month = date('F', strtotime($d)); // Bulan dalam format tulisan (January - December)
	$year  = date('Y', strtotime($d)); // Tahun dalam format 4 angka (2020)

	if($style === 'full'){
		return $date . ' ' . $month . ' ' . $year;
	} else {
		return $month . ', ' . $year;
	}
}