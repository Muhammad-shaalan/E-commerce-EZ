<?php 
	 session_start();
	 
	 $nonavbar = ""; //To Hide Navbar In This Page
	 $pagetitle = "Login"; //To Get Page Title

	   if(isset($_SESSION['username'])){
	   	header('Location: prof.php');
	   }
	
	include "init.php";

   	include $tpl . 'header.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$user     = $_POST['username'];
	$pass     = $_POST['password'];
	$hashpass = sha1($pass);

	$stmt = $con->prepare("SELECT 
								userName,password,userId 
							FROM 
								users 
							WHERE 
								userName = ? AND password = ? AND groupId = 1");
	$stmt->execute(array($user,$hashpass));
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	

	if($count > 0){
		$_SESSION['username'] = $user;
		$_SESSION['id'] = $row['userId'];
		header('Location: prof.php');
		exit();
	}else{
	}
}
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	<h3 class="text-center">Admin Login</h3>
	<input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off">
	<input class="form-control" type="password" name="password" placeholder="Password" autocomplete="password">
	<button class="btn btn-primary btn-block">Login</button>
</form>

<?php include $tpl . 'footer.php';?>