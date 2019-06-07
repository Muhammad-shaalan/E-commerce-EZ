<?php
session_start();

if(isset($_SESSION['username'])){

	$pagetitle = "Category"; 							//To Get Title Of Page
	include "init.php";
	

	if(isset($_GET['do'])){
		$do = $_GET['do'];
	}else{
		$do = "manage";
	}

	if($do == "manage"){ 							//Start Of Manage Section

		$approveStatus = '';

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
									ORDER BY itemId DESC	

								");
			$stmt->execute();
			$items = $stmt->fetchall();

			if(! empty($items)){
			?>
			
			<div class="container">
				<h1 class="text-center">Manage Item</h1>
				<div class="table-responsive">
					<table class="main-table table table-bordered text-center scroll">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Member</td>
							<td>Control</td>
						</tr>
							<?php 
								foreach ($items as $item) {
									echo "<tr>";
										echo "<td>" . $item['itemId'] . "</td>";
										echo "<td>" . $item['name'] . "</td>";
										echo "<td>" . $item['description'] . "</td>";
										echo "<td>" . $item['price'] . "</td>";
										echo "<td>" . $item['addDate'] . "</td>";
										echo "<td>" . $item['Category'] . "</td>";
										echo "<td>" . $item['Member'] . "</td>";
										echo "<td>
												<a href='?do=Edit&itemId=" . $item['itemId'] ." ' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
												<a href='?do=delete&itemId=" . $item['itemId'] . " ' class='btn btn-danger'><i class='fas fa-times'></i> Delete</a>";

												if($item['approve'] == 0){
												echo "<a href='?do=approve&itemId=" . $item['itemId'] . " ' class='approve  btn btn-info'><i class='fa fa-check'></i> Approve</a>";
												}
										echo "</td>";
									echo "</tr>";
								};
							 ?>
					</table>
				</div>
				<a href="?do=add" class="btn btn-primary confirm"><i class="fas fa-plus"></i> Add New Item</a>
			</div>	
		<?php }
			else{
				echo "<div class='container'>";
					echo "<div class='nice-message alert alert-info'>No Items Now</div>";
					echo "<a href='?do=add' class='btn btn-primary confirm'><i class='fas fa-plus'></i> Add New Item</a>";
				echo "</div>";	
			}
	}												//End Of Manage Section (Line 16)

	/***************************************************************************************************************/

	elseif($do == "add"){ ?>          				<!--Add Item-->
		<h1 class="text-center">Add New Item</h1>
		<div class="container">
			<form action="?do=insert" method="POST">

				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Name</label>
				    <div class="col-md-6 col-sm-8">
				      <input type="text" name="itemName" class="form-control" required="required" placeholder="Name Of Item">
				    </div>
				</div>

				<!--Description-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Description</label>
				    <div class="col-md-6 col-sm-8">
				      	<input type="text" name="itemDescription" class="form-control form-control-lg" autocomplete="off" placeholder="Descripe The Item">
				    </div>
				</div>

				<!--Price-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Price</label>
				    <div class="col-md-6 col-sm-8">
				      	<input type="text" name="itemPrice" class="form-control form-control-lg" autocomplete="off" placeholder="Price Of Item">
				    </div>
				</div>

				<!--Country-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Country</label>
				    <div class="col-md-6 col-sm-8">
				      	<input type="text" name="itemCountry" class="form-control form-control-lg" autocomplete="off" placeholder="Country Of Made">
				    </div>
				</div>

				<!--Status-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Status</label>
				    <div class="col-md-6 col-sm-8">
				      	<select class="form-control" name="itemStatus">
				      		<option value="0">. . .</option>
				      		<option value="1">New</option>
				      		<option value="2">Like New</option>
				      		<option value="3">Used</option>
				      		<option value="4">Old</option>
				      	</select>
				    </div>
				</div>

				<!--Member-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Member</label>
				    <div class="col-md-6 col-sm-8">
				      	<select class="form-control" name="member">
				      		<option value="0">. . .</option>
				      		<?php
				      			$stmt = $con->prepare("SELECT * FROM users WHERE groupId != 1");
				      			$stmt->execute();
				      			$users = $stmt->fetchAll();
				      			foreach ($users as $user) {
				      				echo "<option value='". $user['userId'] ."'>" . $user['userName'] . "</option>";
				      			}
				      		?>
				      	</select>
				    </div>
				</div>

				<!--Category-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Category</label>
				    <div class="col-md-6 col-sm-8">
				      	<select class="form-control" name="category">
				      		<option value="0">. . .</option>
				      		<?php
				      			$allCats = getAll("*", "categories", "WHERE parent = 0", "id");
				      			
				      			foreach ($allCats as $cat) {
				      				echo "<option value='". $cat['id'] ."'>" . $cat['name'] . "</option>";
								   	$catChild = getAll("*", "categories", "WHERE parent = {$cat['id']}", "ordering", "ASC");
								    if(! empty($catChild)){
						        		echo "<ul class='list-unstyled child-cat'>";
						        		foreach ($catChild as $child) {
						        			echo "<option value='". $child['id'] ."'>---" . $child['name'] . "</option>";
										
										}
										echo "</ul>";
									}
				      			}
				      		?>
				      	</select>
				    </div>
				</div>

				<!-- Tags -->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Tags</label>
				    <div class="col-md-6 col-sm-8">
				      	<input type="text" name="itemTags" class="form-control form-control-lg" autocomplete="off" placeholder="Sperate by , between tags">
				    </div>
				</div>

				<!--Submit-->
				<div class="form-group row">
				      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Add Item">
				</div>

			</form>
		</div>

	<?php 
	}												//End Of Add Section 
	/**************************************************************************************************************/

	elseif($do == "insert"){						//Start Of Insert Section
		
		echo "<h1 class='text-center'>Insert Item</h1>";
			echo "<div class='container'>";
		
			if($_SERVER['REQUEST_METHOD'] == "POST"){

					$name 			= $_POST['itemName'];
					$description 	= $_POST['itemDescription'];
					$price 			= $_POST['itemPrice'];
					$country		= $_POST['itemCountry'];
					$status 		= $_POST['itemStatus'];
					$member 		= $_POST['member'];
					$cat 			= $_POST['category'];
					$tags 			= $_POST['itemTags'];

					//Handeling Error 

					$formErrors = array();
					if(strlen($name)<2 || strlen($name)>25){
						$formErrors[] = "User Name Must Be <strong>Between 2 Character And 25 Character</strong>";
					}
					if($status == 0){
						$formErrors[] = "You Must Be <strong>Choose Status</strong> For This Item";
					}
					if($member == 0){
						$formErrors[] = "You Must Be <strong>Choose Member</strong> For This Item";
					}
					if($cat == 0){
						$formErrors[] = "You Must Be <strong>Choose Category</strong> For This Item";
					}

					if(empty($formErrors)){
						$stmt = $con->prepare("INSERT INTO items(name, description, price, countryMade, status, addDate, tags, member_id, cat_id)
				 						VALUES(:zname, :zdescription, :zprice, :zcountry , :zstatus, now(), :ztags, :zmember, :zcat) ");
					 	$stmt->execute(array(
					 		'zname'			=> $name,
					 		'zdescription'	=> $description,
					 		'zprice'		=> $price,
					 		'zcountry'		=> $country,
					 		'zstatus'		=> $status,
					 		'ztags'   		=> $tags,
					 		'zmember'		=> $member,
					 		'zcat'		    => $cat,
					 		
					 	));
					 	$count = $stmt->rowCount();

					 	//Redirect
					 	$msg = "<div class='alert alert-success'>" . $count . " Item Added </div>";
					 	redirect($msg, 'back'); 
 
					}
				 	else{							//If Exist Error
				 		foreach ($formErrors as $error) {
						echo "<div class='alert alert-danger'>" . $error . "</div>";
						}
				 	}								

			}										//End Of If Deliverd By Post Request
			else{ 									//If Is Not Deliverd By Post Request 

				//Redirect
				$msg = "<div class='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";
				redirect($msg);
			}
			echo "</div>";	 						//Close Tag For Container
	}												//End of Insert Section

	/**************************************************************************************************************/
	/**************************************************************************************************************/

	elseif($do == "Edit"){               			//Start Edit Page
		$itemid = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;
		$stmt = $con->prepare("SELECT * FROM items WHERE itemId=?");
		$stmt->execute(array($itemid));
		$item = $stmt->fetch();
		$count = $stmt->rowCount();

		echo "<div class='container'>";
		if($count>0){?>								<!--If Member Is Exist In Database--> 

			<h1 class="text-center">Edit Item</h1>

			<form action="?do=update" method="POST">
				
					
					<!--User Name-->
					<input type="number" name="id" hidden value="<?php echo $item['itemId'] ?>">
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Name</label>
					    <div class="col-md-6 col-sm-8">
					      <input type="text" name="itemName" class="form-control" required="required" placeholder="Name Of Item" value="<?php echo $item['name'] ?>">
					    </div>
					</div>

					<!--Description-->
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Description</label>
					    <div class="col-md-6 col-sm-8">
					      	<input type="text" name="itemDescription" class="form-control form-control-lg"        autocomplete="off" placeholder="Descripe The Item"
					      	 		value="<?php echo $item['description'] ?>">
					    </div>
					</div>

					<!--Price-->
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Price</label>
					    <div class="col-md-6 col-sm-8">
					      	<input type="text" name="itemPrice" class="form-control form-control-lg" 				autocomplete="off" placeholder="Price Of Item"
					      	 		value="<?php echo $item['price'] ?>">
					    </div>
					</div>

					<!--Country-->
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Country</label>
					    <div class="col-md-6 col-sm-8">
					      	<input type="text" name="itemCountry" class="form-control form-control-lg" 				autocomplete="off" placeholder="Country Of Made"
					      	 		value="<?php echo $item['countryMade'] ?>">
					    </div>
					</div>

					<!--Status-->
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Status</label>
					    <div class="col-md-6 col-sm-8">
					      	<select class="form-control" name="itemStatus">
					      		<option value="0">. . .</option>
					      		<option value="1" <?php if($item['status'] ==1){echo "selected";}?>>New</option>
					      		<option value="2" <?php if($item['status'] ==2){echo "selected";}?>>Like New</option>
					      		<option value="3" <?php if($item['status'] ==3){echo "selected";}?>>Used</option>
					      		<option value="4" <?php if($item['status'] ==4){echo "selected";}?>>Old</option>
					      	</select>
					    </div>
					</div>

					<!--Member-->
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Member</label>
					    <div class="col-md-6 col-sm-8">
					      	<select class="form-control" name="member">
					      		<option value="0">. . .</option>
					      		<?php
					      			$stmt = $con->prepare("SELECT * FROM users WHERE groupId != 1");
					      			$stmt->execute();
					      			$users = $stmt->fetchAll();
					      			foreach ($users as $user) {
					      				echo "<option value='". $user['userId'] ."'";
					      				if($item['member_id'] == $user['userId']){ echo 'selected'; }
					      				echo ">" . $user['userName'] . "</option>";
					      			}
					      		?>
					      	</select>
					    </div>
					</div>

					<!--Category-->
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Category</label>
					    <div class="col-md-6 col-sm-8">
					      	<select class="form-control" name="category">
					      		<option value="0">. . .</option>
					      		<?php
					      			$allCats = getAll("*", "categories", "", "id");
					      			
					      			foreach ($allCats as $cat) {
					      				echo "<option value='". $cat['id'] ."'"; 
					      				if($item['cat_id'] == $cat['id']){echo "selected";}
					      				echo">" . $cat['name'] . "</option>";

					      				
					      			}

				      			?>
					      	</select>
					    </div>
					</div>

					<!--Tags-->
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Tags</label>
					    <div class="col-md-6 col-sm-8">
					      	<input type="text" name="itemTags" class="form-control form-control-lg" 				autocomplete="off" placeholder="Sperate by , between tags"
					      	 		value="<?php echo $item['tags'] ?>">
					    </div>
					</div>
					
					<!--Submit-->
					<div class="form-group row">
					      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Edit Item">
					</div>
			</form>	

			<?php

				$stmt = $con->prepare("SELECT comments.*, users.userName As Member FROM comments
								INNER join
								users ON users.userId = comments.user_id 
								WHERE item_id = ? ORDER BY cId ");
				$stmt->execute(array($itemid));
				$rows = $stmt->fetchall();
				
				if(! empty($rows)){ ?>

				<h1 class="text-center">Manage [ <?php echo $item['name'];  ?> ] Comment</h1>
				<div class="table-responsive">
					<table class="main-table table table-bordered text-center scroll">
						<tr>
							<td>Comment</td>
							<td>Member Name</td>
							<td>Adding Date</td>
							<td>Control</td>
						</tr>
							<?php 
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['comment'] . "</td>";
										echo "<td>" . $row['Member'] . "</td>";
										echo "<td>" . $row['commentDate'] . "</td>";
										echo "<td>
												<a href='comment.php?do=Edit&comId=" . $row['cId'] ." ' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
												<a href='comment.php?do=delete&comId=" . $row['cId'] . " ' class='btn btn-danger'><i class='fas fa-times'></i> Delete</a>";
												if($row['status'] == 0){
													echo "<a href='comment.php?do=approve&comId=" . $row['cId'] ." ' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
												}

											 echo "</td>";
									echo "</tr>";
								};
							 ?>
					</table>
				<a href="?do=add" class="btn btn-primary confirm"><i class="fas fa-plus"></i> Add Comment</a>

<?PHP		}                                     	//If Rows Did Not Empty
			
			

		}											//End If This Is Exist In Database
		else{										//If This Member Is Not Exist In Database 
			//Redirect
			$msg = "<div class='alert alert-danger'> Sorry Use Another Id </div>";
			redirect($msg);
		}

	
			echo "</div>";							//Container
	}												//End Of Edit Page

	/**************************************************************************************************************/

	elseif($do == "update"){						//Start Of Update Page
			echo "<h1 class='text-center'>Update Category</h1>";
			echo "<div class='container'>";
		
			if($_SERVER['REQUEST_METHOD'] == "POST"){
					$id             = $_POST['id'];
					$name 			= $_POST['itemName'];
					$description 	= $_POST['itemDescription'];
					$price 			= $_POST['itemPrice'];
					$country		= $_POST['itemCountry'];
					$status 		= $_POST['itemStatus'];
					$tags 			= $_POST['itemTags'];
					$member 		= $_POST['member'];
					$cat 			= $_POST['category'];

					//Handeling Error 

					$formErrors = array();
					if(strlen($name)<2 || strlen($name)>25){
						$formErrors[] = "User Name Must Be <strong>Between 2 Character And 25 Character</strong>";
					}
					if($status == 0){
						$formErrors[] = "You Must Be <strong>Choose Status</strong> For This Item";
					}
					if($member == 0){
						$formErrors[] = "You Must Be <strong>Choose Member</strong> For This Item";
					}
					if($cat == 0){
						$formErrors[] = "You Must Be <strong>Choose Category</strong> For This Item";
					}

					if(empty($formErrors))
					{
						$stmt = $con->prepare("UPDATE items SET name=?, description=?, price=?, countryMade=?, status=?, tags = ?, cat_id=?, member_id=? WHERE itemId=?");
						$stmt->execute(array($name,$description,$price,$country,$status,$tags,$cat,$member,$id));
						$count = $stmt->rowCount();

						$msg = "<div class='alert alert-success'>" . $count . " Item Updated Successfuly</div>";
						redirect($msg, 'back');
					}
					else{
						foreach ($formErrors as $error) {
						echo "<div class='alert alert-danger'>" . $error . "</div>";
						}
					}
				
				
 			}											//Post Request
 			else{										//Came Without Request Post
 				$msg = "<div class='alert alert-danger'>Sorry You Cant Be Here Directly</div>";
 				redirect($msg);
 			}			
		echo "</div>";									//Close Tag For Container

	}												//End of Update Section



	/********************************************************************************************************/				
	elseif($do == "delete"){						//Start Of Delete Page
		$itemid = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;
			$check = checkItem('itemId','items',$itemid);

			echo "<h1 class='text-center'>Delete Page</h1>";
			if($check > 0){							//If This Member Is Exist In Database
				$stmt = $con->prepare("DELETE FROM items WHERE itemId = :zid");
				$stmt->bindParam(":zid", $itemid);
				$stmt->execute();
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-success'>" . $check . " Record Deleted </div>"; 
					redirect($msg,'back');
				echo "</div>";	
			}									
			else{									//If This Member Is Not Exist In Database
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-danger'> This ID Is Not Exist </div>";
					redirect($msg);
				echo "</div>";	
			}
	}												//End Of Delete Section

	/************************************************************************************************************/

	elseif($do == "approve"){						//Start Of Activate Page
		$itemid = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

		$check = checkItem('itemId','items',$itemid);

			echo "<h1 class='text-center'>Approve Item</h1>";
			if($check > 0){							//If This Member Is Exist In Database
				$stmt = $con->prepare("Update items SET approve = 1 WHERE itemId = ?");
				$stmt->execute(array($itemid));
				$stmt->execute();
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-success'>" . $check . " Item Approved </div>"; 
					redirect($msg,'back');
				echo "</div>";	
			}									
			else{									//If This Member Is Not Exist In Database
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-danger'> This ID Is Not Exist </div>";
					redirect($msg);
				echo "</div>";	
			}
	}											
	
	include $tpl . 'footer.php';

}else{ 												//If SESSION Is Not Exist
	header('Location: index.php');
	exit();
}