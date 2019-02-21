<?php
	//confirm they have access to this page
	function safer($pageLevel){
		//echo "checking...";
		$proceed = false;
		if(isset($_SESSION['auth'])){
			$userLvl = $_SESSION['auth'];	
				echo $userLvl;
				echo $pageLevel;
			if($pageLevel <= $userLvl){
				$proceed = true;
				return $proceed;
		    }
		}
		echo "<br>Sorry, you are not authorized to this page...<br>";
		exit;
	}
	
	

?>