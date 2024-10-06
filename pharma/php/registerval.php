<?php
	include "connect.php";
	if (isset($_POST['submit'])) {
		if (empty($_POST['uname'])||empty($_POST['pass'])||empty($_POST['repass'])||
		empty($_POST['address'])||empty($_POST['email'])||empty($_POST['contact'])) {
			echo "Please enter all data";
		}elseif($_POST['pass']!=$_POST['repass']) {
				echo "Password and repassword must be same";
		}elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			echo "Invalid email format";
		}else{

			$name=$_POST['uname'];
			$pass=$_POST['pass'];
			$address=$_POST['address'];
			$email=$_POST['email'];
			$contact=$_POST['contact'];

			// $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

			// $ins_query="insert into user (username, password, address, email, contact) values(?, ?, ?, ?, ?)";
			$ins_query="insert into user (username, password, address, email, contact) values('$name', '$pass', '$address', '$email', '$contact')";
			$ins_exe = mysqli_query($conn,$ins_query);

			// $stmt = mysqli_prepare($conn, $ins_query);

			// if ($stmt) {
				// mysqli_stmt_bind_param($stmt, "sssss", $name, $hashedPassword, $address, $email, $contact);
	
			if ($ins_exe) {
				echo "Data inserted";
				header('location: login.php');
				exit(); // Make sure to exit after redirecting
			} else {
				echo "Insertion failed: " . mysqli_error($conn);
			}
	
				// mysqli_stmt_close($stmt); // Close the prepared statement
			// } else {
				// echo "Preparation of statement failed: " . mysqli_error($conn);
			// }

			// mysqli_stmt_bind_param($stmt, "sssss", $name, $hashedPassword, $address, $email, $contact);

			// $ins_exe=mysqli_stmt_execute($stmt);
			// if ($ins_exe) {
			// 	echo "Data inserted";
			// 	header('location:login.php');
			// 	exit();
			// }else{
			// 	echo "Insertion faileds";
			// }
			// mysqli_stmt_close($stmt);
		}
	}
?>