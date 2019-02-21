<?php
		require_once("pdo.php");
		require_once("index.php");
        echo"<div id='message'>Please create an account to continue. The pre-existing use is <br>Username: test@test.com<br>Password: test</div>";
		?>
		<script>
			document.getElementById('signin').style.display = 'none';
			document.getElementById('user').style.display = 'none';
		</script>
		<?php
		
		//lets get the values from the form
		$firstTrip = 0;
		$post = 1;
		$msg = "";
		//validate username

		if(isset($_POST['email'])){
			$username = $_POST['email'];
			$firstTrip = 1;
		}
		else{
			$username = "";
			$post = 0;
		}

		if(strlen($username)<1 && $firstTrip == 1){
			$msg =  "User name not entered.  ";
			$post = 0;
			//exit;
		}

		if(isset($_POST['password'])){
			$password = $_POST['password'];
			$firstTrip = 1;
		}
		else{
			$password = "";
			$post = 0;
		}

		if(strlen($password)<1 && $firstTrip == 1){
			$msg =  "Password not entered.";
			$post = 0;
			//exit;
		}
		//echo "<br>email = $username";
		//echo "<br>password = $password";
		//echo "<br>post = $post";
		//echo "<br>";
		//set up the query string
		if($post == 1){
			$query = "SELECT * FROM users WHERE Email = ? AND Password = ?";
			$parm[0] = $username;
			$parm[1] = $password;
			//echo "test";
			$rs = getRecordSet($query,$parm);
			//displayRecordSet($rs);
			$c = sizeof($rs);
			//echo "<br>return value =".sizeof($rs);
			//print_r($rs);
			if($c == 0){
				unset($rs);
			}
		}

		//message if not found
		if($firstTrip == 1){
			if($c==0){
				//failed attempt
				echo "<br>invalid login, please try again";
				include("htmlsrc\signin.html");
			}
			else{
				//successful login
				//set up the session variables
				$menu = "menu20.htm";
				$row = $rs[0];
				$_SESSION['user'] = $row['Name'];
				$_SESSION['pk'] = $row['UserId'];
				redirect("myfunds");
				//load the main page
				
				?>
				<script>
					document.getElementById('message').style.display = 'none';
				</script>
				<?php

				//echo "<h2>Welcome, ".$_SESSION['user']."</h2>";
				
			}
		}
		else{
			//first attempt
			include ("htmlsrc\signin.html");
		}




?>
