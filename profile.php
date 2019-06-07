<?php 
	 
	session_start();	
	$pagetitle = "My Profile";
	include "init.php";


	if(isset($_SESSION['user'])){

		$getInfo = $con->prepare("SELECT * FROM users WHERE userName = ?");
		$getInfo->execute(array($sessionUser));
		$info = $getInfo->fetch();

		?>

		<h1 class="text-center">My Profile</h1>
		<div class="information block">
			<div class="container">
				
				<div class="card">
					<div class="card-header">
						My Information
					</div>
					<div class="card-body">
						<ul class="list-unstyled">
							<li>
								<i class="fa fa-unlock-alt fa-fw"></i>
								<span>Name</span> 		:<?php echo $info['userName']; ?>
							</li>
							<li>
								<i class="fas fa-envelope fa-fw"></i>
								<span>Email:</span> 	:<?php echo $info['email']; ?>
							</li>
							<li>
								<i class="fa fa-user fa-fw"></i>
								<span>Full Name:</span>	:<?php echo $info['fullName']; ?>
							</li>
							<li>
								<i class="fa fa-tags fa-fw"></i>
								<span>Register Date:</span> :<?php echo $info['Date']; ?>
							</li>
						</ul>
						<div class="btn btn-default">Edit Information</div>
					</div>
				</div>

			</div>	
		</div>	

		<div class="myAds block">
			<div class="container">
				
				<div class="card">
					<div class="card-header">
						My Ads
					</div>
					<div class="card-body">
						
							<?php
							$itemTable = getAll("*", "items", "WHERE member_id = {$info['userId']}", "itemId");
							if(! empty($itemTable)){
								echo "<div class='row'>";
									foreach ($itemTable as $item) {?>

											<div class="col-lg-3 col-md-4 col-sm-6">
												<div class="card item-box" style="width: 14rem;">
													<?php if($item['approve'] == 0)
													{echo "<span class='approve-status'>Not Approval</span>";}?>
													<span class="price-tag"><?php echo '$' . $item['price'];?></span>
												    <img class="card-img-top" src="avatar.jpg" alt="Card image cap">
												    <div class="card-body"> 
												    	<?php
													    echo "<h3 class='card-title'>
													    		<a href='item.php?itemId=" . $item['itemId'] . "'>". $item['name'] . " </a>
													    	 </h3>" ?>
													    <p class="card-text"><?php echo $item['description'];?></p>
													    <div class="date"><?php echo $item['addDate'];?></div>
												    </div>
												</div>
											</div>
											
									<?PHP } ?>
								</div>				<!-- End Of Row -->
									
							<?php }else{
								echo "Thers's No Ads To Show." . "<a href='ads.php'>New Add</a>";
							}
							 ?>
							
					</div>
				</div>

			</div>

		<div class="myComments block">
			<div class="container">
				
				<div class="card">
					<div class="card-header">
						Latest Comment
					</div>
					<div class="card-body">
						
							<?php
							if(! empty(getCom('user_id',$info['userId']))){
								echo "<div class='row'>";
								foreach (getCom('user_id',$info['userId']) as $com) {?>
										<div class="col-lg-3 col-md-4 col-sm-6">
											<div class="card item-box" style="width: 14rem;">
											    <div class="card-body">
											    	<p class="card-text">Item: <?php echo $com['Item'];?></p>
												    <p class="card-text">Comment: <?php echo $com['comment'];?></p>
												    <p class="card-text">Date: <?php echo $com['commentDate'];?></p>
											    </div>
											</div>
										</div>							
								<?php }
							echo "</div>"; 
							} else{
								echo "No Comment To Show";
							}
							?>

					</div>
				</div>

			</div>	
		</div>	

			
		
	<?php }		 
	

	include $tpl . 'footer.php';?>