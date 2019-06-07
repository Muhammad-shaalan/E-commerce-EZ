<?php
	
	$dsn      = 'mysql:host=localhost;dbname=shop';
	$user     = 'root';
	$password = '';
	//  $option   = array(
	//  	PDO::MYSQL_ATTR_INIT__COMMAND => 'SET NAMES UTF8',
	//  );

	try{
		$con = new PDO($dsn, $user, $password);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo "Faild" . $e->getMessage();
	}