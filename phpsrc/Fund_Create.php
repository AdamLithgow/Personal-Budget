<?php
    //echo "signin.php";
    require_once("pdo.php");
    require_once("index.php");
    //get the values from the form

    $state = 0;
    if(isset($_POST['state'])){
        $state=$_POST['state'];
    }
    $post = 1;
    $msg = "";
    //validate inputs
    if($state == 1)
    {
        $id = $_SESSION['pk'];

        //verify fundName name input
        if(isset($_POST['fundName'])){
            $fundName =$_POST['fundName'];
            if(strlen($fundName)==""){
                $post=0;
                $msg = "You must enter a name for the fund";
            }
        }
        else{
            $post=0;
            $msg = "You must enter a name for the fund";
        }

        //verify fundAmount input
        if(isset($_POST['fundAmount'])){
            $fundAmount =$_POST['fundAmount'];
            if(strlen($fundAmount)==""){
                $post=0;
                $msg = "You must enter an amount to allocate to the fund";
            }
        }
        else{
            $post=0;
            $msg = "You must enter an amount to allocate to the fund";
        }

        //post fund to db
        if($post==1){
            $arr= array("null",$fundAmount,$fundName, $id);
            $result=insertRecord("funds", $arr);
            if($result>0){
                $msg = "Fund Added Successfully";
            }
        }
    }

    //******* Display the Form *******

    if($result==1){
        redirect("myfunds");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Fund</title>
    </head>
    <body>
        <form action='index.php?p=Fund_Create' method=post>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>Fund Name: </td>
                    <td><input type="text" name="fundName"></td>
                </tr>

                <tr>
                    <td>Amount of budget for fund ($): </td>
                    <td><input type="text" name="fundAmount"></td>
                </tr>

                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>
