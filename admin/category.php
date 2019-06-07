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

			$sort = 'ASC';
			$sort_array = array('asc', 'desc');

			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
				$sort = $_GET['sort'];
			}

			$cats = getall("*", "categories", "WHERE parent = 0", "ordering", $sort);

			if(! empty($cats)){
			?>

			<div class="container category-pa">
				<h1 class="text-center">Manage Category</h1>
				<div class="card">
					<div class="card-header"><i class="fa fa-edit"></i> Manage Categories
						<div class="pull-right option">
							<i class="fa fa-sort"></i> Ordering: [
							<a href="?sort=asc" class="<?php if($sort == asc){echo "active";}?>">Asc</a>   |
							<a href="?sort=desc" class="<?php if($sort == desc){echo "active";}?>">Desc</a>
							]
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full">Full</span>   |
							<span class="" data-view="classic">Classic</span>
							]
						</div>
					</div>
					<div class="card-body category">
					    <?php foreach ($cats as $cat){?>
					    	<div class="cat">
					    		<div class="btn-hidden">
					    			<a href='?do=edit&catId=<?php echo $cat['id'];?>' class='btn btn-primary'><i class='fa fa-edit'></i> Edit</a>
					    			<a href='?do=delete&catId=<?php echo $cat['id'];?>' class="btn btn-danger"><i class="fas fa-times"></i> Delete</a>
					    		</div>
						    	<h3 class="card-title"> <?php echo $cat['name']?> </h3>
						    	<div class="full-view">
								    <p class="card-text">
									    <?php if($cat['description'] == '') echo "No Description";
									    else{
									    	echo $cat['description'];
									    }?>
								    </p>
								    <?php if($cat['visibility'] == 1){ echo "<span class='visible'><i class='fa fa-eye'></i> Hidden</span>";} ?>
								    <?php if($cat['allow_comment'] == 1){ echo "<span class='comment'><i class='fas fa-times'></i> Comment Disabled</span>";}?>
								    <?php if($cat['allow_ads'] == 1){ echo "<span class='ads'><i class='fas fa-times'></i> Ads Disabled</span>";} ?>
								</div>

								<?php
								   $catParent = getAll("*", "categories", "WHERE parent = {$cat['id']}", "ordering", "ASC");
								    if(! empty($catParent)){
								    	echo "<h4 class='child-head'>Child Category</h4>";
						        		echo "<ul class='list-unstyled child-cat'>";
						        		foreach ($catParent as $parent) {
						        			
										echo "<li>";
												echo "<a href='?do=edit&catId=" . $parent['id'] . "' >" . $parent['name'] . " </a>"; 
												echo "<a href='?do=delete&catId=" . $parent['id'] ."' class='show'>Delete</a>";
										echo "</li>";
										}
										echo "</ul>";
									}
								?>

							</div> 
							<hr>
						<?php }?>
					</div>
				</div>
				<a href="?do=add" class="btn btn-primary confirm"><i class="fas fa-plus"></i>Add New Category</a>
			</div>
			
			<?php }
			else{
				echo "<div class='container'>";
					echo "<div class='nice-message alert alert-info'>No Category Now</div>";
					echo "<a href='?do=add' class='btn btn-primary confirm'><i class='fas fa-plus'></i> Add New Category</a>";
				echo "</div>";	
			}
		 }											//End Of Manage Section (Line 16)

	/***************************************************************************************************************/

	elseif($do == "add"){ ?>          				<!--Add Member-->
		
		<div class="container">
			<h1 class="text-center">Add New Categorey</h1>
			<form action="?do=insert" method="POST">

				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Name</label>
				    <div class="col-md-6 col-sm-8">
				      <input type="text" name="name" class="form-control" required="required" autocomplete="off" placeholder="Name Of Category">
				    </div>
				</div>

				<!--Description-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Description</label>
				    <div class="col-md-6 col-sm-8">
				      	<input type="text" name="description" class="form-control form-control-lg" autocomplete="off" placeholder="Descripe The Category">
				    </div>
				</div>

				<!--Ordering-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Ordering</label>
				    <div class="col-md-6 col-sm-8">
				      	<input type="text" name="ordering" class="form-control form-control-lg" autocomplete="off" placeholder="Number To Arrange Of Categories">
				    </div>
				</div>

				<!--Parent-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Parent?</label>
				    <div class="col-md-6 col-sm-8">
				      	<select class="form-control" name="parent">
				      		<option value="0">Noone</option>
				      		<?php
				      			$catParent = getAll("*", "categories", "WHERE parent = 0", "id");
				      			foreach ($catParent as $parent) {
				      				echo "<option value='". $parent['id'] ."'>" . $parent['name'] . "</option>";
				      			}
				      		?>
				      	</select>
				    </div>
				</div>

				<!--Visiblity-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Visible</label>
				    <div class="col-md-6 col-sm-8">
				    	<div>
						    <input id="vis-yes" type="radio" name="visibility" value="0" checked>
						    <label for="vis-yes">Yes</label>
						</div> 
						<div>
						    <input id="vis-no" type="radio" name="visibility" value="1">
						    <label for="vis-no">No</label>
						</div>    
				    </div>
				</div>

				<!--Comment-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Allow Comment</label>
				    <div class="col-md-6 col-sm-8">
				    	<div>
						    <input id="com-yes" type="radio" name="comment" value="0" checked>
						    <label for="com-yes">Yes</label>
						</div>    
						<div>
						    <input id="com-no" type="radio" name="comment" value="1">
						    <label for="com-no">No</label>
						</div>    
				    </div>
				</div>

				<!--Visiblity-->
				<div class="form-group row">
				    <label class="col-md-2 col-sm-4 col-form-label-lg">Allow Ads</label>
				    <div class="col-md-6 col-sm-8">
				    	<div>
						    <input id="ads-yes" type="radio" name="ads" value="0" checked>
						    <label for="ads-yes">Yes</label>
						</div>  
						<div>
						    <input id="ads-no" type="radio" name="ads" value="1">
						    <label for="ads-no">No</label>
						</div>    
				    </div>
				</div>

				<!--Submit-->
				<div class="form-group row">
				      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Add Category">
				</div>

			</form>
		</div>

	<?php 
	}												//End Of Add Section 
	/**************************************************************************************************************/

	elseif($do == "insert"){						//Start Of Insert Section
		echo "<div class='container'>";
			echo "<h1 class='text-center'>Insert Category</h1>";

			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$name 	= $_POST['name'];
				$desc 	= $_POST['description'];
				$order 	= $_POST['ordering'];
				$parent = $_POST['parent'];
				$vis 	= $_POST['visibility'];
				$com 	= $_POST['comment'];
				$ads 	= $_POST['ads'];

				if(strlen($name) < 3){
				    $msg = "<div class='alert alert-danger'>Name Must be <strong>More Than 3 Character</strong></div>";
					redirect($msg,'back');
				}
				else
				{
						$check = checkItem('name', 'categories', $name);
						if($check > 0){
							$msg = "<div class='alert alert-danger'>This Category Is Exist Already</div>";
							redirect($msg, 'back');
						}
						else{
							$stmt = $con->prepare("INSERT INTO categories(name, description, ordering, parent, visibility, 									allow_comment, allow_ads)
											VALUES(:zname,:zdesc,:zorder, :zparent, :zvis,:zcom,:zads)");
							$stmt->execute(array(
								'zname' 	=> $name,
								'zdesc' 	=> $desc,
								'zorder' 	=> $order,
								'zparent'	=>$parent,
								'zvis' 		=> $vis,
								'zcom'	 	=> $com,
								'zads' 		=> $ads
							));
							$count = $stmt->rowCount();

							$msg = "<div class='alert alert-success'>". $count ." Category Added Successfuly</div>";
							redirect($msg, 'back');
						}
				}										//End If Empty Error
				
 			}											//Post Request
 			else{										//Came Without Request Post
 				$msg = "<div class='alert alert-danger'>Sorry You Cant Be Here Directly</div>";
 				redirect($msg);
 			}			
		echo "</div>";									//Close Tag For Container

	}													//End of Insert Section

	/**************************************************************************************************************/
	/**************************************************************************************************************/

	elseif($do == "edit"){               			//Start Edit Page

			$catid = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;

			$stmt = $con->prepare("SELECT * FROM categories WHERE id=?");
			$stmt->execute(array($catid));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();
			echo"<div class='container'>";

			if($count > 0){?>
					<h1 class="text-center">Edit Category</h1>
					<form action="?do=update" method="POST">

						<input type="number" name="id" hidden value="<?php echo $row['id'] ?>">
						<div class="form-group row">
						    <label class="col-md-2 col-sm-4 col-form-label-lg">Name</label>
						    <div class="col-md-6 col-sm-8">
						      <input type="text" name="name" class="form-control" required="required" autocomplete="off" placeholder="Name Of Category" value="<?php echo $row['name'] ?>">
						    </div>
						</div>

						<!--Description-->
						<div class="form-group row">
						    <label class="col-md-2 col-sm-4 col-form-label-lg">Description</label>
						    <div class="col-md-6 col-sm-8">
						      	<input type="text" name="description" class="form-control form-control-lg" autocomplete="off" placeholder="Descripe The Category" value="<?php 
						      	echo $row['description'];?>">
						    </div>
						</div>

						<!--Ordering-->
						<div class="form-group row">
						    <label class="col-md-2 col-sm-4 col-form-label-lg">Ordering</label>
						    <div class="col-md-6 col-sm-8">
						      	<input type="text" name="ordering" class="form-control form-control-lg" autocomplete="off" placeholder="Number To Arrange Of Categories" value="<?php 
						      	echo $row['ordering'];?>">
						    </div>
						</div>

						<!-- Parent -->
						<div class="form-group row">
						    <label class="col-md-2 col-sm-4 col-form-label-lg">Parent?</label>
						    <div class="col-md-6 col-sm-8">
						      	<select class="form-control" name="parent">
						      		<option value="0">Noone</option>
						      		<?php
						      			$catParent = getAll("*", "categories", "WHERE parent = 0", "id");
						      			foreach ($catParent as $parent) {
						      				echo "<option value='". $parent['id'] ."'";
						      				if($row['parent'] == $parent['id']){echo 'selected';}
						      				echo ">" . $parent['name'] . "</option>";
						      			}
						      		?>
						      	</select>
						    </div>
						</div>

						<!--Visiblity-->
						<div class="form-group row">
						    <label class="col-md-2 col-sm-4 col-form-label-lg">Visible</label>
						    <div class="col-md-6 col-sm-8">
						    	<div>
								    <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($row['visibility'] == 0){echo "checked";}?>>
								    <label for="vis-yes">Yes</label>
								</div> 
								<div>
								    <input id="vis-no" type="radio" name="visibility" value="1" <?php if($row['visibility'] == 1){echo "checked";}?>>
								    <label for="vis-no">No</label>
								</div>    
						    </div>
						</div>

						<!--Comment-->
						<div class="form-group row">
						    <label class="col-md-2 col-sm-4 col-form-label-lg">Allow Comment</label>
						    <div class="col-md-6 col-sm-8">
						    	<div>
								    <input id="com-yes" type="radio" name="comment" value="0" <?php if($row['allow_comment'] == 0){echo "checked";}?>>
								    <label for="com-yes">Yes</label>
								</div>    
								<div>
								    <input id="com-no" type="radio" name="comment" value="1" <?php if($row['allow_comment'] == 1){echo "checked";}?>>
								    <label for="com-no">No</label>
								</div>    
						    </div>
						</div>

						<!--Advertise-->
						<div class="form-group row">
						    <label class="col-md-2 col-sm-4 col-form-label-lg">Allow Ads</label>
						    <div class="col-md-6 col-sm-8">
						    	<div>
								    <input id="ads-yes" type="radio" name="ads" value="0" <?php if($row['allow_ads'] == 0){echo "checked";}?>>
								    <label for="ads-yes">Yes</label>
								</div>  
								<div>
								    <input id="ads-no" type="radio" name="ads" value="1" <?php if($row['allow_ads'] == 1){echo "checked";}?>>
								    <label for="ads-no">No</label>
								</div>    
						    </div>
						</div>

						<!--Submit-->
						<div class="form-group row">
						      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Edit Category">
						</div>

					</form>
				
				<?php
			}										//End If This ID Is Exist
			else{
				$msg = "<div class='alert alert-danger'> Sorry This ID Is Not Exist.</div>";
				redirect($msg);
			}	
			echo "</div>";							//Close Container Tag
	}												//End Of Edit Page 

	/**************************************************************************************************************/

	elseif($do == "update"){						//Start Of Update Page
			echo "<h1 class='text-center'>Update Category</h1>";
			echo "<div class='container'>";
		
			if($_SERVER['REQUEST_METHOD'] == "POST"){
				$id 	= $_POST['id'];
				$name 	= $_POST['name'];
				$desc 	= $_POST['description'];
				$order 	= $_POST['ordering'];
				$parent = $_POST['parent'];
				$vis 	= $_POST['visibility'];
				$com 	= $_POST['comment'];
				$ads 	= $_POST['ads'];

				if(strlen($name) < 3){
				    $msg = "<div class='alert alert-danger'>Name Must be <strong>More Than 3 Character</strong></div>";
					redirect($msg,'back');
				}
				else
				{
					$stmt = $con->prepare("UPDATE categories SET name=?, description=?, ordering=?, parent = ?, visibility=?, 									allow_comment=?, allow_ads=? WHERE id=?");
					$stmt->execute(array($name,$desc,$order,$parent,$vis,$com,$ads,$id));
					$count = $stmt->rowCount();

					$msg = "<div class='alert alert-success'>" . $count . " Category Updated Successfuly</div>";
					redirect($msg, 'back');
				}
				
				
 			}											//Post Request
 			else{										//Came Without Request Post
 				$msg = "<div class='alert alert-danger'>Sorry You Cant Be Here Directly</div>";
 				redirect($msg);
 			}			
		echo "</div>";									//Close Tag For Container

	}												//End of Insert Section


	/********************************************************************************************************/				
	elseif($do == "delete"){						//Start Of Delete Page
			$catid = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;
			$check = checkItem('id','categories',$catid);

			echo "<h1 class='text-center'>Delete Page</h1>";
			if($check > 0){							//If This Member Is Exist In Database
				$stmt = $con->prepare("DELETE FROM categories WHERE id = :zid");
				$stmt->bindParam(":zid", $catid);
				$stmt->execute();
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-success'>" . $check . " Category Deleted </div>"; 
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

	include $tpl . 'footer.php';

}else{ 												//If SESSION Is Not Exist
	header('Location: index.php');
	exit();
}