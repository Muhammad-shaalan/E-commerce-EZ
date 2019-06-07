<?php
session_start();

if(isset($_SESSION['username'])){

	$pagetitle = "Edit"; 							//To Get Title Of Page
	include "init.php";
	include $tpl . 'header.php';

	if(isset($_GET['do'])){
		$do = $_GET['do'];
	}else{
		$do = "manage";
	}

	if($do == "manage"){ 							//Start Of Manage Section

		
			$stmt = $con->prepare("SELECT comments.*, items.name As Item,  users.userName As Member FROM comments 
								INNER JOIN 					
								items ON items.itemId = comments.item_id
								INNER join
								users ON users.userId = comments.user_id ORDER BY cId DESC
								");
			$stmt->execute();
			$rows = $stmt->fetchall();

			if(! empty($rows)){
			?>
			
			<div class="container">
				<h1 class="text-center">Manage Comment</h1>
				<div class="table-responsive">
					<table class="main-table table table-bordered text-center scroll">
						<tr>
							<td>#ID</td>
							<td>Comment</td>
							<td>Item</td>
							<td>Member Name</td>
							<td>Adding Date</td>
							<td>Control</td>
						</tr>
							<?php 
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['cId'] . "</td>";
										echo "<td>" . $row['comment'] . "</td>";
										echo "<td>" . $row['Item'] . "</td>";
										echo "<td>" . $row['Member'] . "</td>";
										echo "<td>" . $row['commentDate'] . "</td>";
										echo "<td>
												<a href='?do=Edit&comId=" . $row['cId'] ." ' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
												<a href='?do=delete&comId=" . $row['cId'] . " ' class='btn btn-danger'><i class='fas fa-times'></i> Delete</a>";
												if($row['status'] == 0){
													echo "<a href='?do=approve&comId=" . $row['cId'] ." ' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
												}

											 echo "</td>";
									echo "</tr>";
								};
							 ?>
					</table>
				</div>
				<a href="?do=add" class="btn btn-primary confirm"><i class="fas fa-plus"></i> Add Comment</a>
			</div>	
			<?php }
			else{
				echo "<div class='container'>";
					echo "<div class='nice-message alert alert-info'>No Comment Now</div>";
				echo "</div>";	
			}
 		}											//End Of Manage Section (Line 16)

	/***************************************************************************************************************/
	/***************************************************************************************************************/
	elseif($do == "Edit"){               			//Start Edit Page
		$comid = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
		$stmt = $con->prepare("SELECT * FROM comments WHERE cId=?");
		$stmt->execute(array($comid));
		$comm = $stmt->fetch();
		$count = $stmt->rowCount();

		echo "<div class='container'>";
		if($count>0){?>								<!--If Member Is Exist In Database--> 

			<h1 class="text-center">Edit Comment</h1>

			<form action="?do=update" method="POST">
				
					
					<!--User Name-->
					<input type="number" name="id" hidden value="<?php echo $comm['cId'] ?>">
					<div class="form-group row">
					    <label class="col-md-2 col-sm-4 col-form-label-lg">Comment</label>
					    <div class="col-md-6 col-sm-8">
					      <input type="text" name="comment" class="form-control" required="required" placeholder="Edit Your Comment" value="<?php echo $comm['comment'] ?>">
					    </div>
					</div>

					
					
					<!--Submit-->
					<div class="form-group row">
					      <input type="submit" class="col-md-2 btn btn-primary btn-lg" value="Save">
					</div>
			</form>	
			<?php
		}											//End If This Is Exist In Database
		else{										//If This Member Is Not Exist In Database 
			//Redirect
			$msg = "<div class='alert alert-danger'> Sorry This Id Is Not Exist </div>";
			redirect($msg);
		}
			echo "</div>";							//Container
	}												//End Of Edit Page

	/**************************************************************************************************************/

	elseif($do == "update"){						//Start Of Update Page
			echo "<h1 class='text-center'>Update Comment</h1>";
			echo "<div class='container'>";
		
			if($_SERVER['REQUEST_METHOD'] == "POST"){
					$id             = $_POST['id'];
					$comment 		= $_POST['comment'];
					
					//Handeling Error 

					$formErrors = array();
					if(strlen($comment)<=0){
						$formErrors[] = "You Must Be <strong>Write A Comment</strong>";
					}

					if(empty($formErrors))
					{
						$stmt = $con->prepare("UPDATE comments SET comment=? WHERE cId=?");
						$stmt->execute(array($comment,$id));
						$count = $stmt->rowCount();

						$msg = "<div class='alert alert-success'>" . $count . " Comment Updated Successfuly</div>";
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

	}												//End of Insert Section



	/********************************************************************************************************/				
	elseif($do == "delete"){						//Start Of Delete Page
		$comid = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
			$check = checkItem('cId','comments',$comid);

			echo "<h1 class='text-center'>Delete Page</h1>";
			if($check > 0){							//If This Member Is Exist In Database
				$stmt = $con->prepare("DELETE FROM comments WHERE cId = :zid");
				$stmt->bindParam(":zid", $comid);
				$stmt->execute();
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-success'>" . $check . " Comment Deleted </div>"; 
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

			$comid = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
			$check = checkItem('cId','comments',$comid);

			echo "<h1 class='text-center'>Approve Comment</h1>";
			if($check > 0){							//If This Member Is Exist In Database
				$stmt = $con->prepare("Update comments SET status = 1 WHERE cId = ?");
				$stmt->execute(array($comid));
				$stmt->execute();
				//Redirect
				echo "<div class='container'>";
					$msg = "<div class='alert alert-success'>" . $check . " Comment Approved </div>"; 
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