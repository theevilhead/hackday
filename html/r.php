<?PHP 

	// error_reporting(E_ALL);
	

	require_once "../app/app.php";
	require_once "../header.php";

	$app = new app;

	if(isset($_POST["submit"])){
	
		$res = $app->new_user();

		if($res!=false){

			if(!isset($_SESSION)){
				session_start();
			}

			$_SESSION["logged_in"] = $_POST["pn"];

			header("Location:/d.php");
			exit();

		}else{
			$msg = "Please enter valid field values";
		}

	}



?>

	<div class="register">

			<h1 class="sp">
				Register
			</h1>
			<form method="post" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>">
				<h3 class="sp">
					and Send some credits						
				</h3>
				<div class="field">
					<input type="text" name="nm" placeholder="Name">
				</div>
				<div class="field">
					<input type="text" name="pn" placeholder="Phone number">
				</div>
				<div class="field">
					<input type="text" name="aad" placeholder="Aadhar card">
				</div>
				<div class="field">
					<input type="password" name="pwd" placeholder="**********">
				</div>
				<div class="field">
					<button type="submit" value="submit" name="submit" class="btn btn-1">
						Send 
					</button>
				</div>
				<?PHP 
					if(isset($msg)){
						echo $msg;
					}
				?>
			</form>

	</div>

</section>

</body>
</html>


<?PHP 

?>