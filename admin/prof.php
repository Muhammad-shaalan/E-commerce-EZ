<?php
session_start();
if(isset($_SESSION['username'])){
	$pagetitle = "Profile";
	include "init.php";

	?>

	<div class="home-stats">
		<div class="container text-center">

			<h1>Dashboard</h1>
			<div class="row">
				<div class="col-sm-3">
					<div class="stat st-member">
						<i class="fa fa-users icon"></i>
						<div class="info">
							Total Members
							<span><a href="member.php"><?php echo countmember('userId','users'); ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="stat st-pending">
						<i class="fa fa-user-plus icon"></i>
						<div class="info">
							Pending Members
							<span>
								<a href="member.php?do=manage&page=pending"><?php echo checkItem('regStatus', 'users',
							 	'0');?>
							 	</a>
							</span>
						</div>
					</div>	
				</div>
				<div class="col-sm-3">
					<div class="stat st-item">
						<i class="fa fa-tag icon"></i>
						<div class="info">
							Total Items
							<span><a href="item.php"><?php echo countmember('itemId','items'); ?></a></span>
						</div>
					</div>	
				</div>
				<div class="col-sm-3">
					<div class="stat st-comment">
						<i class="fa fa-comments icon"></i>
						<div class="info">
							Comment
							<span>
								<a href="comment.php?do=manage"><?php echo countmember('cId', 'comments');?>
							 	</a>
							</span>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	
	<div class="latest">
		<div class="container">

			<div class="row">

				<div class="col-sm-6">

					<div class="card">
						<?php	$numberOfMemberShow = 5; ?>
					  <div class="card-header">
					    <i class="fa fa-users"></i> Latest <?php echo $numberOfMemberShow ?> Users
					    <span class="toggle-info pull-right">
					    	<i class="fa fa-plus"></i>
					    </span>
					  </div>
					  <div class="card-body">
					    <blockquote class="blockquote mb-0">

					      <?php $latest =  theLatest("*","users","userId", $numberOfMemberShow);

					      echo "<ul class='list-unstyled'>";
						      	foreach ($latest as $user) {
						      		echo "<li>";
						      			echo $user['userName'];
						      			echo "<a href='member.php?do=Edit&userId=" .$user['userId'] . "' class='pull-right btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
						      			if($user['regStatus'] == 0){
						      				echo "<a href='member.php?do=activate&userId=" . $user['userId'] ." '    class='pull-right btn btn-info activate'>
						      					<i class='fa fa-check'></i> Activate</a>";
						      			}	
						      		echo "</li>";

						      	}
					      ?>
					      <ul>
					    </blockquote>
					  </div>
					</div>

				</div>

				<div class="col-sm-6">
					
					<div class="card">
						<?php	$numberOfItemsShow = 5; ?>
					  <div class="card-header">
					    <i class="fa fa-tag"></i> Latest <?php echo $numberOfItemsShow ?> Items
					    <span class="toggle-info pull-right">
					    	<i class="fa fa-plus"></i>
					    </span>
					  </div>
					  <div class="card-body">
					    <blockquote class="blockquote mb-0">

					      <?php $latestItem =  theLatest("*","items","itemId", $numberOfItemsShow);
					      
					      echo "<ul class='list-unstyled'>";
						      	foreach ($latestItem as $item) {
						      		echo "<li>";
						      			echo $item['name'];
						      			echo "<a href='item.php?do=Edit&itemId=" .$item['itemId'] . "' class='pull-right btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
						      			if($item['approve'] == 0){
						      				echo "<a href='item.php?do=approve&itemId=" . $item['itemId'] ." '    class='pull-right btn btn-info approve'>
						      					<i class='fa fa-check'></i> Approve</a>";
						      			}	
						      		echo "</li>";

						      	}
					      ?>
					      <ul>
					    </blockquote>
					  </div>
					</div>
				
			</div>

		</div>										<!-- End Of Row -->	

		<!-- Commmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmnet -->

		<div class="row">

				<div class="col-sm-6">

					<div class="card">
						<?php	$numberOfCommentShow = 5; ?>
					  <div class="card-header">
					    <i class="fa fa-comments"></i> Latest <?php echo $numberOfCommentShow ?> Comments
					    <span class="toggle-info pull-right">
					    	<i class="fa fa-plus"></i>
					    </span>
					  </div>
					  <div class="card-body">
					    <blockquote class="blockquote mb-0">

					    	<?php

								$stmt = $con->prepare("SELECT comments.*, users.userName As Member FROM comments
												INNER join
												users ON users.userId = comments.user_id 
												ORDER BY cId DESC LIMIT $numberOfCommentShow");
								$stmt->execute(array());
								$comments = $stmt->fetchall();

								foreach ($comments as $comment) {
									echo "<div class='comment-box'>";
										echo "<a href='member.php?do=Edit&userId=" . $comment['user_id'] ."'><span class='member-n'>" . $comment['Member'] . "</span></a>";
										echo "<span class='member-c'>" . $comment['comment'] . "</span>";
									echo "</div>";
								}
								
							 ?>
					      
					    </blockquote>
					  </div>
					</div>

				</div>

				

		</div>										<!-- End Of Row -->	

		</div>										<!-- End Of Container -->
	</div>											<!-- End Of Latest Div -->


	<?php
	include $tpl . 'footer.php';
	} else{
		header('Location: index.php');
		exit();
	}