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

// Check if the user is an admin
// if ($_SESSION['user']['role'] !== 'admin') {
//     // Redirect to a different page 
//     header("Location: ");
//     exit();
// }

if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] !== 'admin') {
    // Redirect to a different page 
    header("Location: dashboard.php");
    exit();
}

// Approve, reject and pending transaction logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $retriveStatus = $_POST['status'];
    $transactionId = $_POST['transaction_id'];
    $transactionQty = $_POST['transaction_qty'];
    $newStatus = $_POST['status'];
    
    if ($retriveStatus == 'accept') {

        // echo "Transaction ID to approve: $transactionId";

        $sqlSelectMid = "SELECT m_id FROM transaction WHERE t_id = $transactionId";
        $sqlSelectMidExe = mysqli_query($conn,$sqlSelectMid);

        if(!$sqlSelectMidExe) {
            die(mysqli_error($conn));
        } else {
            $tRow = mysqli_fetch_assoc($sqlSelectMidExe);
            $tMid = $tRow['m_id'];
            $sqlSelectQty = "SELECT qty FROM purchase WHERE m_id = $tMid";
            $sqlSelectQtyExe = mysqli_query($conn,$sqlSelectQty);

            if(!$sqlSelectQtyExe) {
                die(mysqli_error($conn));
            } else {
                $purchaseRow = mysqli_fetch_assoc($sqlSelectQtyExe);
                $purchaseQty = $purchaseRow['qty'];

                if($purchaseQty >= $transactionQty) {

                    $newQty = $purchaseQty - $transactionQty;

                    $sqlUpdatePurchaseQty = "UPDATE purchase SET qty = $newQty WHERE m_id = $tMid";
                    $sqlUpdatePurchaseQtyExe =  mysqli_query($conn,$sqlUpdatePurchaseQty);

                    if (!$sqlUpdatePurchaseQtyExe) {
                        die("Update failed: " . mysqli_error($conn));
                    } else {
                        // Update the transaction as approved
                        $sqlUpdateApproval = "UPDATE transaction SET approved = 1, status = '$newStatus' WHERE t_id = $transactionId";
                        $resultUpdateApproval = mysqli_query($conn, $sqlUpdateApproval);

                        if (!$resultUpdateApproval) {
                            die("Update failed: " . mysqli_error($conn));
                        }
                    }
                    
                } else {
                    echo "Request cannot be fullfilled, as the medicine in stock is ".$purchaseQty." requested quantity is ".$transactionQty;
                }
            }

        }

        
    } elseif ($retriveStatus == 'reject') {
        // echo "Transaction ID to approve: $transactionId";
        
        // Update the transaction as reject
        $sqlUpdateReject = "UPDATE transaction SET approved = 2, status = '$newStatus' WHERE t_id = $transactionId";
        $resultUpdateReject = mysqli_query($conn, $sqlUpdateReject);
    
        if (!$sqlUpdateReject) {
            die("Update failed: " . mysqli_error($conn));
        } 
    } elseif ($retriveStatus == 'pending') {
        // echo "Transaction ID to approve: $transactionId";
        
        // Update the transaction as pending
        $sqlUpdateReject = "UPDATE transaction SET approved = 0, status = '$newStatus' WHERE t_id = $transactionId";
        $resultUpdateReject = mysqli_query($conn, $sqlUpdateReject);
    
        if (!$sqlUpdateReject) {
            die("Update failed: " . mysqli_error($conn));
        } 
    }

}

// Handle status update
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
//     $transactionId = $_POST['transaction_id'];
//     $newStatus = $_POST['status'];

//     // Update the status of the transaction
//     $sqlUpdateStatus = "UPDATE transaction SET status = '$newStatus' WHERE t_id = $transactionId";
//     $resultUpdateStatus = mysqli_query($conn, $sqlUpdateStatus);

//     if (!$resultUpdateStatus) {
//         die("Update failed: " . mysqli_error($conn));
//     }
// }






// reject transaction logic
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
//     $transactionId = $_POST['transaction_id'];
//     echo "Transaction ID to approve: $transactionId";
    
//     // Update the transaction as approved
//     $sqlUpdateReject = "UPDATE transaction SET approved = 2 WHERE t_id = $transactionId";
//     $resultUpdateReject = mysqli_query($conn, $sqlUpdateReject);

//     if (!$sqlUpdateReject) {
//         die("Update failed: " . mysqli_error($conn));
//     }
// }

// Handle status update
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
//     $transactionId = $_POST['transaction_id'];
//     $newStatus = $_POST['status'];

