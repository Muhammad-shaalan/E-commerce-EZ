<?php 
	 
	session_start();	

	$pagetitle = "Home";
	include "init.php";
		
		echo "<div class='container'>";
			echo "<h1 class='text-center'>Home Page</h1>";
			echo "<div class='row'>";

				foreach (getAll('*', 'items', 'WHERE approve=1', 'itemId') as $item) {?>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="card item-box" style="width: 14rem;">
								<span class="price-tag">$ <?php echo $item['price'];?></span>
							    <img class="card-img-top" src="avatar.jpg" alt="Card image cap">
							    <div class="card-body">
                                    <h5 class="card-title"><a href="item.php?itemId=<?php echo $item['itemId'] ?>"><?php echo $item['name'];?></a></h5>
								    <p class="card-text"><?php echo $item['description'];?></p>
								    <div class="date"><?php echo $item['addDate'];?></div>
							    </div>
							</div>
						</div>
				<?php }
			echo "</div>";	
		echo "</div>";								//End Of Container
		 
	

	include $tpl . 'footer.php';?>