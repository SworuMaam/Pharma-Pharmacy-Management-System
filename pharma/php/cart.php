<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/basic.css">
    <!-- <style>
        body {
            font-family: Arial, sans-serif;
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
        }

        .medicine-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .medicine-card {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            max-width: 200px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);
            transition: box-shadow 0.3s ease;
            text-align: center;
        }

        .medicine-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .medicine-image {
            max-width: 100%;
            height: auto;
        }
        .remove-from-cart-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .remove-from-cart-btn:hover {
            background-color: #c0392b;
        }
    </style> -->
</head>
<body>
    <header>My Cart</header>
    <nav>   
        <a href="index.php">Home</a>
        <a href="transactionHistory.php">Transaction History</a>

        <form method="post">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </nav>
</body>
</html>
<?php
    
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['user'])) {
        
        include "connect.php";

        // Check if the cart session variable is set
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Fetch medicines from the database based on the cart items
            $cartItems = array_keys($_SESSION['cart']);//U
            $sqlCart = "SELECT * FROM purchase WHERE m_id IN (" . implode(',', $cartItems) . ")";//U
            //$cartItems = implode(',', $_SESSION['cart']);
            //$sqlCart = "SELECT * FROM purchase WHERE m_id IN ($cartItems)";
            $resultCart = mysqli_query($conn, $sqlCart);

            if (!$resultCart) {
                die("Query failed: " . mysqli_error($conn));
            }

            // Display cart items
            if ($resultCart->num_rows > 0) {
                echo "<div class='medicine-container'>";

                while ($rowCart = $resultCart->fetch_assoc()) {
                    $medicineId = $rowCart['m_id'];
                    $quantity = $_SESSION['cart'][$medicineId];
            
                    // Calculate the total price for the item
                    $totalPrice = $quantity * $rowCart['price'];

                    echo '<div class="medicine-card">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($rowCart['image']) . '" alt="' . $rowCart['m_name'] . '" class="medicine-image">';
                    echo '<h3>' . $rowCart['m_name'] . '</h3>';
                    echo '<p>' . 'Rs.' . $rowCart['price'] . ' each</p>';
                    echo '<p>Quantity: ' . $quantity . '</p>';
                    echo '<p>Total: Rs.' . $totalPrice . '</p>';
                    // echo '<form method="post">';
                    //     echo '<input type="hidden" name="remove_medicine_id" value="' . $rowCart['m_id'] . '">';
                    //     echo '<input type="hidden" name="purchase_quantity" value="' . $quantity . '">';
                    //     echo '<input type="hidden" name="purchase_price" value="' . $totalPrice . '">';
                    //     echo '<button type="submit" name="purchase_btn" class="purchase-btn">Purchase</button>';
                    // echo '</form>';
                    echo '<form method="post">';
                        echo '<input type="hidden" name="remove_medicine_id" value="' . $rowCart['m_id'] . '">';
                        echo '<button type="submit" name="remove_from_cart" class="remove-from-cart-btn">Remove from Cart</button>';
                    echo '</form>';
                    echo '</div>';
                }
                echo "</div>";
                // single "Purchase" button outside the loop
                echo '<form method="post">';
                echo '<button type="submit" name="purchase_btn" class="purchase-btn">Purchase All</button>';
                echo '</form>';
            } else {
                echo "Your cart is empty.";
            }
        } else {
            echo "Your cart is empty.";
        }
    } else {
        // Redirect to login page if not logged in
        header("Location: login.php");
        session_destroy();
    }
    // Handle purchase button click
    if (isset($_POST['purchase_btn'])) {
        // insert the entire cart as a transaction into the database
        // $userId = $_SESSION['user']['id'];
        //var_dump($_SESSION['user']);
        // $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
        $userId = $_SESSION['id'];
        $date = date("Y-m-d H:i:s");
        $status = "Pending"; // You can set an initial status

        // Loop through each item in the cart
        foreach ($_SESSION['cart'] as $medicineId => $quantity) {
            // Fetch the medicine details from the database
            $sqlMedicine = "SELECT * FROM purchase WHERE m_id = $medicineId";
            $resultMedicine = mysqli_query($conn, $sqlMedicine);

            if (!$resultMedicine) {
                die("Query failed: " . mysqli_error($conn));
            }

            $rowMedicine = $resultMedicine->fetch_assoc();
            $product_id = $rowMedicine['m_id'];
            $totalPrice = $quantity * $rowMedicine['price'];

            // Add the transaction for each item
            $sqlInsertTransaction = "INSERT INTO transaction (u_id, m_id, quty, total_price, t_date, status) VALUES ('$userId', '$product_id', '$quantity', '$totalPrice', '$date', '$status')";
            
            $resultInsertTransaction = mysqli_query($conn, $sqlInsertTransaction);

            if (!$resultInsertTransaction) {
                die("Query failed: " . mysqli_error($conn));
            }
        }

        // Clear the entire cart after purchase
        $_SESSION['cart'] = array();

        // Refresh the page to update the cart display
        echo "<script>window.location.href='cart.php';</script>";
        exit();
    }

    // Handle removing from cart
    if (isset($_POST['remove_from_cart'])) {
        $removeMedicineId = $_POST['remove_medicine_id'];

        // Remove the medicine from the cart session variable
        //$_SESSION['cart'] = array_diff($_SESSION['cart'], [$removeMedicineId]);

        // Check if the medicine ID exists in the cart: Updated
        if (isset($_SESSION['cart'][$removeMedicineId])) {
            // Unset the specific key associated with the medicine ID
            unset($_SESSION['cart'][$removeMedicineId]);
        }

        // Refresh the page to update the cart display
        echo "<script>
                window.location.href='cart.php';</script>";
        exit();
    }
     // Check if the logout button is clicked
     if (isset($_POST['logout'])) {
        // Destroy the session and redirect to the login page
        session_destroy();
        echo "<script>window.location.href='login.php';</script>";
        exit();
    } 
?>
