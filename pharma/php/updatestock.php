<?php

    session_start();
    if(isset($_SESSION['user'])){
        include "connect.php";
        $mid = $_GET['m_id'];
    
        $med_query = "SELECT * FROM purchase WHERE m_id = $mid";
        $med_exe = mysqli_query($conn,$med_query);

        if($med_exe) {
            $fetching = mysqli_fetch_assoc($med_exe);
            $sname = $fetching['s_name'];
            $sid = $fetching['s_id'];
            $address = $fetching['address'];
            $contact = $fetching['contact'];
            $medName = $fetching['m_name'];
            $batch = $fetching['batch_no'];
            $manuDate = $fetching['mft_date'];
            $expDate = $fetching['exp_date'];
            $price = $fetching['price'];
            $quantity = $fetching['qty'];
            $description = $fetching['descript'];
            $purDate = $fetching['p_date'];
            $img = $fetching['image'];
        }


    } else{
        session_destroy();
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Stock</title>
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
    <header>Update</header>

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
		<form action="upstock.php" method="POST" enctype="multipart/form-data">
			
				
			<table>
                <tr>
                    <td><label>Suppliers ID:</label></td>
                    <td><input type="number" name="sid" value="<?php echo $sid ?>" readonly/></td>
                </tr>
				<tr>
					<td><label>Suppliers Name:</label></td>
					<td><input type="text" name="sname" value="<?php echo $sname ?>"/></td>
				</tr>
				<tr>
					<td><label>Suppliers Address:</label></td>
					<td><input type="text" name="address" value="<?php echo $address ?>"/></td>
				</tr>
				<tr>
					<td><label>Contact No:</label></td>
					<td><input type="number" name="contact" value="<?php echo $contact ?>"/></td>
				</tr>
				<tr>
					<td><label>Medicine ID:</label></td>
					<td><input type="number" name="mid" value="<?php echo $mid ?>" readonly/></td>
				</tr>
				<tr>
					<td><label>Medicine name:</label></td>
					<td><input type="text" name="mname" value="<?php echo $medName ?>"/></td>
				</tr>
				<tr>
					<td><label>Batch no:</label></td>
					<td><input type="number" name="batch" value="<?php echo $batch ?>"/></td>
				</tr>
				<tr>
					<td><label>Manufactured date:</label></td>
					<td><input type="date" name="mdate" value="<?php echo $manuDate ?>" /></td>
				</tr>
				<tr>
					<td><label>Expiry date:</label></td>
					<td><input type="date" name="edate" value="<?php echo $expDate ?>" /></td>
				</tr>
				<tr>
					<td><label>Price:</label></td>
					<td><input type="number" name="price" value="<?php echo $price ?>"/></td>
				</tr>
				<tr>
					<td><label>Quantity:</label></td>
					<td><input type="number" name="qty" value="<?php echo $quantity ?>"/></td>
				</tr>
				<tr>
					<td><label>Description:</label></td>
					<td><input type="text" name="desc" value="<?php echo $description ?>"/></td>
				</tr>
				<tr>
					<td><label>Purchase date:</label></td>
					<td><input type="date" name="purdate" value="<?php echo $purDate ?>" /></td>
				</tr>
				<tr>
					<td><label for="imageUpload">Select an image file:</label></td>
					<td><input type="file" id="imageUpload" name="imageUpload"></td>
				</tr>
				<tr>
					
					<td><input type="submit" name="submit" value="Update"/></td>
					<td><input type="reset" name="reset"/></td>
				</tr>
			</table>
			
		</form>
	</div>	

</body>
</html>
