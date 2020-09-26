<?php
/*
 * File logout.php adalah file yang digunakan untuk menghancurkan session
 * Informasi yang tersimpan dari $_SESSION perlu dihapus disini
 */
session_start();
session_destroy();

/*
 * Ketika sudah dihapus/dihancurkan sessionnya, redirect saja ke halaman index.php
 */
header("Location: index.php");
?>