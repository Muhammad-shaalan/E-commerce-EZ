<?php 
	session_start();
	 
	$pagetitle = "Item";
	include "init.php";

		$itemid = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;
		$stmt = $con->prepare("SELECT 
										items.*, categories.name 
									AS  
										Category, users.userName 
									AS 
										Member 
									FROM 
										items 
									INNER JOIN 
										categories 
									ON 
										categories.id = items.cat_id 
									INNER JOIN 
										users 
									ON 
										users.userId = items.member_id
									 WHERE itemId=?
									 AND  approve = 1
									 ");
		$stmt->execute(array($itemid));
		$count = $stmt->rowCount();?>
		<div class="container">
	<?php if($count > 0){
			$item = $stmt->fetch();?>
			<h1 class="text-center"><?php echo $item['name'] ?></h1>
				<div class="row">
					<div class="col-sm-3">
						<img src="avatar.jpg" class="img-ads img-responsive">
					</div>
					<div class="col-sm-9 info">
						<h2><?php echo $item['name'] ?></h2>
						<p><?php echo $item['description'] ?></p>
						<ul class="list-unstyled">
							<li>
								<i class="fa fa-calendar fa-fw"></i>
								<span>Price</span> : <?php echo $item['price'] ?>
							</li>
							<li>
								<i class="fa fa-money-bill-alt fa-fw"></i>
								<span>Added Date</span> : <?php echo $item['addDate'] ?>
							</li>
							<li>
								<i class="fa fa-building fa-fw"></i>
								<span>Made In</span> : <?php echo $item['countryMade'] ?>
							</li>
							<li>
								<i class="fa fa-tags fa-fw"></i>
								<span>Category</span> :<a href="categories.php?pageId=<?php echo $item['cat_id']?> "> <?php echo $item['Category'] ?></a>
							</li>
							<li>
								<i class="fa fa-user fa-fw"></i>
								<span>Added by</span> : <?php echo $item['Member'] ?>
							</li>
							<li class="itemTags">
								<i class="fa fa-user fa-fw"></i>
								<span>Added by</span> : <?php
								 $allTags = explode(",", $item['tags']);

								 foreach ($allTags as $tag) {
								 	$tag = str_replace(" ", "" , $tag);
								 	$lowerTags = strtolower($tag); 
								 	if(! empty($lowerTags)){
								 		echo "<a href='tag.php?name={$lowerTags}'>" . $lowerTags . "</a>";
								 	}
								 }
								 ?>
							</li>
						</ul>
						
					</div>
				</div>
				<hr class="custom-hr">

				<?php if(isset($_SESSION['user'])){ ?>
					<div class="row">
						<div class="offset-md-3">
							<div class="add-comment">
								<h3>Add Your Comment</h3>
								<form action="<?php echo $_SERVER['PHP_SELF'] . '?itemId=' . $item['itemId'] ?>" method="POST">
									<textarea name="comment"></textarea>
									<input class="btn btn-primary" type="submit" value="Add Comment">
								</form>
								<?php
									if($_SERVER['REQUEST_METHOD'] == 'POST' ){
										$comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
										$itemid = $item['itemId'];
										$userid = $_SESSION['uid'];

										if(! empty($comment)){
											$stmt = $con->prepare("INSERT INTO
														comments(comment, item_id, user_id, status, commentDate)
									 					VALUES(:zcomment, :zitemid , :zuserid,  0, now()) ");
										 	$stmt->execute(array(
										 		'zcomment'	=> $comment,
										 		'zitemid'	=> $itemid,
										 		'zuserid'	=> $userid,
										 	));
										 	$count = $stmt->rowCount();
										 	if($stmt){
										 		echo "<div class='alert alert-success'>Successfully Added</div>";
										 	}
										 	
										}else{
											echo "<div class='alert alert-danger'>You Must Write Anything</div>";
										}				
										
									}
								?>
							</div>
						</div>
					</div>
				<?php
				}else{
					echo "<a href='login.php'>Login To Make A Comment</a>";
				}
				?>	

				<hr class="custom-hr">

				<?php
					$stmt = $con->prepare("SELECT comments.*, users.userName As Member FROM comments 
								
								INNER join
								users ON users.userId = comments.user_id
								WHERE item_id = ? AND status = 1
								 ORDER BY cId DESC
								");
				$stmt->execute(array($item['itemId']));
				$coms = $stmt->fetchall();
				foreach ($coms as $com) {?>
					<div class="comment-box">
						<div class='row'>
							<div class="col-sm-2">
								<img class="img-circle img-thumbnail img-responsive img-com d-block mx-auto" src="avatar.jpg">
								<span class="text-center d-block"><?php echo $com['Member'];?></span>
							</div>
							<div class="col-sm-10">
								<p class="lead"><?php echo $com['comment'];?></p>
							</div>
						</div>
					</div>
					
			<?php }
					
				?>

			
		<?php }else{
			echo "<div class='alert alert-danger'>There's Id Is Not Exist Or Items Not Approval<div>";
		}?>
		</div>										<!-- //End Container -->

		
	<?php  
	include $tpl . 'footer.php';?>