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
include("../connection.php"); 
include("../helper.php"); 

/*
 * Halaman admin perlu login dulu untuk aksesnya
 * Disini harus di cek dulu apakah sudah ada login sessionnya atau belum?
 * Jika sudah, maka halaman dapat diakses
 * Jika belum, maka arahkan ke halaman index.php
 */
if(!$_SESSION){
	header("Location: ".$base_url.'index.php');
}


/*
 * Buat dan jalankan semua perintah querynya disini
 */
$query_users = mysqli_query($connection, "SELECT * FROM users");
$query_experiences = mysqli_query($connection, "SELECT * FROM experiences");
$query_awards = mysqli_query($connection, "SELECT * FROM awards");
$query_educations = mysqli_query($connection, "SELECT * FROM educations");
$query_posts = mysqli_query($connection, "SELECT a.* FROM posts a LEFT JOIN users b ON a.user_id = b.id ");
$query_skills = mysqli_query($connection, "SELECT * FROM skills");

$result_users = mysqli_fetch_all($query_users, MYSQLI_ASSOC);
$result_experiences = mysqli_fetch_all($query_experiences, MYSQLI_ASSOC);
$result_awards = mysqli_fetch_all($query_awards, MYSQLI_ASSOC);
$result_educations = mysqli_fetch_all($query_educations, MYSQLI_ASSOC);
$result_posts = mysqli_fetch_all($query_posts, MYSQLI_ASSOC);
$result_skills = mysqli_fetch_all($query_skills, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin Panel</title>
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body class="p-0">
        <!-- Page Content-->
        <div class="container mt-4">
        	<?php 
        	/*
			 * Baris kode notif ini digunakan untuk menampilkan notifikasi
			 * Notifikasi berhasil atau gagal tambah, edit, atau hapus data
			 * Disimpan dalam $_SESSION agar mudah mengaksesnya antar halaman
			 * Inisiasi nilai $_SESSION terjadi pada halaman process.php. Silahkan dilihat
        	 */
        	if(isset($_SESSION['notif_type'])) { ?>
        	<div class="alert alert-<?=$_SESSION['notif_type']?>" role="alert">
				<?=$_SESSION['notif_message']?>
			</div>
			<?php 
			/*
			 * Hapus notifikasi ketika sudah ditampilkan notifikasinya
			 */
			unset($_SESSION['notif_type']);
			unset($_SESSION['notif_message']);
			} ?>
        	<div class="col-md-12 shadow-sm p-4 mb-5 bg-white rounded">
        		<div class="d-flex justify-content-between">
	                <h4 class="mb-0">
	                    Admin
	                    <span class="text-primary">Panel</span>
	                </h4>
	        		<p>
	        			<a href="<?=$base_url.'index.php'?>" class="btn btn-primary">Go to my site</a>
	        		</p>
        		</div>
  				<h2>Hallo, <?=$_SESSION['fullname']?>!</h2>
				<p>You can customize information here.</p>

				<!-- Nav Tabs Group -->
				<ul class="nav nav-tabs" id="myTab" role="tablist">

					<!-- Link About -->
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">About</a>
					</li>

					<!-- Link Experiences -->
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="experience-tab" data-toggle="tab" href="#experience" role="tab" aria-controls="experience" aria-selected="false">Experiences</a>
					</li>

					<!-- Link Educations -->
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="education-tab" data-toggle="tab" href="#education" role="tab" aria-controls="education" aria-selected="false">Educations</a>
					</li>

					<!-- Link Skills -->
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="skill-tab" data-toggle="tab" href="#skill" role="tab" aria-controls="skill" aria-selected="false">Skills</a>
					</li>

					<!-- Link Awards -->
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="award-tab" data-toggle="tab" href="#award" role="tab" aria-controls="award" aria-selected="false">Awards</a>
					</li>

					<!-- Link Posts -->
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="post-tab" data-toggle="tab" href="#post" role="tab" aria-controls="post" aria-selected="false">Posts</a>
					</li>
				</ul>
				<!-- ./ Nav Tab Group -->

				<!-- Tab Content Group -->
				<div class="tab-content" id="myTabContent">

					<!-- Tab Content About -->
					<div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
						<div class="row">
							<div class="col-12">
				                <h4 class="my-3">
				                    About
				                </h4>
							</div>
							<div class="col-12">
				        		<form action="<?=$base_url . 'admin/users/process.php?type=edit&id='.$_SESSION['user_id']?>" method="POST" class="mt-3" enctype="multipart/form-data">
								    <div class="form-group">
								    	<?php 
								    	$picture = isset($result_users) ? $result_users[0]['picture'] : '';
								    	$img_src = $base_url.'upload/'.$picture;
								    	if($picture) { ?>
								    	<p>
								    		<a href="<?=$img_src?>" target="_blank"><img src="<?=$img_src?>" alt="<?=$picture?>" height="120px" class="rounded-circle"></a>
								    	</p>
								    	<?php } ?>
								        <label for="picture">Picture</label>
								        <input type="file" name="picture" class="form-control" id="picture">
								    </div>
								    <div class="form-group">
								        <label for="fullname">Fullname</label>
								        <input type="text" name="fullname" class="form-control" id="fullname" value="<?=isset($result_users) ? $result_users[0]['fullname'] : ''?>">
								    </div>
								    <div class="form-group">
								        <label for="email">Email</label>
								        <input type="email" name="email" class="form-control" id="email" value="<?=isset($result_users) ? $result_users[0]['email'] : ''?>">
								    </div>
								    <div class="form-group">
								        <label for="phone">Phone</label>
								        <input type="text" name="phone" class="form-control" id="phone" value="<?=isset($result_users) ? $result_users[0]['phone'] : ''?>">
								    </div>
								    <div class="form-group">
								        <label for="address">Address</label>
								        <textarea name="address" class="form-control" id="address" rows="3"><?=isset($result_users) ? $result_users[0]['address'] : ''?></textarea>
								    </div>
								    <div class="form-group">
								        <label for="about">About</label>
								        <textarea name="about" class="form-control" id="about" rows="3"><?=isset($result_users) ? $result_users[0]['about'] : ''?></textarea>
								    </div>
								    <div class="form-group">
								        <label for="interest">Interest</label>
								        <textarea name="interest" class="form-control" id="interest" rows="3"><?=isset($result_users) ? $result_users[0]['interest'] : ''?></textarea>
								    </div>
								    <button type="submit" class="btn btn-primary">Save</button>
								</form>
								<hr>
							</div>
							<div class="col-12 mt-3">
				        		<form action="<?=$base_url . 'admin/users/process.php?type=change_password&id='.$_SESSION['user_id']?>" method="POST" class="mb-3">
								    <div class="form-group">
								        <label for="username">Username</label>
								        <input type="text" name="username" class="form-control" id="username" aria-describedby="username" value="<?=isset($result_users) ? $result_users[0]['username'] : ''?>">
								    </div>
								    <div class="form-group">
								        <label for="password">Password</label>
								        <input type="password" name="password" class="form-control" id="password">
								    </div>
								    <div class="form-group">
								        <label for="retype-password">Retype-Password</label>
								        <input type="password" name="retype_password" class="form-control" id="retype-password">
								    </div>
								    <button type="submit" class="btn btn-primary">Update Password</button>
								</form>
							</div>
						</div>
					</div>

					<!-- Tab Content Experiences -->
					<div class="tab-pane fade" id="experience" role="tabpanel" aria-labelledby="experience-tab">
						<div class="row">
							<div class="col-12">
				                <h4 class="my-3">
				                    Experiences
				                </h4>
							</div>
							<div class="col-12">
								<p class="text-right">
									<a href="<?=$base_url. 'admin/experiences/form.php'?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
								</p>
								<table class="table table-bordered table-hover table-sm mt-3">
									<thead>
										<tr>
											<th scope="col" width="5%">#</th>
											<th scope="col">Name</th>
											<th scope="col">Place</th>
											<th scope="col">Date</th>
											<th scope="col" width="5%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($result_experiences){
										$num = 1;
										foreach($result_experiences as $r) { ?>
										<tr>
											<th scope="row"><?=$num++?></th>
											<td><?=$r['name']?></td>
											<td><?=$r['place']?></td>
											<td><?=human_date($r['date_start'])?> - <?=human_date($r['date_end'])?></td>
											<td>
												<a href="<?=$base_url.'admin/experiences/form.php?id='.$r['id']?>" class="badge badge-primary"><i class="fas fa-pen"></i></a>
												<a href="<?=$base_url.'admin/experiences/process.php?type=delete&id='.$r['id']?>" class="badge badge-danger" onclick="return confirm('Sure to delete this data?')"><i class="fas fa-trash"></i></a>
											</td>
										</tr>
										<?php }
										} else { ?>
										<tr>
											<td colspan="5" class="text-center">No data</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- Tab Content Educations -->
					<div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
						<div class="row">
							<div class="col-12">
				                <h4 class="my-3">
				                    Educations
				                </h4>
							</div>
							<div class="col-12">
								<p class="text-right">
									<a href="<?=$base_url. 'admin/educations/form.php'?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
								</p>
								<table class="table table-bordered table-hover table-sm mt-3">
									<thead>
										<tr>
											<th scope="col" width="5%">#</th>
											<th scope="col">Name</th>
											<th scope="col">Place</th>
											<th scope="col">Date</th>
											<th scope="col" width="5%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($result_educations){
										$num = 1;
										foreach($result_educations as $r) { ?>
										<tr>
											<th scope="row"><?=$num++?></th>
											<td><?=$r['name']?></td>
											<td><?=$r['place']?></td>
											<td><?=human_date($r['date_start'])?> - <?=human_date($r['date_end'])?></td>
											<td>
												<a href="<?=$base_url.'admin/educations/form.php?id='.$r['id']?>" class="badge badge-primary"><i class="fas fa-pen"></i></a>
												<a href="<?=$base_url.'admin/educations/process.php?type=delete&id='.$r['id']?>" class="badge badge-danger" onclick="return confirm('Sure to delete this data?')"><i class="fas fa-trash"></i></a>
											</td>
										</tr>
										<?php }
										} else { ?>
										<tr>
											<td colspan="5" class="text-center">No data</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>

						</div>
					</div>

					<!-- Tab Content Skill -->
					<div class="tab-pane fade" id="skill" role="tabpanel" aria-labelledby="skill-tab">
						<div class="row">
							<div class="col-12">
				                <h4 class="my-3">
				                    Skills
				                </h4>
							</div>
							<div class="col-12">
								<p class="text-right">
									<a href="<?=$base_url. 'admin/skills/form.php'?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
								</p>
								<table class="table table-bordered table-hover table-sm mt-3">
									<thead>
										<tr>
											<th scope="col" width="5%">#</th>
											<th scope="col">Name</th>
											<th scope="col">Description</th>
											<th scope="col" width="5%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($result_skills){
										$num = 1;
										foreach($result_skills as $r) { ?>
										<tr>
											<th scope="row"><?=$num++?></th>
											<td><?=$r['name']?></td>
											<td><?=$r['description']?></td>									
											<td>
												<a href="<?=$base_url.'admin/skills/form.php?id='.$r['id']?>" class="badge badge-primary"><i class="fas fa-pen"></i></a>
												<a href="<?=$base_url.'admin/skills/process.php?type=delete&id='.$r['id']?>" class="badge badge-danger" onclick="return confirm('Sure to delete this data?')"><i class="fas fa-trash"></i></a>
											</td>
										</tr>
										<?php }
										} else { ?>
										<tr>
											<td colspan="5" class="text-center">No data</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>

						</div>
					</div>

					<!-- Tab Content Awards -->
					<div class="tab-pane fade" id="award" role="tabpanel" aria-labelledby="award-tab">
						<div class="row">
							<div class="col-12">
				                <h4 class="my-3">
				                    Awards
				                </h4>
							</div>
							<div class="col-12">
								<p class="text-right">
									<a href="<?=$base_url. 'admin/awards/form.php'?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
								</p>
								<table class="table table-bordered table-hover table-sm mt-3">
									<thead>
										<tr>
											<th scope="col" width="5%">#</th>
											<th scope="col">Name</th>
											<th scope="col">Description</th>
											<th scope="col" width="5%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($result_awards){
										$num = 1;
										foreach($result_awards as $r) { ?>
										<tr>
											<th scope="row"><?=$num++?></th>
											<td><?=$r['name']?></td>
											<td><?=$r['description']?></td>
											<td>
												<a href="<?=$base_url.'admin/awards/form.php?id='.$r['id']?>" class="badge badge-primary"><i class="fas fa-pen"></i></a>
												<a href="<?=$base_url.'admin/awards/process.php?type=delete&id='.$r['id']?>" class="badge badge-danger" onclick="return confirm('Sure to delete this data?')"><i class="fas fa-trash"></i></a>
											</td>
										</tr>
										<?php }
										} else { ?>
										<tr>
											<td colspan="4" class="text-center">No data</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!-- Tab Content Posts -->
					<div class="tab-pane fade" id="post" role="tabpanel" aria-labelledby="post-tab">
						<div class="row">
							<div class="col-12">
				                <h4 class="my-3">
				                    Posts
				                </h4>
							</div>
							<div class="col-12">
								<p class="text-right">
									<a href="<?=$base_url. 'admin/posts/form.php'?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
								</p>
								<table class="table table-bordered table-hover table-sm mt-3">
									<thead>
										<tr>
											<th scope="col" width="5%">#</th>
											<th scope="col">Title</th>
											<th scope="col" width="5%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($result_posts){
										$num = 1;
										foreach($result_posts as $r) { ?>
										<tr>
											<th scope="row"><?=$num++?></th>
											<td><?=$r['title']?></td>
											<td>
												<a href="<?=$base_url.'admin/posts/form.php?id='.$r['id']?>" class="badge badge-primary"><i class="fas fa-pen"></i></a>
												<a href="<?=$base_url.'admin/posts/process.php?type=delete&id='.$r['id']?>" class="badge badge-danger" onclick="return confirm('Sure to delete this data?')"><i class="fas fa-trash"></i></a>
											</td>
										</tr>
										<?php }
										} else { ?>
										<tr>
											<td colspan="3" class="text-center">No data</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

				</div>
				<!-- ./ Tab Content Group -->

			</div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
    </body>
</html>
