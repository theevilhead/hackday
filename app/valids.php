<?PHP 


/**
*  valids
*/
class valids
{
	
	function __construct()
	{

	}

	/*
		Send and array with the name 
	*/

	static function valid_post_fields( $data ){
			if(is_array($data)){
				foreach ($variable as $value) {
					if(!isset($_POST[$value]) || !empty($_POST[$value])){
						return false;
					}
				}
			}else{
				if(!isset($_POST[$value]) || !empty($_POST[$value])){
					return false;
				}
			}
	}


	


}




?>

