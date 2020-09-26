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
 * Cek apakah nilai id kosong?
 * Jika tidak kosong maka jalankan kode selanjutnya
 */
if( !empty($_GET['id']) ){
	$id = $_GET['id'];

	/*
	 * Buat variabel $action untuk menampung action formnya
	 * Ini adalah untuk menampung action edit-nya
	 */
	$action = $base_url.'admin/posts/process.php?type=edit&id='.$id;

	/*
	 * Buat dan jalankan perintah query untuk mendapatkan data dari table posts
	 * Data ini digunakan untuk menampilkannya pada form saat memilih data yang mau diedit
	 */
	$query_posts = mysqli_query($connection, "SELECT * FROM posts WHERE id = $id");
	$result = mysqli_fetch_all($query_posts, MYSQLI_ASSOC);

} else {

	/*
	 * Buat variabel $action untuk menampung action formnya
	 * Ini adalah untuk menampung action create-nya
	 */
	$action = $base_url.'admin/posts/process.php?type=create';
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin Resume</title>
        <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../../css/styles.css" rel="stylesheet" />
    </head>
    <body class="p-0">
        <!-- Page Content-->
        <div class="container mt-4">
        	<div class="col-md-12 shadow-sm p-4 mb-5 bg-white rounded">
  				<h2>Post Form</h2>
				<p>You can customize information here.</p>

				<div class="col-12">
					<!-- Gunakan  enctype="multipart/form-data" untuk mengupload data ke server -->
	        		<form action="<?=$action?>" method="POST" enctype="multipart/form-data">
					    <div class="form-group">
					        <label for="exampleTitle">Title</label>
					        <input type="text" name="title" class="form-control" id="exampleTitle" value="<?=isset($result) ? $result[0]['title'] : ''?>">
					    </div>
					    <div class="form-group">
					    	<?php 
					    	$picture = isset($result) ? $result[0]['picture'] : '';
					    	$img_src = $base_url.'upload/'.$picture;
					    	if($picture) { ?>
					    	<p>
					    		<a href="<?=$img_src?>" target="_blank"><img src="<?=$img_src?>" alt="<?=$picture?>" height="120px"></a>
					    	</p>
					    	<?php } ?>
					        <label for="picture">Picture</label>
					        <input type="file" name="picture" class="form-control" id="picture">
					    </div>
					    <div class="form-group">
					        <label for="content">Content</label>
					        <textarea name="content" class="form-control" id="content" rows="3"><?=isset($result) ? $result[0]['content'] : ''?></textarea>
					    </div>
					    <button type="submit" class="btn btn-primary">Save</button>
					</form>
				</div>

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
