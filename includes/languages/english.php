<?php
	function lang($phrase) {
		static $lang = array(
			"admin home"  		  => "Home",
			"admin Categories"    => "Categories",
			"Name"                => "Muhammad", 
			"Edit Profile"        => "Edit Profile",
			"Setting"             => "Setting",
			"Logout"              => "Logout",
			"Item"                => "Items",
			"Member"              => "Member",
			"comment"             => "Comment",
			"Statistics"          => "Statistics",  
			"Logs"                => "Logs",         
		);
		return $lang[$phrase];
	}