//     // Update the status of the transaction
//     $sqlUpdateStatus = "UPDATE transaction SET status = '$newStatus' WHERE t_id = $transactionId";
//     $resultUpdateStatus = mysqli_query($conn, $sqlUpdateStatus);

//     if (!$resultUpdateStatus) {
//         die("Update failed: " . mysqli_error($conn));
//     }
// }

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$filterCondition = '';

if ($filter !== 'all') {
    $filterCondition = "WHERE status = '$filter'";
}

// $sqlTransactionFilter = "SELECT * FROM transaction $filterCondition";
// $sqlTransactionFilterExe = mysqli_query($conn, $sqlTransactionFilter);

// if (!$sqlTransactionFilterExe) {
//     die("filter failed: " . mysqli_error($conn));
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="../css/basic.css">
    <link rel="stylesheet" href="../css/transaction.css">
    <style>
        /* your existing styles */
    </style>
</head>
<body>
    <header>Transaction History</header>
    <nav>   
        <a href="dashboard.php">Home</a>
        <a href="adminTransaction.php">Transaction History</a>

        <form method="post">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>

        <form method="get">
            <label>Filter:</label>
            <input type="radio" name="filter" value="all" <?php echo ($filter === 'all') ? 'checked' : ''; ?>> All
            <input type="radio" name="filter" value="accept" <?php echo ($filter === 'accept') ? 'checked' : ''; ?>> Approved
            <input type="radio" name="filter" value="reject" <?php echo ($filter === 'reject') ? 'checked' : ''; ?>> Rejected
            <input type="radio" name="filter" value="pending" <?php echo ($filter === 'pending') ? 'checked' : ''; ?>> Pending
            <button type="submit">Apply Filter</button>
        </form>
    </nav>

    <div class="transaction-history-container">
        <?php
            // Fetch unapproved transaction history from the database
            $sqlTransactionHistory = "SELECT * FROM transaction $filterCondition";
            $resultTransactionHistory = mysqli_query($conn, $sqlTransactionHistory);

            if (!$resultTransactionHistory) {
                die("Query failed: " . mysqli_error($conn));
            }

            // Display unapproved transaction history
            if ($resultTransactionHistory->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Date</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Status</th><th>Action</th></tr>";

                while ($rowTransaction = $resultTransactionHistory->fetch_assoc()) {
                    $anotherDatabaseId = $rowTransaction['m_id']; // Adjust the field name accordingly
                    $sqlAnotherDatabase = "SELECT m_name FROM purchase WHERE m_id = '$anotherDatabaseId'";
                    $resultAnotherDatabase = mysqli_query($conn, $sqlAnotherDatabase);

                    if (!$resultAnotherDatabase) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    $rowAnotherDatabase = $resultAnotherDatabase->fetch_assoc();

                    // Check if the transaction is approved
                    if ($rowTransaction['approved'] == 1) {
                        // Transaction is already approved, display status without form
                        echo "<tr>";
                        echo "<td>" . $rowTransaction['t_date'] . "</td>";
                        echo "<td>" . $rowAnotherDatabase['m_name'] . "</td>";
                        echo "<td>" . $rowTransaction['quty'] . "</td>";
                        echo "<td>" . 'Rs.' . $rowTransaction['total_price'] . "</td>";
                        echo "<td>" . $rowTransaction['status'] . "</td>";
                        echo "<td>Approved</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                        echo "<td>" . $rowTransaction['t_date'] . "</td>";
                        echo "<td>" . $rowAnotherDatabase['m_name'] . "</td>";
                        echo "<td>" . $rowTransaction['quty'] . "</td>";
                        echo "<td>" . 'Rs.' . $rowTransaction['total_price'] . "</td>";
                        
    
                        // Use a form to submit the status change
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='transaction_id' value='" . $rowTransaction['t_id'] . "'>";
                        echo "<input type='hidden' name='transaction_qty' value='" . $rowTransaction['quty'] . "'>";
    
                        echo "<td>";
                        // Create a dropdown list with options
                        echo "<select name='status'>";
                        echo "<option value='-1'>Select</option>";
                        echo "<option value='accept'>Accept</option>";
                        echo "<option value='reject'>Reject</option>";
                        echo "<option value='pending'>Pending</option>";
                        echo "</select>";
                        echo "</td>";
    
                        echo "<td>";
                        // Add a submit button
                        echo "<button type='submit' name='update_status'>Update</button>";
                        echo "</form>";
    
                        echo "</td>";
                        echo "</tr>";
                    }
                }

                echo "</table>";
            } else {
                echo "<p class='no-history'>No transactions matching filter.</p>";
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
