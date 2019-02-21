<?php
	require_once("phpsrc/safer.php");
    require_once("phpsrc/pdo.php");

    if(isset($_GET['i'])){
        $id = $_GET['i'];
    }
    else{
        echo "error, fund not found";
        exit;
    }

    echo "<br><h2>My Transactions</h2>";
	$query = "SELECT TransactionAmount, TransactionDescription, TransactionId FROM transactions WHERE FundId = ?";
    $parms['0'] = $id;
	//echo "query = $query";
    $result = getRecordSet($query,$parms);
    if(sizeof($result) == 0)
    {
        echo "You don't seem to have any transactions in this fund. <br> Get started by adding one above.<br>";
    }
    displayRecordSetE($result, "Transaction_Edit", "Transaction_Del", "Transaction_View", "TransactionId");

?>
