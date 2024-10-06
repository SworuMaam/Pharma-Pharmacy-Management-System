<!DOCTYPE html>
<html>
<head>
	<title>Login form</title>
	<link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div id="container">
		<form action="" method="POST" >
		<fieldset >
			
			<legend>Login</legend>
			<table>
				<tr>
					<td><label>Username:</label></td>
					<td><input type="text" name="lname" minlength="3" /></td>
				</tr>
				<tr>
					<td><label>Password:</label></td>
					<td><input type="password" name="lpass"/></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" value="Login"/></td>
					<td><a href="register.php"><input type="button" value="Register"/></a></td>
				</tr>
			</table>
			
		</fieldset>
	</form>
</div>
</body>
</html>

<?php 
	
	session_start();
	include "connect.php";
	if(!isset($_SESSION['user'])) {

		if (isset($_POST['submit'])) {
			if (empty($_POST['lname'])||empty($_POST['lpass'])) {
				echo "  ";
			}else{
				$_SESSION['user'] = $_POST['lname'];
				

				$logname=$_POST['lname'];
				$logpass=$_POST['lpass'];


				$logQuery="select * from admin where username='$logname' AND Password='$logpass'";
				$logExe=mysqli_query($conn,$logQuery);

				$logUserQuery="select * from user where username='$logname' AND Password='$logpass'";
				$logUserExe=mysqli_query($conn,$logUserQuery);

				if (mysqli_num_rows($logExe)==1) {
					$fetching = mysqli_fetch_assoc($logExe);
					$_SESSION['id'] = $fetching['id'];
					echo "Data inserted";
					header('location:dashboard.php');
				}elseif(mysqli_num_rows($logUserExe)==1) {
					$fetching1 = mysqli_fetch_assoc($logUserExe);
					$_SESSION['id'] = $fetching1['id'];
					header('location:index.php');
				}else{
					session_destroy();
					echo "username or password not valid";
					exit();
				}
			}
		}
	}else{
		echo "ad";
	}
			
?>
