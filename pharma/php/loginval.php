
<?php 
	
	include "connect.php";
	if (isset($_POST['submit'])) {
		if (empty($_POST['lname'])||empty($_POST['lpass'])) {
			echo "  ";
		}else{
			$logname=$_POST['lname'];
			$logpass=$_POST['lpass'];

			$_SESSION['user']=$logname;
			$_SESSION['pass']=$logpass;

			$logQuery="select * from admin where Username='$logname' AND Password='$logpass'";
			$logExe=mysqli_query($conn,$logQuery);
			if (mysqli_num_rows($logExe)==1) {
				echo "Data inserted";
				header('location:dashboard.php');
			}else{
				echo "username or password not valid";
			}
		}
	}else{
		
	}
?>