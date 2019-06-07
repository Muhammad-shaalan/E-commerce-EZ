<?php
	
	ini_set('display_errors','on');
	error_reporting(E_ALL);
	include "admin/connect.php";

	$sessionUser = '';

		if(isset($_SESSION['user'])){
			$sessionUser = $_SESSION['user'];
		}
	
	$tpl  = 'includes/templates/';
	$func = 'includes/functions/';
	$css  = 'layout/css/';
	$js   = 'layout/js/'; 

	$langEnglish = 'includes/languages/';

	include $func . 'func.php';
	include $langEnglish . 'english.php';
	include $tpl . 'header.php';
?>