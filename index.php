<?php
session_start();

function clearHistory( )
{
			unset($history);
			$url['lastpage'] = "home.php";
			$history['home.php'] = $url;
			$_SESSION['history'] = $history;
}

//********************************** Set Page Parts ***********************************
//primary template all page calls originate here.


//determine page to load based on $_GET[]
if(array_key_exists("p", $_GET))
{
	$page = $_GET['p'].".php";
	$dspUser = $_SESSION['user'];
	//echo "dspuser = ".$dspUser;
}
else
{
	//no page requested, load default page.
	//could extend this to see if logged in.
	$page = "signin.php";
	session_destroy();
	$dspUser = "Sign In";
}

//set the menu based on user authority
$menu = "menu20.htm";


if(isset( $_GET['rs']))
{
	if( $_GET['rs'] == true)
	{
		clearHistory();
		$_SESSION['lastpage'] = "home.php";
	}
}


//if logout page - then clear and close the session 
if ($page == 'signout.php') {
	if(isset( $_SESSION['user']))
		session_destroy();
	$menu = "menu0.htm";
	$page = "signin.php";
	//echo "logged out.";
	$dspUser = "Sign In";
}

if($page == "index.php" || $page == "signin.php" || $page == "Account_Create.php")
{
	$menu = "menu0.htm";
}

//********************************** Assemble the Page ***********************************

//set up XHTML page specs like !DOCTYPE, etc
require_once("htmlsrc/control.htm");
echo "<head>";
	echo "<link href='csssrc/skeleton.css' type='text/css' rel='stylesheet' />";
	echo "<link href='csssrc/styles.css' type='text/css' rel='stylesheet' />";
	echo "<title>My Budget</title>";
echo "</head>";
//end of the heading - display the body.
echo "<body>";

echo "<div id='container'>";
	echo "<div id='heading'>";
		include("htmlsrc/heading.htm");
	echo "</div>";

	echo "<div id=topbar>";
	echo "<div id='menu'>";
		//echo "menu = ".$menu;
		include("htmlsrc/".$menu);

		
	echo "</div>";

	if( $page == "signin.php" )
		$_SESSION['user'] = "Please Log In";

		if( !( isset( $dspUser)) || $dspUser == "")
			$dspUser = "Please Sign In";

			echo "<div id='user'>";
				//echo $dspUser;
				//if( isset( $_SESSION['user']))
				//	echo 	$_SESSION['user'];
				//else
				//	echo "Please Log In.";
			echo "</div>";	
		echo "</div>";

		if( isset( $_SESSION['lastpage'] ))
		{
			$lastpage = $_SESSION['lastpage'];
		}
		else
		{
			$lastpage = "home.php";
		}

		//echo "<br/>LASTPAGE: ".$lastpage;

	if( $page == "back.php")
	{
		//get previous page and go back
		if( isset( $_SESSION['history']))
		{
			$history = $_SESSION['history'];
			$url = $history[$lastpage];
			$page = $url['lastpage'];
			$urlnew = $history[$page];
			$extra = null;
			if( isset( $urlnew['m']))
			{
				$_GET['m'] = $urlnew['m'];
				$extra="?m=".$urlnew['m'];
				//echo "<br/>SETTING M = ".$urlnew['m'];
			}
			if( isset( $urlnew['i'] ))
			{
				$_GET['i'] = $urlnew['i'];
				if( isset( $extra ))
					$extra .= "&i=".$urlnew['i'];
				else
					$extra = "?i=".$urlnew['i'];
			}

			//echo "<br />going back to: ".$page.$extra;
			//clear out the page
			$url = null;
			unset($history[$lastpage]);
			$_SESSION['history'] = $history;
			//$_SESSION['lastpage'] = $urlnew['lastpage'];
			$_SESSION['lastpage']=$page;
			$lastpage = $page;
			//echo "<br>setting lastpage = ".$lastpage;
		}
		//clear out old page in history.
	}
	else
	{
		//if( currentpage different from lastpage)
			//save current page with link to lastpage
		if(!($page == $lastpage))
		{
			$url['lastpage'] = $lastpage;
			if( isset( $_GET['m'] ))
				$url['m'] = $_GET['m'];

			if( isset( $_GET['i'] ))
				$url['i'] = $_GET['i'];

			if( isset( $_SESSION['history'] ))
			{
				$history = $_SESSION['history'];
			}

			$history[ $page ] = $url;
			$_SESSION['history'] = $history;
			//echo "<br/>SETTING lastpage = ".$page;
			$_SESSION['lastpage'] = $page;
		}
	}
	if($page == "home.php")
	{
		//unset($history);
		//$url['lastpage'] = "home.php";
		//$history['home.php'] = $url;
		//$_SESSION['history'] = $history;
		clearHistory();
	}
	//temporary - show history***********************
	/*
	echo "<br/>HISTORY:";
	if( isset( $_SESSION['history'] ))
	{
		$history = $_SESSION['history'];
		foreach( $history as $kh => $vh )
		{
			echo "<br/>PAGE:".$kh;
			foreach ($vh as $ku => $vu )
				echo "<br />field:".$ku." = ".$vu;
		}
	}
	if( isset( $_SESSION['lastpage']))
	{
		echo "<BR/>LAST CHANCE AT LAST PAGE = ".$_SESSION['lastpage'];
	}
	////  */
//echo "page = ".$page;
	//echo "page to load: ".$page;
	echo "<div id='content'>";
			include("phpsrc/".$page);
	echo "</div>";
echo "</div>";

function redirect($redirPage)
{
	echo "<meta http-equiv='refresh' content='0;url=./index.php?p=$redirPage'>";
}
?>
</body>
</html>
