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
include("connection.php"); 
include("helper.php"); 


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
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none">Yusuf Fazeri</span>
                <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="<?=$base_url . 'upload/' . $result_users[0]['picture']?>" alt="" /></span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#experience">Experience</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#education">Education</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#skills">Skills</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#interests">Interests</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#awards">Awards</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#posts">Posts</a></li>
                    <?php if($_SESSION) { ?>
                    <li class="nav-item bg-white rounded-sm px-2"><a class="nav-link js-scroll-trigger text-dark" href="<?=$base_url.'admin/admin.php'?>">Dashboard</a></li>
                    <li class="nav-item bg-danger rounded-sm mt-2 px-2"><a class="nav-link js-scroll-trigger text-white" href="<?=$base_url.'logout.php'?>" onclick="return confirm('Yakin ingin Logout?')">Log Out</a></li>
                	<?php } else { ?>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="login.php">Login Me</a></li>
                	<?php } ?>
                </ul>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <!-- About-->
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                        Yusuf
                        <span class="text-primary">Fazeri</span>
                    </h1>
                    <div class="subheading mb-5">
                        <?=$result_users[0]['address']?> · <?=$result_users[0]['phone']?> · <a href="mailto:<?=$result_users[0]['email']?>"><?=$result_users[0]['email']?></a>
                    </div>
                    <p class="lead mb-5">
                    	<?=$result_users[0]['about']?>
                    </p>
                    <div class="social-icons">
                        <a class="social-icon" href="<?=$result_users[0]['linkedin_url'] ? $result_users[0]['linkedin_url'] : '#'?>"><i class="fab fa-linkedin-in"></i></a>
                        <a class="social-icon" href="<?=$result_users[0]['github_url'] ? $result_users[0]['github_url'] : '#'?>"><i class="fab fa-github"></i></a>
                        <a class="social-icon" href="<?=$result_users[0]['facebook_url'] ? $result_users[0]['facebook_url'] : '#'?>"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </section>
            <hr class="m-0" />
            <!-- Experience-->
            <section class="resume-section" id="experience">
                <div class="resume-section-content">
                    <h2 class="mb-5">Experience</h2>
                	<?php foreach ($result_experiences as $r) { ?>
                    <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                        <div class="flex-grow-1">
                            <h3 class="mb-0"><?=$r['name']?></h3>
                            <div class="subheading mb-3"><?=$r['place']?></div>
                            <p><?=$r['description']?></p>
                        </div>
                        <div class="flex-shrink-0"><span class="text-primary"><?=human_date($r['date_start'])?> - <?=human_date($r['date_end'])?></span></div>
                    </div>
                	<?php } ?>
                </div>
            </section>
            <hr class="m-0" />
            <!-- Education-->
            <section class="resume-section" id="education">
                <div class="resume-section-content">
                    <h2 class="mb-5">Education</h2>
                    <?php foreach ($result_educations as $r) { ?>
                    <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                        <div class="flex-grow-1">
                            <h3 class="mb-0"><?=$r['place']?></h3>
                            <div class="subheading mb-3"><?=$r['name']?></div>
                            <div><?=$r['description']?></div>
                        </div>
                        <div class="flex-shrink-0"><span class="text-primary"><?=human_date($r['date_start'])?> - <?=human_date($r['date_end'])?></span></div>
                    </div>
                	<?php } ?>
                </div>
            </section>
            <hr class="m-0" />
            <!-- Skills-->
            <section class="resume-section" id="skills">
                <div class="resume-section-content">
                    <h2 class="mb-5">Skills</h2>
                    <ul class="fa-ul mb-0">
                    <?php foreach ($result_skills as $r) { ?>
                    	<li>
                            <span class="fa-li"><i class="fas fa-check"></i></span>
                    		<?=$r['name']?> - <?=$r['description']?></li>
                	<?php } ?>
                    </ul>
                </div>
            </section>
            <hr class="m-0" />
            <!-- Interests-->
            <section class="resume-section" id="interests">
                <div class="resume-section-content">
                    <h2 class="mb-5">Interests</h2>
                    <p><?=$result_users[0]['interest']?></p>
                </div>
            </section>
            <hr class="m-0" />
            <!-- Awards-->
            <section class="resume-section" id="awards">
                <div class="resume-section-content">
                    <h2 class="mb-5">Awards & Certifications</h2>
                    <ul class="fa-ul mb-0">
                    <?php foreach ($result_awards as $r) { ?>
                        <li>
                            <span class="fa-li"><i class="fas fa-trophy text-warning"></i></span>
                            <?=$r['name'] . '-' . $r['description']?>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
            </section>
            <!-- Posts-->
            <section class="resume-section" id="posts">
                <div class="resume-section-content">
                    <h2 class="mb-5">My Posts</h2>
                    <div class="card-columns">
                    	<?php foreach ($result_posts as $r) { ?>
					    <div class="card">
					    	<?php if($r['picture']) { ?>
					    		<div style="background-image: url('<?=$base_url . 'upload/' . $r['picture']?>'); height: 160px; background-position: center;"></div>
					    	<?php } ?>
					        <div class="card-body">
					            <h5 class="card-title">
					            	<a href="<?=$base_url . 'detail.php?id=' . $r['id']?>"><?=$r['title']?></a>
					            </h5>
					            <p class="card-text"><?=substr($r['content'], 0, 150)?></p>
					            <p class="card-text text-right"><small class="text-muted"><?=human_date($r['published_at'], 'full')?></small></p>
					        </div>
					    </div>
                		<?php } ?>
					</div>
                </div>
            </section>
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
