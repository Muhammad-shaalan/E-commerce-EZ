<?php
session_start();

if(isset($_SESSION['username'])){

	$pagetitle = "Edit"; 							//To Get Title Of Page
	include "init.php";

	if(isset($_GET['do'])){
		$do = $_GET['do'];
	}else{
		$do = "manage";
	}

	if($do == "manage"){ 							//Start Of Manage Section

		$query = '';
		if(isset($_GET['page']) && $_GET['page'] =='pending'){
				$query = 'AND regStatus = 0';
			}
		
			$stmt = $con->prepare("SELECT * FROM users WHERE groupid !=1 $query ORDER BY userId DESC");
			$stmt->execute();
			$rows = $stmt->fetchall();
			
			if(! empty($rows)){ ?>
			<div class="container member-pa">
				<h1 class="text-center">Manage Member</h1>
				<div class="table-responsive">
					<table class="main-table table table-bordered text-center scroll">
						<tr>
							<td>#ID</td>
							<td>MemberImage</td>
							<td>Username</td>
							<td>Email</td>
							<td>Fullname</td>
							<td>Registerd Date</td>
							<td>Control</td>
						</tr>
							<?php 
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['userId'] . "</td>";
										echo "<td>";
										 if(empty($row['images'])){
										 	echo "No Image";
										 }else{
										 	echo "<img src='upload/" . $row['images'] . "'>";
										 }
										echo "</td>";
										echo "<td>" . $row['userName'] . "</td>";
										echo "<td>" . $row['email'] . "</td>";
										echo "<td>" . $row['fullName'] . "</td>";
										echo "<td>" . $row['Date'] . "</td>";
										echo "<td>
												<a href='?do=Edit&userId=" . $row['userId'] ." ' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
												<a href='?do=delete&userId=" . $row['userId'] . " ' class='btn btn-danger'><i class='fas fa-times'></i> Delete</a>";
												if($row['regStatus'] == 0){
													echo "<a href='?do=activate&userId=" . $row['userId'] ." ' class='btn btn-info activate'><i class='fa fa-check'></i> Activate</a>";
												}
											 echo "</td>";
									echo "</tr>";
								};
							 ?>
					</table>
				</div>
				<a href="?do=add" class="btn btn-primary confirm"><i class="fas fa-plus"></i> Add New Member</a>
				

	<?php }
			else{
				echo "<div class='container'>";
					echo "<div class='nice-message alert alert-info'>No Member Now</div>";
					echo "<a href='?do=add' class='btn btn-primary confirm'><i class='fas fa-plus'></i> Add New Member</a>";
				echo "</div>";	
			}

	 }											//End Of Manage Section (Line 16)

	/***************************************************************************************************************/

	elseif($do == "add"){?>            				<!--Add Member-->
			<h1 class="text-center">Add Member</h1>           
			<form action="?do=insert" method="POST" enctype="multipart/form-data">
						<div class="container">
				
							<!--User Name-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Usr Name</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="username" name="username" class="form-control" required="required" autocomplete="off">
							    </div>
							</div>

							<!--Password-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Password</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="password" name="password" class="passwordfield form-control form-control-lg" required="required" autocomplete="newpassword">
							      <i class="fa fa-eye fa-2x show-password"></i>
							    </div>
							</div>

							<!--Email-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Email</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="Email" name="email" class="form-control form-control-lg" required="required" autocomplete="off">
							    </div>
							</div>

							<!--Full Name-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Full Name</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="username" name="full" class="form-control form-control-lg" required="required" autocomplete="off">
							    </div>
							</div>

							<!--Member Image-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Image</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="file" name="image" class="form-control form-control-lg">
							    </div>
							</div>

							<!--Submit-->
							<div class="form-group row">
							      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Add Member">
							</div>
						</div>
			</form>	
	<?php
	}												//End Of Add Section

	/**************************************************************************************************************/

	elseif($do == "insert"){						//Start Of Insert Section
			echo "<h1 class='text-center'>Insert Member</h1>";
			echo "<div class='container'>";
		
			if($_SERVER['REQUEST_METHOD'] == "POST"){

					$avatarName = $_FILES['image']['name'];
					$avatarType = $_FILES['image']['type'];
					$avatarSize = $_FILES['image']['size'];
					$avatarTmp  = $_FILES['image']['tmp_name'];

					$avatarExtensionAllowed = array("jpeg", "jpg", "png", "gif");

					$avatarExtension = strtolower(end(explode(".", $avatarName)));

					$user 		= $_POST['username'];
					$mail 		= $_POST['email'];
					$name 		= $_POST['full'];
					$pass 		= sha1($_POST['password']);
					$passinput	= $_POST['password'];

					//Handeling Error 

					 $formErrors=array();
					 if(strlen($user)<1 || strlen($user)>25){
					 	$formErrors[]="User Name Must Be <strong>Between 4 Character And 25 Character</strong>";
					 }

					 if(strlen($passinput)>1 && strlen($passinput)<6){
					 	$formErrors[]="Password Must Be <strong>More Than 5 Character</strong>";
					 }

					 if(strlen($name)<4){
					 	$formErrors[]=" Full Name Must Be <strong>More Than 4</strong>";
					 }

					 if(empty($avatarName)){
					 	$formErrors[]=" You Msut Choose <strong>Image</strong>";
					 }

					 if(! empty($avatarName) && ! in_array($avatarExtension, $avatarExtensionAllowed)){
					 	$formErrors[]=" This Extension Is <strong>Blocked</strong>";
					 }

					 if($avatarSize > 4194304){
					 	$formErrors[]=" You Picture Must be Less Than <strong>4 Mega</strong>";
					 }


					 foreach ($formErrors as $error) {
					 	echo "<div class='alert alert-danger'>" . $error . "</div>";
					 }


					  if(empty($formErrors)){

					  	$avatar = rand(0, 10000000000) . '_' . $avatarName;
					  	move_uploaded_file($avatarTmp, "upload\\" . $avatar);

					  	$checkResult = checkItem("userName","users",$user);

					  	if($checkResult == 1){		//Check If This User Name Is Exist

					  		//Redirect
					  		$msg = "<div class='alert alert-danger'> Sorry This User Name Exist </div>";
						  	redirect($msg, 'back'); 
					  	}
					  	else{
					  		$stmt = $con->prepare("INSERT INTO users(userName, password, email, fullName, regStatus, Date, images)
					  						VALUES(:zuser, :zpassword, :zemail, :zfull , 1, now(), :zimage) ");
						  	$stmt->execute(array(
						  		'zuser'		=> $user,
						  		'zpassword'	=> $pass,
						  		'zemail'	=> $mail,
						  		'zfull'		=> $name,
						  		'zimage'	=> $avatar
						  	));
						  	$count = $stmt->rowCount();

						  	//Redirect
						  	$msg = "<div class='alert alert-success'>" . $count . " Member Added</div>";
						  	redirect($msg, 'back'); 
					  	}							//End Of User Name Is Exist Section

					  }								//End If Theres No Error 
				}									//End Of If Deliverd By Post Request
				 else{ 								//If Is Not Deliverd By Post Request

				 	//Redirect
				 	$msg = "<div class='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";
				 	redirect($msg);
				 }
			echo "</div>";	 						//Close Tag For Container
	}												//End of Insert Section (Line 108)

	/**************************************************************************************************************/
	/**************************************************************************************************************/

	elseif($do == "Edit"){               			//Start Edit Page
			$userid = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
			$stmt = $con->prepare("SELECT * FROM users WHERE userId=?");
			$stmt->execute(array($userid));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			if($count>0){?>							<!--If Member Is Exist In Database--> 

					<h1 class="text-center">Edit Member</h1>

					<form action="?do=update" method="POST">
						<div class="container">
							
							<!--User Name-->
							<input type="number" name="id" hidden value="<?php echo $row['userId'] ?>">
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Usr Name</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="username" name="username" class="form-control form-control-lg" value="<?php echo $row['userName'] ?>" required="required" autocomplete="off">
							    </div>
							</div>

							<!--Password-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Password</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="password" name="oldpassword" hidden value="<?php echo $row['password'] ?>">
							      <input type="password" name="newpassword" class="form-control form-control-lg" placeholder="You Can Leave It Empty" autocomplete="newpassword"> 
							    </div>
							</div>

							<!--Email-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg">Email</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="Email" name="email" class="form-control form-control-lg" value="<?php echo $row['email'] ?>" required="required" autocomplete="off">
							    </div>
							</div>

							<!--Full Name-->
							<div class="form-group row">
							    <label class="col-md-2 col-sm-4 col-form-label-lg" requried="requried">Full Name</label>
							    <div class="col-md-6 col-sm-8">
							      <input type="username" name="full" class="form-control form-control-lg" value="<?php echo $row['fullName'] ?>" required="required" autocomplete="off">
							    </div>
							</div>

							<!--Submit-->
							<div class="form-group row">
							      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Edit">
							</div>
						</div>
					</form>	
					<?php
				}									//End If This Is Exist In Database 
				else{								//If This Member Is Not Exist In Database 
						//Redirect
						echo "<div class='container'>";
							$msg = "<div class='alert alert-danger'> Sorry Use Another Id </div>";
							redirect($msg);
						echo "</div>";	
				}
	}												//End Of Edit Page

	/**************************************************************************************************************/

	elseif($do == "update"){						//Start Of Update Page
			echo "<h1 class='text-center'>Update Member</h1>";
			echo "<div class='container'>";
		
			if($_SERVER['REQUEST_METHOD'] == "POST"){

					$id 	= $_POST['id'];
					$user 	= $_POST['username'];
					$mail 	= $_POST['email'];
					$name 	= $_POST['full'];
					$passinput = $_POST['newpassword'];
					$pass = "";

					if(empty($_POST['newpassword'])){
						$pass = $_POST['oldpassword'];
					}else{
						$pass = Sha1($_POST['newpassword']);
					}

					//Handeling Error 

					$formErrors=array();
					if(strlen($user)<4 || strlen($user)>25){
						$formErrors[]="User Name Must Be <strong>Between 4 Character And 25 Character</strong>";
					}

					if(strlen($passinput)>1 && strlen($passinput)<6){
						$formErrors[]="Password Must Be <strong>More Than 5 Character</strong>";
					}

					if(strlen($name)<4){
						$formErrors[]=" Full Name Must Be <strong>More Than 4 Character</strong>";
					}


					foreach ($formErrors as $error) {
						echo "<div class='alert alert-danger'>" . $error . "</div>";
					}


					if(empty($formErrors)){

						$stmt2 = $con->prepare("SELECT * FROM users WHERE userName=? AND userId!=?");
						$stmt2->execute(array($user,$id));
						$count = $stmt2->rowCount();

						if($count == 1){	

							//Redirect		
							$msg = "<div class='alert alert-danger'> Sorry This User Name Is Exist </div>";
							redirect($msg,'back');

						}							//Check If This User Name Is Exist
						else{
							$stmt = $con->prepare("UPDATE users SET userName=?, email=?, fullName=?, password=? WHERE userId=?");
							$stmt->execute(array($user,$mail,$name, $pass, $id));
							$count = $stmt->rowCount();                                                          
							
							//Redirect
							$msg = "<div class='alert alert-success'>" . $count . " Member Updated</div>"; 
							redirect($msg,'back');
						}
						
					}								//End If Theres No Error (Line 276)
					else{							//If Have Error
						$msg = "";
						redirect($msg,'back');
					}

			}										//End If He Deliverd From Request Post (Line 240)

			else{ 									//If Is Not Deliverd By Post Request
				$msg = "<div class='alert alert-danger'> Sorry You Can Not Browse This Page Directly </div>";
				redirect($msg);
				}	
			echo "</div>";	 						//Close Tag For Container
	}												//End Of Upadate Page (Line 236)

	/********************************************************************************************************/				
	elseif($do == "delete"){						//Start Of Delete Page

			$userid = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
			$check = checkItem('userId','users',$userid);

			echo "<h1 class='text-center'>Delete Page</h1>";
			if($check > 0){							//If This Member Is Exist In Database
				$stmt = $con->prepare("DELETE FROM users WHERE userId = :zuser");
				$stmt->bindParam(":zuser", $userid);
				$stmt->execute();
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-success'>" . $check . " Member Deleted </div>"; 
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
	}												//End Of Delete Section (Line 301)

	/************************************************************************************************************/

	elseif($do == "activate"){						//Start Of Activate Page

			$userid = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
			$check = checkItem('userId','users',$userid);

			echo "<h1 class='text-center'>Activate Page</h1>";
			if($check > 0){							//If This Member Is Exist In Database
				$stmt = $con->prepare("Update users SET regStatus = 1 WHERE userId = ?");
				$stmt->execute(array($userid));
				$stmt->execute();
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-success'>" . $check . " Member Activated </div>"; 
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
	}												//End Of Activate Page											
	
	include $tpl . 'footer.php';

}else{ 												//If SESSION Is Not Exist
	header('Location: index.php');
	exit();
}