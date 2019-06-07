<?php 
	 session_start();
	 
	 $pagetitle = "Login"; //To Get Page Title

	   if(isset($_SESSION['user'])){
	   	header('Location: index.php');
	   }
	
	include "init.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['login'])){
		$user     = $_POST['username'];
		$pass     = $_POST['password'];
		$hashpass = sha1($pass);

		$stmt = $con->prepare("SELECT 
									userName,password,userId 
								FROM 
									users 
								WHERE 
									userName = ? AND password = ?");
		$stmt->execute(array($user,$hashpass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		

		if($count > 0){
			$_SESSION['user'] = $user;
			$_SESSION['uid']  = $row['userId'];
			header('Location: index.php');
			exit();
		}
	}												//End If It From Login Form
	else{											//If It From Signup Form


		$username 	= $_POST['username'];
		$password 	= $_POST['password'];
		$password2 	= $_POST['password2'];
		$email 		= $_POST['mail'];

		$formErrors = array();

		if(isset($username)){
			$filteredUser = filter_var($username, FILTER_SANITIZE_STRING);
			if(strlen($filteredUser) < 4){
				$formErrors[] = "Your Username Must Be More Than 4 Char";
			}
		}

		if(isset($password) && isset($_POST['password2'])){
			$pass 	= sha1($password);
			$pass2 	= sha1($password2);
			if(strlen($password) < 6 || strlen($password2) < 6){
				$formErrors[] = "Your Password Must Be More Than 5 Char";
			}
			if($pass !== $pass2){
				$formErrors[] = "Password Is Not Matched";
			}
		}

		if(isset($email)){
			$filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
			if(filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true){
				$formErrors[] = "This Email Is Not Valid";
			}
		}

		if(empty($formErrors)){
			$check = checkUser('userName', 'users', $username);
			if($check == 1){
				$formErrors[] = "Sorry This User Name Is Exist";
			}else{
				$stmt = $con->prepare("INSERT INTO users(userName, password, email, regStatus, Date)
				 						VALUES(:zname, :zpassword, :zemail, 0, now()) ");
					 	$stmt->execute(array(
					 		'zname'			=> $username,
					 		'zpassword'		=> $pass,
					 		'zemail'		=> $email,
					 	));
					 	$count = $stmt->rowCount();

					 	$successMsg = "Congratz You Are Added";
			}
		}											//If No Error In Form

		

		
	}												//End If It From Signup Form
}													//End Of It From Post Request

?>
<div class="container loginPage">
	<h1 class="text-center">
	   <span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span>
	</h1>

	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input type="text" name="username" placeholder="Type Your Username" class="form-control" required>
		</div>
		<div class="input-container">
			<input type="password" name="password" placeholder="Type Your Password" class="form-control" required>
		</div>	
		<input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
	</form>

	<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input type="text" name="username" placeholder="Type Your Username" class="form-control"
			pattern=".{4,}" title="Must Be More Than 4" required>
		</div>
		<div class="input-container">
			<input type="password" name="password" placeholder="Type Your Password" class="form-control"
			minlength="6" required>
		</div>	
		<div class="input-container">
			<input type="password" name="password2" placeholder="Type Your Password Again" class="form-control" minlength="6" required>
		</div>
		<div class="input-container">
			<input type="email" name="mail" placeholder="Type Your Email" class="form-control" required>
		</div>	
		<input type="submit" name="signup" class="btn btn-success btn-block" value="Signup">
	</form>

	<div class="the-errors">
		<?php 
		if(! empty($formErrors)){
			foreach ($formErrors as $error) {
				echo "<div class='msg error'>" . $error . "</div>";
			}
		}

		if(isset($successMsg)){
			echo "<div class='msg successMsg'>" . $successMsg . "</div>";
		}
		?>
	</div>	
</div>


<?php

include $tpl . 'footer.php';