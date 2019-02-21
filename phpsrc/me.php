<?php
		//echo "signin.php";
		require_once("pdo.php");
		//echo "signin.php v3";
		//lets get the values from the form
		//use session variables to load existing user profile.
		//allow user to change their password and user name
		$id = $_SESSION['user'];
		//echo "user = $id";
		$rs=runQuery("Select * from users where email='$id'");
		//$row = $rs['queryString'];
		foreach($rs as $row);
		//	print_r($row);
		$email = $row['email'];
		$user = $row['username'];
		$state = 0;
        if(isset($_POST['state'])){
            $state=$_POST['state'];
        }
		$post = 0;
		$msg = "";
		//validate email
        if($state == 1)
        {
            //validate the inputs
            //~~~~~~ email ~~~~~~~
            if(isset($_POST['email'])){
                $email=$_POST['email'];
				//cant change email.
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
				$array['username'] = $user;
				$post = 1;
                if(strlen($user)==0){
                    $post=0;
                    $msg = "invalid user";
                }
			}
      
             //~~~~~~ password ~~~~~~~
            if(isset($_POST['pass'])){
                $pass=$_POST['pass'];
				if(strlen($pass)>0)
				{
					$array['password'] = $pass;
					$post=1;
				}
			}    
            
            if($post==1){
                //post the account to the db	
               $result=updateRecord("users", $array, "email",$id);
               if($result==1){
				   echo "record updated.";
			   }
			   else{
				   echo "error updating record";
			   }
            }
        }
		
		//*************** Display the Form *******
        echo "<form action='index.php?p=me' method=post>";
        echo "<input type='hidden' name='auth' value=10>";
        echo "<input type='hidden' name='state' value=1>";
        echo "<table>";
        echo "<tr><td colspan=2>$msg </td></tr>";
        echo "<tr><td>Email: </td>";
        echo "<td><input type='text' name='emailt' size=40 maxlen=40 value=' ".$email." ' disabled>";
		echo  "<input type=hidden name=email value=$email>";
        echo "</td></tr>";

        echo "  <tr><td>User Name: </td>";
        echo "  <td><input type='text' name='user' size=40 maxlen=40 value='".$user."'></td></tr>";

        echo "  <tr><td>Password: </td>";
        echo "  <td><input type='password' name='pass' size=40 maxlen=40></td></tr>";

        echo "  <tr><td colspan=2><input type='submit' value='update'></td></tr>";
        echo "</table>";
        echo "</form>";
	
?>





