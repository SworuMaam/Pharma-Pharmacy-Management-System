<?php
	include "connect.php";
	if (isset($_POST['submit'])) {
		if (empty($_POST['date'])||empty($_POST['pid'])||empty($_POST['pname'])||empty($_POST['mname'])||
        empty($_POST['contact'])||empty($_POST['price'])||empty($_POST['qty'])) {
			echo "Please enter all data";
		}else{
			$date=$_POST['date'];
        $pid=$_POST['pid'];
        $pname=$_POST['pname'];
        $mname=$_POST['mname'];
        $contact=$_POST['contact'];
        $price=$_POST['price'];
        $qty=$_POST['qty'];

		$sql = "UPDATE purchase SET qty = qty - $qty WHERE m_name = '$mname'";
		$result = mysqli_query($conn,$sql);
		if ($result) {
			$ins_query="insert into records values('$date','$pid','$pname','$mname','$contact','$price','$qty')";
			$ins_exe=mysqli_query($conn,$ins_query);
			if ($ins_exe) {
				echo "Data inserted";
				header('location:addrecord.php');
			}else{
				echo "Insertion failed";
			}
		}
	}
}
?>