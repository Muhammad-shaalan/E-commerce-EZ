<?php

function getTitle(){
	global $pagetitle;
	if(isset($pagetitle)){
    	echo $pagetitle;
	}else{
		echo "Default";
	}
}

/*******************************************/
function getAll($items, $table, $where = NULL, $orderField, $order = "DESC"){
	global $con;
	$getAll = $con->prepare("SELECT $items FROM $table $where ORDER BY $orderField $order");
	$getAll->execute();
	$all = $getAll->fetchAll();
	return $all;
}

//Get Comment
function getCom($where , $value){
	global $con;
	$getComm = $con->prepare("SELECT comments.*,items.name As Item FROM comments
								INNER JOIN items ON items.itemId = comments.item_id

								 WHERE $where = ?");
	$getComm->execute(array($value));
	$comments = $getComm->fetchall();
	return $comments;
}

// //Check If Is Activate Or Not
// function checkRegStatus($user){
// 	global $con;
// 	$stmt = $con->prepare("SELECT userName,regStatus FROM users WHERE userName = ? AND regStatus=0");
// 	$stmt->execute(array($user));
// 	$status = $stmt->rowCount();
// 	return $status;
// }

 //Check If User Exist In Database Or Not
 function checkUser($select, $from, $value){
 	global $con;
 	$statement = $con->prepare("SELECT $select From $from WHERE $select = ?");
 	$statement->execute(array($value));
 	$count = $statement->rowCount();
 	return $count;
 }

/****************************************************************/


/*Function To Redirect Page*/
function redirect($Msg, $url = null, $second = 2){
	if($url === null){
		$url = 'index.php';
		$link = "Home Page";
	}else{

		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){
			$url = $_SERVER['HTTP_REFERER'];
			$link = "Previous Page";	
		}else{
			$url = 'index.php';
			$link = "Home Page";
		}
	 	
	 }
	echo $Msg;
	echo "<div class='alert alert-success'>You Will Redirect To $link After $second Second</div>";
	header("refresh:$second;url=$url");
	exit();
}

/*Function To Chek If Item Exist In Database*/
function checkItem($select, $from, $value){
	global $con;
	$statement = $con->prepare("SELECT $select From $from WHERE $select = ?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count;
}


/*Function Count From Database*/

function countmember($select,$from){
	global $con;
	$stmt2=$con->prepare("SELECT COUNT($select) FROM $from");
	$stmt2->execute();
	$count = $stmt2->fetchColumn();
	return $count;
}



/*Function Show Latest 5 Member*/

function theLatest($select, $from, $order, $limit = 5){
	global $con;
	$stmt3 = $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
	$stmt3->execute();
	$rows = $stmt3->fetchall();
	return $rows;
}








