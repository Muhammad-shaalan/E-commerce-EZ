<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title><?php getTitle() ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>all.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery-ui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery.selectBoxIts.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>fron.css">
	</head>
	<body>

			<div class="nav-upper clearfix">
		  		<div class="container">
		  			 <?php 
			  			if(isset($_SESSION['user'])){?>
			  				<img class="img-circle img-thumbnail img-responsive img-user mx-auto" src="avatar.jpg">
				  			<div class="btn-group dropdown show">
								<span class="btn btn-custom dropdown-toggle" data-toggle="dropdown">
									<?php echo $sessionUser; ?>
								</span>

								  <div class="dropdown-menu">
									   <a class="dropdown-item" href='profile.php'>My Profile</a>
									   <a class="dropdown-item" href='ads.php'>New Item</a>
									   <a class="dropdown-item" href='logout.php'>Logout</a>
								  </div>
							</div>
						<?php }else{
							echo "<a href='login.php'><span class='float-right'>login\Signup</span></a>";
						}?>
		  		</div>
		  	</div>

		  
  
		  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		    <div class="container">
		      <a class="navbar-brand" href="index.php"><?php echo lang('admin home'); ?></a>
		      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		      </button>
		      <div class="collapse navbar-collapse" id="navbarSupportedContent">
		        <ul class="navbar-nav ml-auto">
		        	<?php include "admin/connect.php";
		        		$getCat = getAll("*", "categories", "WHERE parent = 0", "id", "ASC");
		        		foreach ($getCat as $cat) {
							echo "<li class='nav-item'>
										<a class='nav-link' href='categories.php?pageId=" . $cat['id'] . "'>"
																 . $cat['name'] . "</a></li>";
						}
		        	?>
		        </ul>
		      </div>
		    </div> 
		  </nav>

