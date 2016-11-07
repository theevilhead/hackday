<?PHP 

 // require_once "valids.php";

require_once "../vendor/autoload.php";

use Plivo\RestAPI;

 class app{

 	public $msg;

 	function __construct(){

 	}

 	public function send_credits($pin,$credits){

 		/*
			For the user to send credits
				1. He must have enough credits in his pocket
				2. And the other user must be registered
			Now 
				1. Update both sides with amount sent and received

			After the credits is sent sent to both of them a sms : among with proper msg
			
 		*/

 		// if(isset($_SESSION["logged_in"])){

	 		if(isset($_POST["pin"]) && !empty($_POST["pin"])){

	 			if(strlen($_POST["pin"])){

	 				$con = new mysqli("localhost","root","girish","hack");

	 				$qry = sprintf("SELECT * FROM users WHERE phone = '%s'",$pin);

	 				if($con->query($qry)){
	 					// this confirms that their is an user with the $pin
	 					// Now get the user phone from the session and check if he has enough amount

	 					$qry = sprintf("SELECT * FROM users WHERE credits >= '%s' AND phone = '%s'",$credits,$_SESSION["logged_in"]);

	 					if($con->query($con)){
	 						echo "<h1>DONE DUDE</h1>";
	 					}

	 				}else{
	 					$this->msg = "Please check your ";
	 				}

	 			}

	 		}


 	}

 	public function new_user(){

 		//  Take user phone number and aadhar card
 		//  Name => nm, aadhar ad 

 		$con = new mysqli("localhost","root","girish","hack");

 			$name = $_POST["nm"];
 			$aad =  $_POST["aad"];
 			$pass = $_POST["pwd"];
 			$phone = $_POST["pn"];

 			$qry = sprintf("INSERT INTO users (name,card,password,phone) VALUES('%s','%d','%s','%s')",$name,$aad,$pass,$phone);

 			if($con->query($qry)){
 				return true;
 			}

 			return false;

 	}


 	


 }


function send_sms($to,$msg){

	$auth_id = "MAYTK0M2MZNJA1MJQ4Y2";
	$auth_token = "OThkMjNiMTUwYzcyM2Y0ZGVkYzJlNWViMWM3NWRh";
	$p = new RestAPI($auth_id, $auth_token);

	$params = array(
	    'src' => '1111111111',
	    'dst' => "91".$to,
	    'text' => $msg
	);
	$response = $p->send_message($params);
}

send_sms("7353044499","Hi Supriya, You have been awarded with  platinum badge having unlimited credits* from our platinum member Girish Patil, As you have eaten half of his head. <3.
Thank you for being with us.");

?>
