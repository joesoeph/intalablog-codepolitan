<?php

/*
 * Include file connection.php dan helper.php
 */
include("connection.php"); 
include("helper.php"); 


/*
 * Cek apakah ada data dari $_GET['id']
 * Jika ada, maka jalankan kondisi pertama
 * Jika tidak, maka arahkan ke halaman index.php
 */
if( !empty($_GET['id']) ){
	$id = $_GET['id'];
	$query_posts = mysqli_query($connection, "SELECT a.* FROM posts a LEFT JOIN users b ON a.user_id = b.id WHERE a.id = $id");
	$result_posts = mysqli_fetch_all($query_posts, MYSQLI_ASSOC);

	/*
	 * Cek apakah detail post dari id ada di table atau tidak
	 * Jika tidak, maka arahkan ke halaman index.php
	 */
	if(!$result_posts){
		header("Location: ".$base_url.'index.php');
	}

} else {
	header("Location: ".$base_url.'index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Resume - Yusuf Fazeri</title>
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
        <div class="container mt-4">
        	<div class="col-md-12 shadow-sm p-4 mb-5 bg-white rounded">
  				<h1 class="text-center"><?=$result_posts[0]['title']?></h1>
  				<p class="text-right"><i><?='published : ' . human_date($result_posts[0]['published_at'], 'full')?></i></p>
  				<?php if($result_posts[0]['picture']) { ?>
  				<p class="text-center">
  					<img src="<?=$base_url . 'upload/' . $result_posts[0]['picture']?>" alt="">
  				</p>
  				<?php } ?>
  				<p> <?=$result_posts[0]['content']?> </p>
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
