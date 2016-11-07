<?PHP 
	
	if(isset($_SESSION["logged_in"])){
		unset($_SESSION["logged_in"]);
	}

	header("Location:/");
	exit();

?>