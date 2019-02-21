<?php
    //echo "signin.php";
    require_once("pdo.php");
    require_once("index.php");
    //echo "signin.php v3";

    //******* Delete if Ready *******
    if(isset($_POST['state'])){
        $state = $_POST['state'];
    }
    if($state ==1){
        //user said to delete record
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }else{
            echo "<br>error, missing id";
        }
        //do deletion
        $result = delRecord("transactions", "TransactionId", $id);
        if($result >0){
            echo "<h2> Record Deleted</h2>";
            redirect("myfunds");
            exit;
        }
        echo "<br> Error Deleting Record";
    }

    //******* Display the Form *******
    //get record to display
    echo "<h2>Delete Transaction</h2>";

    if($state == 0)
    {
        if(isset($_GET['i']))
        {
            $id = $_GET['i'];
        }
        else
        {
            echo "error, fund not found";
            exit;
        }
    }

    //create query
    $query = "SELECT * FROM transactions WHERE TransactionId=?";
    $parms[0] = $id;
    $rs = getRecordSet($query,$parms);
    //print_r($rs);
    if(count($rs)==0){
        echo "<br>student not found";
        exit;
    }
    //displayRecordSet($rs);
    foreach($rs as $row)
    {
        $transactionAmount = $row['TransactionAmount'];
        $transactionDesc = $row['TransactionDescription'];
        $transactionDate = $row['TransactionData'];
    }

//display the form
echo "<form action='index.php?p=Transaction_Del' method=post>";
    echo "<input type='hidden' name='state' value=1>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<table>";
        echo "<tr>";
            echo "<td colspan=2>$msg </td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td>Transaction Amount: </td>";
            echo "<td><input type='text' name='TransactionAmount' size=40 maxlen=40 value='$transactionAmount' disabled></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td>Transaction Description: </td>";
            echo "<td><input type='text' name='TransactionDescription' size=40 maxlen=40 value='$transactionDesc' disabled></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td>Transaction Date: </td>";
            echo "<td><input type='text' name='TransactionDate' size=40 maxlen=40 value='$transactionDate' disabled></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td colspan=2><input type='submit' value='delete'></td>";
        echo "</tr>";
    echo "</table>";
echo "</form>";
?>