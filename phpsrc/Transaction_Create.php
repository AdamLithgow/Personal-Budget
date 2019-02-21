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

        //verify amount input
        if(isset($_POST['amount'])){
            $amount =$_POST['amount'];
            if(strlen($amount)==""){
                $post=0;
                $msg = "You must enter a amount name";
            }
        }
        else{
            $post=0;
            $msg = "You must enter a amount name";
        }

        //verify description input
        if(isset($_POST['description'])){
            $description =$_POST['description'];
            if(strlen($description)==""){
                $post=0;
                $msg = "You must enter a description name";
            }
        }
        else{
            $post=0;
            $msg = "You must enter a description name";
        }

        //verify fund input
        if(isset($_POST['fund'])){
            $fund =$_POST['fund'];
            if(strlen($fund)=="None Selected"){
                $post=0;
                $msg = "You must select a fund";
            }
        }
        else{
            $post=0;
            $msg = "You must select a fund";
        }

        //post amount 1 to DB
        if($post==1){
            $arr= array("null",$amount, $description, date("Y-m-d H:i:s"), $fund);          //how to find out id from fund
            //print_r($arr);
            $result=insertRecord("transactions", $arr);
            if($result>0){
                $msg = "transaction Added.";
            }
        }
    }

    //******* Display the Form *******

    if($result==1){
        redirect("mytransactions");
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create amount</title>
    </head>
    <body>
        <form action='index.php?p=Transaction_Create' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><?php $msg ?></td>
                </tr>

                <tr>
                    <td>Fund: </td>
                    <td>
                        <select name = 'fund'>
                        <?php
                            $temp = buildQuickList("Select FundId, FundName From funds", 'FundName','FundId');
                            echo $temp;
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Transaction Amount: </td>
                    <td><input type="text" name='amount'></td>
                </tr>

                <tr>
                    <td>Transaction Description: </td>
                    <td><input type="text" name='description'></td>
                </tr>

                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>
