<?PHP 

	if(!isset($_SESSION)){
		session_start();
	}
	
	if(!isset($_SESSION["logged_in"])){
		header("Location:/l.php");
		exit();
	}
	
	require_once "../app/app.php";
	require_once "../header.php";

/*
	if(isset($_POST["cred"])){

		$app = new app;

		if($app->send_credits($_POST["pin"] , $_POST["bucks"])){
			echo "AMount sent yo";
		}else{
			echo '<h1>'.$app->msg.'</h1>';
		}

	}

*/

		$con = new mysqli("localhost","root","girish","hack");

if(isset($_POST["pin"]) && !empty($_POST["pin"])){

	if(strlen($_POST["pin"])){

		$credits = $_POST["bucks"];
		$phone = $_POST["pin"];


		$qry = sprintf("SELECT * FROM users WHERE phone = '%s'",$phone);

		$res = $con->query($qry);

		if($res){
			// this confirms that their is an user with the $pin

			$other_user_details = $res->fetch_assoc();

			// Now get the user phone from the session and check if he has enough amount
			
			$current_user_phone_number = $_SESSION["logged_in"];


			$qry = sprintf("SELECT * FROM users WHERE phone = '%s'",$current_user_phone_number);

			$res = $con->query($qry);

			$current_user_details = $res->fetch_assoc();

			if($res->num_rows!=0){

				// This confirms that their is a user with enough amount to send
				// Now send the credits and update items

				$latest_credits = (int) $current_user_details["credits"] - (int) $credits;
				
				$qry = sprintf("UPDATE users SET credits = '%s' AND phone ='%s'",$latest_credits, $current_user_phone_number);

				$res = $con->query($qry);


				// Now update the other customer credits

				$tom = (int) $credits + (int) $other_user_details["credits"];

				echo $credits.PHP_EOL;
				echo $other_user_details["credits"].PHP_EOL;

				$qry = sprintf("UPDATE users SET credits = '%s' AND phone = '%s' ",$tom,$other_user_details["phone"]);

				$res = $con->query($qry);
				
				// Insert into the transactions table about eh current transaction

				$qry = sprintf("INSERT INTO transactions (from_c,to_c,credits) VALUES('%s','%s','%s')",$current_user_details["phone"],$other_user_details["phone"],$credits); 

				if($con->query($qry)){
					$msg = "5 credits have been transfered";

					send_sms($other_user_details["phone"],"You have received ".$credits." credits from ".$current_user_details["name"]);
					send_sms($current_user_details["phone"],"You have sent".$credits." credits to ".$other_user_details["name"]);

				}else{
					$msg = "Some problems";
				}


			}else{
				$msg = "Sorry you dont have sufficient credits to make the transaction";
			}

		}else{
			$msg = "Please check your ";
		}

	}

}

?>

<div class="max-wrap">

	<div id="dashboard">
		<div class="d-wrap">
			<h4> You previous transactions </h4>
			<table width="100%" id="transaction-list">
				<thead style="background:#f9f9f9;padding: 15px 10px">
					<tr>
						<th>Sl.</th>
						<th>From</th>
						<th>To</th>
						<th>Credits</th>
					</tr>
				</thead>
				<tbody>

					<?PHP 


 						$qry = sprintf("SELECT * FROM transactions WHERE 1");

 						$res = $con->query($qry);

 						$data = $res->fetch_assoc();
 						$i=1;
 						while($row = $res->fetch_assoc()){
 							echo "<tr>";
 							echo "<td>".$i."</td>";
 							echo "<td>".$row["from_c"]."</td>";
 							echo "<td>".$row["to_c"]."</td>";
 							echo "<td>".$row["credits"]."</td>";
 							echo "<td>".$row["timing"]."</td>";
 							echo "</tr>";

 							$i++;
 						}

					?>	

				</tbody>

			</table>

			<div id="call">
			<center>Your current balance</center>
			<br>
				<div id="badge">
				<?PHP 

					$phone = $_SESSION["logged_in"];

					$qry = sprintf("SELECT credits,name FROM users WHERE phone = '%s'",$phone);
					$res = $con->query($qry);
					$r = $res->fetch_assoc();
					$c = $r["credits"];
					$n = $r["name"];
					if($res){
						echo '<div>'.$n.'</div>'; 
						echo '<div>'.$c.'</div>'; 
					}else{
						echo "Some probs dude please check it out";
					}

				?>
				</div>

				<h3>Forget thanks and welcome the new credits</h3>
				<p>
					Send your friends some credits as appreciation not just thank you.
				</p>

				<form action="" method="post">
					<?PHP 
						if(isset($msg)){
							echo '<script>window.alert('.$msg.');</script>';
						}
					?>
					<!-- <center><h2 style="font-weight:200;padding-bottom:10px;margin: 0">Send credits</h2></center> -->
					<div class="field">
						<input type="text" name="pin" placeholder="Enter pin">
					</div>
					<div class="field">
						<input type="text" name="bucks" placeholder="Enter the amount">
					</div>
					<div class="field">
						<button name="cred" value="cred" style="background:#ed5565;color: #fff;font-weight: bold">SEND </button>
					</div>
				</form>


			</div>


		</div>
	</div>

</div>

<div id="model-cred-m" style="display: none;box-shadow: 0 0 10px .1px rgba(0,0,0,.2);position:absolute;left:0;right:0;top:100px;max-width: 400px;margin: 0 auto;z-index: 1000;background: #f9f9f9;padding: 20px;">
	<form>
		<center><h2 style="font-weight:200;padding-bottom:10px;margin: 0">Send credits</h2></center>
		<div class="field">
			<input type="text" placeholder="Enter pin">
		</div>
		<div class="field">
			<input type="text" placeholder="Enter the amount">
		</div>
		<div class="field">
			<button>Send </button>
		</div>
	</form>
	<center><a href="#" id="modal-close">Close</a></center>
</div>


<?PHP 

require_once "../footer.php";

?>