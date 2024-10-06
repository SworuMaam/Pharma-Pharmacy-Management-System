<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharma</title>
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

    <header>Medications about to expire</header>

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
                            $sql = "SELECT * FROM purchase";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // echo "No medications found.";
                                while ($row = $result->fetch_assoc()) {
                                    
                                    
                                    $medicationName = $row["m_name"];
                                    $expirationDate = $row["exp_date"];

                                    $currentDate = date("Y-m-d");
                                    $expirationThreshold = 7; // Number of days before expiration to trigger a notification

                                    $expiryDiff = strtotime($expirationDate) - strtotime($currentDate);
                                    $expiryDiffDays = floor($expiryDiff / (60 * 60 * 24));
                                    $count = 0;

                                    if ($expiryDiffDays <= $expirationThreshold && $expiryDiffDays >= 0) {
                                        // echo "Number of rows: " . $result->num_rows . "<br>";

                                        $message = "The medication '$medicationName' will expire in $expiryDiffDays days on $expirationDate.";
                                    
                                        echo $message . "<br>";
                                        $count = $count + 1;
                                    }
                                }
                                if ($count == 0){
                                    echo "None of the medicines are about to expire";
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
