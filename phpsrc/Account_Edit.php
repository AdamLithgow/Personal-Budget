<?php
		//echo "signin.php";
		require_once("pdo.php");
		//echo "signin.php v3";
		//lets get the values from the form
		//use session variables to load existing user profile.
		//allow user to change their password and user name
		$id = $_SESSION['user'];
		$row = runQuery("select * from user where email='$id'");
		print_r($row);

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
             //~~~~~~ username ~~~~~~~
            if(isset($_POST['user'])){
                $user=$_POST['user'];
                if(strlen($user)==0){
                    $post=0;
                    $msg = "invalid user";
                }
            }
            else{
                $post=0;
                $msg = "invalid user";
            }        
             //~~~~~~ password ~~~~~~~
            if(isset($_POST['pass'])){
                $pass=$_POST['pass'];
                if(strlen($pass)==0){
                    $post=0;
                    $msg = "invalid password";
                }
            }
            else{
                $post=0;
                $msg = "invalid password";
            }             
            
            if($post==1){
                //post the account to the db
                $arr= array($email,$user,10,$pass);
                $result=insertRecord("comprep", $arr, false);
                echo "result=$result";
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
                    <td colspan=2><?php $msg ?></td>
                </tr>
        
                <tr>
                    <td>Full Name: </td>
                    <td><input type='text' name='repName' size=40 maxlen=40 value=$repName></td>
                </tr>
 
                <tr>
                    <td>Company: </td>
                    <td>
                        <select name = comp>
                            <?php
                                $temp = buildQuickList("Select idcompany, companyName From company", 'companyName','idcompany');
                                echo $temp;
                            ?>
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td><input type='text' name='email' size=40 maxlen=40 value=$email></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type='password' name='pass' size=40 maxlen=40></td>
                </tr>

                <tr>
                    <td colspan=2><input type='submit' value='create'></td>
                </tr>
            </table>
        </form>
    </body>
</html>