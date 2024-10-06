<?php
	$servername="localhost";
	$username="root";
	$password="";
	$db="pharmacy";
	$conn=mysqli_connect($servername,$username,$password,$db);
	if ($conn) {
		echo "  ";
	}else{
		echo "Connection failed".mysqli_connect_error();
	}
?>