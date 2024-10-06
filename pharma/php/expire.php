 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dash.css">
	<link rel="stylesheet" href="../css/displayS.css">
    <style>

		.container{
			margin-left: 10px;
		}

		.inp {
            position: relative;
            top: 2px;
            left: 220px;
        }

		.box2 {
			background-color: #E5E4E2;
			margin: 20px;
			margin-top: 20px;
			border-radius: 20px;
			padding: 15px;
    		box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
		}
        tr:hover{
            background-color: transparent;
        }

	</style>
</head>
<body>

    <header>Expired Medications</header>

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

    <div class="container">

        <div class="box2">
            <table>
                <tr style="text-align:center;margin-left:300px;">
                    <td>  

                        <?php
                            include "connect.php";  
                            $currentDate = date("Y-m-d");
                            $sql = "SELECT * FROM purchase WHERE exp_date<CURDATE()";
                            $result = $conn->query($sql);
                            ini_set('display_errors', 1);
                            error_reporting(E_ALL);
                            if (!$result) {
                                die("SQL query error: " . $conn->error);
                            }
                            // echo "Number of rows: " . $result->num_rows . "<br>";
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $medicationName = $row["m_name"];
                                    $expirationDate = $row["exp_date"];
                                    
                                        $message = "The medication '$medicationName' has expired on $expirationDate.";
                                        echo $message . "<br>";

                                }
                            } else {
                                echo "No medications found.";
                            }

                        ?>

                    </td>

                    <td>
                        <form action="purchase.php" method="POST">
                            <input type="submit" value="Purchase">
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>  
</body>
</html> 



