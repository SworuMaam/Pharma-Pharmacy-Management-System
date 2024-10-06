<?php
// Start the session (if not started)
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    session_destroy();
    exit();
}

// Include the connection file
include "connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <!-- Add your CSS styles here -->
    <link rel="stylesheet" href="../css/basic.css">
    <link rel="stylesheet" href="../css/transaction.css">

    <style>
         /* body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #617487;
        }
        
        header {
            background-color: #2c3e50;
            padding: 20px;
            text-align: center;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: default;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #34495e;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #2980b9;
        } */

        /* .transaction-history-container {
            margin: 20px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow-x: auto;
        } */

        /* table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:hover {
            background-color: #706f6f;
        } */

        /* .no-history {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        } */
    </style>
</head>
<body>
    <header>Transaction History</header>
    <nav>   
        <a href="index.php">Home</a>
        <a href="transactionHistory.php">Transaction History</a>

        <form method="post">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </nav>

    <div class="transaction-history-container">
        <?php
            // Fetch transaction history from the database
            // var_dump($_SESSION['user']);
            $userId = $_SESSION['id'];
            // $userId = $_SESSION['user']['id'];
            $sqlTransactionHistory = "SELECT * FROM transaction WHERE u_id = '$userId'";
            $resultTransactionHistory = mysqli_query($conn, $sqlTransactionHistory);

            if (!$resultTransactionHistory) {
                die("Query failed: " . mysqli_error($conn));
            }

            // Display transaction history
            if ($resultTransactionHistory->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Date</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Status</th></tr>";

                while ($rowTransaction = $resultTransactionHistory->fetch_assoc()) {
                    $anotherDatabaseId = $rowTransaction['m_id']; // Adjust the field name accordingly
                    $sqlAnotherDatabase = "SELECT m_name FROM purchase WHERE m_id = '$anotherDatabaseId'";
                    $resultAnotherDatabase = mysqli_query($conn, $sqlAnotherDatabase);

                    if (!$resultAnotherDatabase) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    $rowAnotherDatabase = $resultAnotherDatabase->fetch_assoc();

                    echo "<tr>";
                    echo "<td>" . $rowTransaction['t_date'] . "</td>";
                    echo "<td>" . $rowAnotherDatabase['m_name'] . "</td>";
                    echo "<td>" . $rowTransaction['quty'] . "</td>";
                    echo "<td>" . 'Rs.' . $rowTransaction['total_price'] . "</td>";
                    echo "<td>" . $rowTransaction['status'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p class='no-history'>No transaction history.</p>";
            }
            // Check if the logout button is clicked
            if (isset($_POST['logout'])) {
                // Destroy the session and redirect to the login page
                session_destroy();
                echo "<script>window.location.href='login.php';</script>";
                exit();
            } 
        ?>
    </div>
</body>
</html>
