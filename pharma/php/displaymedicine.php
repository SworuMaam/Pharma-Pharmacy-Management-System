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
	<link rel="stylesheet" href="../css/displayS.css">
	<link rel="stylesheet" href="../css/search.css">
	<style>

		.container{
			margin-left: 10px;
		}

		.inp {
            position: relative;
            top: 2px;
            left: 200px;
        }

		.box2 {
			background-color: #E5E4E2;
			margin: 20px;
			margin-top: 15px;
			border-radius: 20px;
			padding: 15px;
    		box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
		}

	</style>
</head>
<body>
	<header>Display</header>

	<nav>
		<a href="dashboard.php">Home</a>
		<a href="m.php">Medicine Records</a>
		<a href="p.php">Patient Records</a>
		<a href="adminTransaction.php">Transaction History</a>
		<a href="n.php">Notifications</a>

		<div class="inp">
			<form method="POST" action="logout.php">
				<input type="submit" name="logout" value="Logout">
			</form>
		</div>
	</nav>

	<div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="search" class="search-bar" placeholder="Search Medicines">
            <button type="submit" name="submit" class="search-btn">Search</button>
        </form>
    </div>

	<div class="container">
		<div class="box2">

			<?php
				include "connect.php";

				if(isset($_POST['submit'])) {
                    // Check if the search query is set
                    $search = isset($_POST['search']) ? $_POST['search'] : '';

                    $searchQuery = $_POST["search"];

                    $sqlSearch = "SELECT * FROM purchase WHERE m_name LIKE '%$searchQuery%'";
                    $sqlSearchExe = $conn->query($sqlSearch);

					echo "<table border=1px>";
					echo "<tr>";
					echo "<th>Medicine ID</th>";
					echo "<th>Medicine Name</th>";
					echo "<th>Batch No</th>";
					echo "<th>Manufacured Date</th>";
					echo "<th>Expiry Date</th>";
					echo "<th>Price</th>";
					echo "<th>Description</th>";
					echo "<th colspan=2>Action</th>";
					echo "</tr>";

					if (!$sqlSearchExe) {
                        die("Query search failed: " . mysqli_error($conn));
                    }elseif($sqlSearchExe->num_rows > 0) {
                        while ($row = $sqlSearchExe->fetch_assoc()) {
                            $Medicine_id=$row['m_id'];
							$Medicine_name=$row['m_name'];
							$Batch_No=$row['batch_no'];
							$Manufacured_date=$row['mft_date'];
							$Expiry_date=$row['exp_date'];
							$Price=$row['price'];
							$Description=$row['descript'];
							

							echo "<tr>";
							echo "<td>$Medicine_id</td>";
							echo "<td>$Medicine_name</td>";
							echo "<td>$Batch_No</td>";
							echo "<td>$Manufacured_date</td>";
							echo "<td>$Expiry_date</td>";
							echo "<td>$Price</td>";
							echo "<td>$Description</td>";
							echo "<td><a href='updatestock.php?m_id=$Medicine_id'>Update</a></td>";
							echo "<td><a href='delmedicine.php?m_name=$Medicine_name '>Delete</a></td>";
							echo "</tr>";
                        }
                    }else {
                        echo "No medicines found.";
                    }
				}else{

					$disQuery="select * from purchase";
					$disExe=mysqli_query($conn,$disQuery);

					echo "<table border=1px>";
						echo "<tr>";
						echo "<th>Medicine ID</th>";
						echo "<th>Medicine Name</th>";
						echo "<th>Batch No</th>";
						echo "<th>Manufacured Date</th>";
						echo "<th>Expiry Date</th>";
						echo "<th>Price</th>";
						echo "<th>Description</th>";
						echo "<th colspan=2>Action</th>";
						echo "</tr>";

						if ($disExe) {
							while ($row=mysqli_fetch_assoc($disExe)) {
								$Medicine_id=$row['m_id'];
								$Medicine_name=$row['m_name'];
								$Batch_No=$row['batch_no'];
								$Manufacured_date=$row['mft_date'];
								$Expiry_date=$row['exp_date'];
								$Price=$row['price'];
								$Description=$row['descript'];
								

								echo "<tr>";
								echo "<td>$Medicine_id</td>";
								echo "<td>$Medicine_name</td>";
								echo "<td>$Batch_No</td>";
								echo "<td>$Manufacured_date</td>";
								echo "<td>$Expiry_date</td>";
								echo "<td>$Price</td>";
								echo "<td>$Description</td>";
								echo "<td><a href='updatestock.php?m_id=$Medicine_id '>Update</a></td>";
								echo "<td><a href='delmedicine.php?m_id=$Medicine_id '>Delete</a></td>";
								echo "</tr>";
							}
						}
					echo "</table>";
				}
			?>

		</div>
	</div>

</body>
</html>

