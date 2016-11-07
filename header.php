<!DOCTYPE html>
<html>
<head>
	<title>HelpSent </title>
	<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans|Josefin+Slab" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/style/index.css">
</head>
<body>

<section id="s1" class="section">
	<div id="header">
		<div class="header-wrap">
			<a class="logo" href="##">Helpsent</a>
			<div class="nav">
				<a href="/">Home</a>
				<a href="r.php">Signup</a>
				<?PHP 
					if(isset($_SESSION["logged_in"])){
						echo '<a href="lt.php">Logout</a>';
					}else{
						echo '<a href="l.php">Login</a>';
					}
				?>
				<a href="about.php">About</a>
			</div>
		</div>
	</div>