<?php 
	 
	session_start();	
	$pagetitle = "Creat New Item";
	include "init.php";

	if(isset($_SESSION['user'])){

		if($_SERVER['REQUEST_METHOD'] == "POST"){

					$name 			= filter_var($_POST['itemName'],FILTER_SANITIZE_STRING);
					$description 	= filter_var($_POST['itemDescription'],FILTER_SANITIZE_STRING);
					$price 			= filter_var($_POST['itemPrice'],FILTER_SANITIZE_NUMBER_INT);
					$country		= filter_var($_POST['itemCountry'],FILTER_SANITIZE_STRING);
					$status 		= filter_var($_POST['itemStatus'],FILTER_SANITIZE_NUMBER_INT);
					$cat 			= filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);

					//Handeling Error 

					$formErrors = array();
					if(strlen($name)<2 || strlen($name)>25){
						$formErrors[] = "User Name Must Be <strong>Between 2 Character And 25 Character</strong>";
					}
					if(strlen($description)<2){
						$formErrors[] = "Description Must Be <strong>Between 2 Character And 25 Character</strong>";
					}
					if($status == 0){
						$formErrors[] = "You Must Be <strong>Choose Status</strong> For This Item";
					}
					if($cat == 0){
						$formErrors[] = "You Must Be <strong>Choose Category</strong> For This Item";
					}

					if(empty($formErrors)){
						$stmt = $con->prepare("INSERT INTO items(name, description, price, countryMade, status, addDate, cat_id, member_id)
				 						VALUES(:zname, :zdescription, :zprice, :zcountry , :zstatus, now(), :zcat, :zmember) ");
					 	$stmt->execute(array(
					 		'zname'			=> $name,
					 		'zdescription'	=> $description,
					 		'zprice'		=> $price,
					 		'zcountry'		=> $country,
					 		'zstatus'		=> $status,
					 		'zcat'		    => $cat,
					 		'zmember'		=> $_SESSION['uid']
					 	));
					 	$count = $stmt->rowCount();
					 	if($stmt){
					 		$successMsg = "<div class='alert alert-success'>" . $count . " Item Added </div>"; 
					 	}
					}					

			}										//End Of If Deliverd By Post Request

		?>
		<div class="create-add block">
			<div class="container">
				<h1 class="text-center"><?php echo $pagetitle ?></h1>
				<div class="card card-live">
					<div class="card-header">
						<?php echo $pagetitle ?>
					</div>
					<div class="card-body">
					
						<div class="row">
							<div class="col-md-9">
									<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

										<div class="form-group row main-ast">
										    <label class="col-md-3 col-sm-4 ">Name</label>
										    <div class="col-md-6 col-sm-8">
										      <input type="text" name="itemName" class="form-control live" required="required" placeholder="Name Of Item"
										       data-class=".live-name">
										    </div>
										</div>

										<!--Description-->
										<div class="form-group row main-ast">
										    <label class="col-md-3 col-sm-4">Description</label>
										    <div class="col-md-6 col-sm-8">
										      	<input type="text" name="itemDescription" class="form-control live" required="required" autocomplete="off" placeholder="Descripe The Item"
										      	 data-class='.live-desc'>
										    </div>
										</div>

										<!--Price-->
										<div class="form-group row main-ast">
										    <label class="col-md-3 col-sm-4">Price</label>
										    <div class="col-md-6 col-sm-8">
										      	<input type="text" name="itemPrice" class="form-control live" autocomplete="off" placeholder="Price Of Item"
										      	data-class='.live-price'
										      	required="required" 
										      	>
										    </div>
										</div>

										<!--Country-->
										 <div class="form-group row">
										    <label class="col-md-3 col-sm-4 col-form-label-lg">Country</label>
										    <div class="col-md-6 col-sm-8">
										      	<input type="text" name="itemCountry" class="form-control form-control-lg" autocomplete="off" placeholder="Country Of Made"
										      	class="live" data-class=".live-country">
										    </div>
										</div>

										<!--Status-->
										<div class="form-group row">
										    <label class="col-md-3 col-sm-4">Status</label>
										    <div class="col-md-6 col-sm-8">
										      	<select class="form-control" name="itemStatus" required="required">
										      		<option value="">. . .</option>
										      		<option value="1">New</option>
										      		<option value="2">Like New</option>
										      		<option value="3">Used</option>
										      		<option value="4">Old</option>
										      	</select>
										    </div>
										</div>

										<!--Category-->
										<div class="form-group row">
										    <label class="col-md-3 col-sm-4">Category</label>
										    <div class="col-md-6 col-sm-8">
										      	<select class="form-control" name="category" required="required">
										      		<option value="">. . .</option>
										      		<?php
										      			$cats = getAll('*', 'categories', '', 'id');
										      			
										      			foreach ($cats as $cat) {
										      				echo "<option value='". $cat['id'] ."'>" . $cat['name'] . "</option>";
										      			}
										      		?>
										      	</select>
										    </div>
										</div>
										
										<!--Submit-->
										<div class="form-group row">
										      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Add Item">
										</div>

									</form>
							</div>
							<div class="col-md-3">
								<div class="card item-box" style="width: 14rem;">
									<span class="price-tag">$<span class="live-price">0</span></span>
								    <img class="card-img-top" src="avatar.jpg" alt="Card image cap">
								    <div class="card-body">
									    <h5 class="card-title live-name">Title</h5>
									    <p class="card-text live-desc">Description</p>
								    </div>
								</div>
							</div>

						</div>

						<?php 

							if(! empty($formErrors)){
						 		foreach ($formErrors as $error) {
									echo "<div class='alert alert-danger'>" . $error . "</div>";
								}
							}

							if(isset($successMsg)){
								echo $successMsg;
							}
						
						?>

					</div>							<!-- End Of Card Body -->
				</div>

			</div>	
		</div>	
		

			
		
	<?php }		 
	

	include $tpl . 'footer.php';?>