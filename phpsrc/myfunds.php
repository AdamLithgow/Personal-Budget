<?php
	require_once("phpsrc/safer.php");
    require_once("phpsrc/pdo.php");
	//$proceed = safer(10);
	//if(safer(10) == false){
	//	echo "<br>You are not authorized to this page....<br>";
		//exit;
	//}
	echo "<br><h2>My Funds</h2>";
    $menu = "menu20.htm";
    $id = $_SESSION['pk'];
	$query = "SELECT FundName, FundAmount, FundId FROM funds WHERE UserId = ?";
    $parms['0'] = $id;
	//echo "query = $query";
    $result = getRecordSet($query,$parms);
    if(sizeof($result) == 0)
    {
        echo "You don't seem to have any funds set up. <br> Get started by adding one above.";
    }
    displayRecordSetE($result, "Fund_Edit", "Fund_Del", "mytransactions", "FundId");

?>
