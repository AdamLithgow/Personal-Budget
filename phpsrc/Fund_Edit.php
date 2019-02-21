<?php
require_once("pdo.php");
require_once("index.php");

if(isset($_POST['state']))
{
    $state = $_POST['state'];
}

if($state == 1)
{
    $post = 1;
    if(isset($_POST['id']))
    {
        $id = $_POST['id'];
    }
    else
    {
        echo "<br>Error, missing fund";
        exit;
    }

    //~~~~~~ fund name ~~~~~~~
    if(isset($_POST['FundName']))
    {
        $fundName=$_POST['FundName'];
        if(strlen($fundName)==0)
        {
            $post=0;
            $msg = "Please enter a fund name.";
        }
    }
    else
    {
        $post=0;
        $msg = "Please enter a fund name.";
    }

    //~~~~~~ fund amount ~~~~~~~
    if(isset($_POST['FundAmount']))
    {
        $fundAmount=$_POST['FundAmount'];
        if(strlen($fundAmount)==0)
        {
            $post=0;
            $msg = "Please enter a fund amount.";
        }
    }
    else
    {
        $post=0;
        $msg = "Please enter a fund amount.";
    } 

    if($post==1)
    {
        //post the account to the db
        $array['FundId'] = $id;
        $array['FundAmount'] = $fundAmount;
        $array['FundName'] = $fundName;
        $array['UserId'] = $_SESSION['pk'];
        
        $result = updateRecord("funds", $array, "FundId", $id);

        if($result > 0)
        {
            $msg = "Fund updated";
            redirect("myfunds");
        }
        else
        {
            $msg = "Error updating fund";
        }
    }
}
if($result == 1){
    echo "<h2>Fund Updated</h2>";
    redirect("myfunds");
    exit;
}


//get the record to display
echo "<h2>Edit Fund</h2>";

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
//create the query
$query = "SELECT * FROM funds WHERE FundId=?";
$parms[0] = $id;
$rs = getRecordSet($query, $parms);

foreach($rs as $row)
{
    $fundAmount = $row['FundAmount'];
    $fundName = $row['FundName'];
}

//display the form
echo "<form action='index.php?p=Fund_Edit' method=post>";
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
            echo "<td colspan=2><input type='submit' value='Update'></td>";
        echo "</tr>";
    echo "</table>";
echo "</form>";

?>