<?PHP 

	require_once "../header.php";


	if(isset($_POST["submit"])){

		$phone = $_POST["pn"];
		$pass  = $_POST["pwd"];

		$con = new mysqli("localhost","root","girish","hack");

		$qry = sprintf("SELECT * FROM users WHERE phone='%s' AND password = '%s'",$phone,$pass);

		if($con->query($qry)){

			if(!isset($_SESSION)){
				session_start();
			}

			$_SESSION["logged_in"] = $_POST["pn"];

			header("Location:/d.php");
			exit();
			
		}else{
			echo "<h1>Error</h1>";
		}

	}

if(!isset($_SESSION)){
	session_start();
}

if(isset($_SESSION["logged_in"])){
	header("Location:/d.php");
	exit();
}

?>

	<div class="register">

			<h1 class="sp">
				Login
			</h1>
			<form method="post" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>">
				<h3 class="sp">
					and Send some credits						
				</h3>
				<div class="field">
					<input type="text" name="pn" placeholder="Phone number">
				</div>
				<div class="field">
					<input type="password" name="pwd" placeholder="**********">
				</div>
				<div class="field">
					<button type="submit" value="submit" name="submit" class="btn btn-1">
						Send 
					</button>
				</div>
			</form>

	</div>

</section>

</body>
</html>