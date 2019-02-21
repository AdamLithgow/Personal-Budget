<?php
$id = $_SESSION['user'];
echo "	<ul>";
echo "		<li><a href='index.php?p=signin'>Sign Out</a></li>";
echo "		<li><a href="index.php?p=myinterviews">My Interviews</a></li>";
echo "		<li><a href="index.php?p=Interview_Create">Add Interview</a></li>";	
echo "		<li><a href="index.php?p=me">My Profile</a></li>";
echo "	</ul>";
?>