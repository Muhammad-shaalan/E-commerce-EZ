<?php
	
	$tpl  = 'includes/templates/';
	$func = 'includes/functions/';
	$css  = 'layout/css/';
	$js   = 'layout/js/'; 

	$langEnglish = 'includes/languages/';

	include $func . 'func.php';
	include $langEnglish . 'english.php';
	include $tpl . 'header.php';
	
	if(!(isset($nonavbar))){
		include $tpl . 'navbar.php';
	}

	include "connect.php";

?>