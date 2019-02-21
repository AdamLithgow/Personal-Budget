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
        $result = delRecord("funds", "FundId", $id);
        if($result >0){
            echo "<h2> Record Deleted</h2>";
            redirect("myfunds");
            exit;
        }
        echo "<br> Error Deleting Record";
    }

    //******* Display the Form *******
    //get record to display
    echo "<h2>Delete Fund</h2>";

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
    $query = "SELECT * FROM funds WHERE FundId=?";
    $parms[0] = $id;
    $rs = getRecordSet($query,$parms);
    //print_r($rs);
    if(count($rs)==0){
        echo "<br>fund not found";
        exit;
    }
    //displayRecordSet($rs);
    foreach($rs as $row)
    {
        $fundName = $row['FundName'];
        $fundAmount = $row['FundAmount'];
    }

//display the form
echo "<form action='index.php?p=Fund_Del' method=post>";
    echo "<input type='hidden' name='state' value=1>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<table>";
        echo "<tr>";
            echo "<td colspan=2>$msg </td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td>Fund name: </td>";
            echo "<td><input type='text' name='FundName' size=40 maxlen=40 value='$fundName'></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td>Fund amount: </td>";
            echo "<td><input type='text' name='FundAmount' size=40 maxlen=40 value='$fundAmount'></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td colspan=2><input type='submit' value='delete'></td>";
        echo "</tr>";
    echo "</table>";
echo "</form>";
?>