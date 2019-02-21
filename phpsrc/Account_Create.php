<?php
		//echo "signin.php";
		require_once("pdo.php");
        
        ?>
		<script>
            document.getElementById('create').style.display = 'none';
            document.getElementById('user').style.display = 'none';
        </script>
		<?php

        $menu = "menu0.htm";

		//lets get the values from the form
		$state = 0;
        if(isset($_POST['state'])){
            $state=$_POST['state'];
        }
		$post = 1;
		$msg = "";
		//validate email
        if($state == 1)
        {
            //validate the inputs
            //~~~~~~ email ~~~~~~~
            if(isset($_POST['email'])){
                $email=$_POST['email'];
                if(strlen($email)==0){
                    $post=0;
                    $msg = "invalid email";
                }
            }
            else{
                $post=0;
                $msg = "invalid email";
            }
             //~~~~~~ name ~~~~~~~
            if(isset($_POST['name'])){
                $name=$_POST['name'];
                if(strlen($name)==0){
                    $post=0;
                    $msg = "invalid name";
                }
            }
            else{
                $post=0;
                $msg = "invalid name";
            }        
             //~~~~~~ password ~~~~~~~
            if(isset($_POST['password'])){
                $password=$_POST['password'];
                if(strlen($password)==0){
                    $post=0;
                    $msg = "invalid password";
                }
            }
            else{
                $post=0;
                $msg = "invalid password";
            }

             //~~~~~~ budget amount ~~~~~~~
             if(isset($_POST['amount'])){
                $amount=$_POST['amount'];
                if(strlen($amount)==0){
                    $post=0;
                    $msg = "invalid amount";
                }
            }
            else{
                $post=0;
                $msg = "invalid amount";
            }        
            
            if($post==1){
                //post the account to the db
                //pk, compID, name, email auth password
                $arr= array("null", $amount, $email, $name, $password);
                $result=insertRecord("users", $arr);
                //echo "result=$result";
                if($result == 1){
                    echo "Account created successfully.";
                }
                redirect("signin");
            }
        }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Account</title>
    </head>
    <body>
        <form action='index.php?p=Account_Create' method=post>
            <input type='hidden' name='auth' value=10>
            <input type='hidden' name='state' value=1>
            <table>
                <tr>
                    <td colspan=2><h3>Create an account:</h3></td>
                    <td colspan=2><?php $msg ?></td>
                </tr>
        
                <tr>
                    <td>Name: </td>
                    <td><input type='text' name='name' size=40 maxlen=40></td>
                </tr>
 
                <tr>
                    <td>Email: </td>
                    <td><input type='text' name='email' size=40 maxlen=40></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type='password' name='password' size=40 maxlen=40></td>
                </tr>

                <tr>
                    <td>Amount to budget: </td>
                    <td><input type='text' name='amount' size=40 maxlen=40></td>
                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>