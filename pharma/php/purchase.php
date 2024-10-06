<?php 
    session_start();
    if(isset($_SESSION['user'])){
        include "connect.php";
    } else{
        session_destroy();
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pharma</title>
	<link rel="stylesheet" href="../css/dash.css">
	<style>

        .inp {
            position: relative;
            top: 2px;
            left: 150px;
        }

		.box2 {
			margin: 20px;
			margin-top: 20px;
			border-radius: 20px;
			padding: 15px;
    		box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
		}

		table{
			padding-left: 60px;
		}

    </style>
</head>
<body>
	<header>Purchase</header>

	<nav>
        <a href="dashboard.php">Home</a>
        <a href="m.php">Medicine Records</a>
        <a href="p.php">Patient Records</a>
        <a href="adminTransaction.php">Transaction History</a>
        <a href="n.php">Notifications</a>
        <a href="s.php">Search</a>

        <div class="inp">
            <form method="POST" action="logout.php">
                <input type="submit" name="logout" value="Logout">
            </form>
        </div>
    </nav>

	<div class="container">
		<div class="box2">
		<form action="" method="POST" enctype="multipart/form-data">
			
				
			<table>
				<tr>
					<td><label>Suppliers Name:</label></td>
					<td><input type="text" name="sname"/></td>
				</tr>
				<tr>
					<td><label>Suppliers ID:</label></td>
					<td><input type="number" name="sid"/></td>
				</tr>
				<tr>
					<td><label>Suppliers Address:</label></td>
					<td><input type="text" name="address"/></td>
				</tr>
				<tr>
					<td><label>Contact No:</label></td>
					<td><input type="number" name="contact"/></td>
				</tr>
				<tr>
					<td><label>Medicine ID:</label></td>
					<td><input type="number" name="mid" /></td>
				</tr>
				<tr>
					<td><label>Medicine name:</label></td>
					<td><input type="text" name="mname"/></td>
				</tr>
				<tr>
					<td><label>Batch no:</label></td>
					<td><input type="number" name="batch"/></td>
				</tr>
				<tr>
					<td><label>Manufactured date:</label></td>
					<td><input type="date" name="mdate" value="<?php echo date('Y-m-d'); ?>" /></td>
				</tr>
				<tr>
					<td><label>Expiry date:</label></td>
					<td><input type="date" name="edate" value="<?php echo date('Y-m-d'); ?>" /></td>
				</tr>
				<tr>
					<td><label>Price:</label></td>
					<td><input type="number" name="price"/></td>
				</tr>
				<tr>
					<td><label>Quantity:</label></td>
					<td><input type="number" name="qty"/></td>
				</tr>
				<tr>
					<td><label>Description:</label></td>
					<td><input type="text" name="desc"/></td>
				</tr>
				<tr>
					<td><label>Purchase date:</label></td>
					<td><input type="date" name="purdate" value="<?php echo date('Y-m-d'); ?>" /></td>
				</tr>
				<tr>
					<td><label for="imageUpload">Select an image file:</label></td>
					<td><input type="file" id="imageUpload" name="imageUpload"></td>
				</tr>
				<tr>
					
					<td><input type="submit" name="submit" value="Purchase"/></td>
					<td><input type="reset" name="reset"/></td>
				</tr>
			</table>
			
		</form>
	</div>	
</body>
</html>
<?php
	include "connect.php";
	if (isset($_POST['submit'])) {
		if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
			// Get the temporary file path
			$tmpFilePath = $_FILES['imageUpload']['tmp_name'];
	
			// Read the file content
			$imgData = file_get_contents($tmpFilePath);
	
			// Escape special characters in binary data
			$escapedImgData = $conn->real_escape_string($imgData);
		}

		if (empty($_POST['sname'])||empty($_POST['sid'])||empty($_POST['address'])||empty($_POST['contact'])
		||empty($_POST['mid'])||empty($_POST['mname'])||empty($_POST['batch'])||empty($_POST['mdate'])
		||empty($_POST['edate'])||empty($_POST['price'])||empty($_POST['qty'])||empty($_POST['desc'])||empty($_POST['purdate'])
		||empty($_FILES['imageUpload'])) {
			
		}else{
		$sname=$_POST['sname'];
		$sid=$_POST['sid'];
		$address=$_POST['address'];
		$contact=$_POST['contact'];
        $mid=$_POST['mid'];
        $mname=$_POST['mname'];
        $batch=$_POST['batch'];
		$mdate=$_POST['mdate'];
		$edate=$_POST['edate'];
		$price=$_POST['price'];
		$qty=$_POST['qty'];
		$desc=$_POST['desc'];
		$purdate=$_POST['purdate'];
        

		$ins_query = "INSERT INTO purchase (s_name, s_id, address, contact, m_id, m_name, batch_no, mft_date,
		 exp_date, price, qty,descript, p_date,image)
		VALUES ('$sname', '$sid', '$address', '$contact', '$mid', '$mname', '$batch', '$mdate', '$edate', '$price', '$qty','$desc', '$purdate', '$escapedImgData')";

			$ins_exe=mysqli_query($conn,$ins_query);
			if (!$ins_exe) {
                die("Query failed: " . mysqli_error($conn));
            }

			if ($ins_exe) {
				header('location:displaymedicine.php');
			}else{
				echo " failed";
			}
		}
	}
?>