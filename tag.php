<?php 
	 
	session_start();
	$pagetitle = "Tags";
	include "init.php";
	?>
		<div class='container'>
			<?php
			if(isset($_GET['name'])){
					$tagName = $_GET['name'];
					echo "<h1 class='text-center'>$tagName</h1>";
				}
			?>
			<div class='row'>
			<?php
				if(isset($_GET['name'])){
					$tagName = $_GET['name'];
					foreach (getAll("*", "items","WHERE tags LIKE '%$tagName%' AND approve = 1", "itemId") as $item) {?>
							<div class="col-lg-3 col-md-4 col-sm-6">
								<div class="card item-box" style="width: 14rem;">
									<span class="price-tag"><?php echo $item['price'];?></span>
								    <img class="card-img-top" src="avatar.jpg" alt="Card image cap">
								    <div class="card-body">
                                        <h5 class="card-title"><a href="item.php?itemId=<?php echo $item['itemId'] ?>"><?php echo $item['name'];?></a></h5>
									    <p class="card-text"><?php echo $item['description'];?></p>
									    <div class="date"><?php echo $item['addDate'];?></div>
								    </div>
								</div>
							</div>
					<?php }
							
			}else{
				echo "Error";
			}
			echo "</div>";	
		echo "</div>";								//End Of Container

	include $tpl . 'footer.php';?>