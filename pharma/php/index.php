<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharma</title>
    <link rel="stylesheet" href="../css/basic.css">
</head>
<body>
    <header>Welcome to Pharma</header>

    <nav>
        <a href="index.php">Home</a>
        <a href="transactionHistory.php">Transaction History</a>

        <form method="post">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </nav>

    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="search" class="search-bar" placeholder="Search Medicines">
            <button type="submit" name="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div class="medicine-container">
        <?php 
            // Start the session (if not started)
            if(isset($_SESSION['user'])) {
                include "connect.php";

                if(isset($_POST['submit'])) {
                    // Check if the search query is set
                    $search = isset($_POST['search']) ? $_POST['search'] : '';

                    $searchQuery = $search;

                    $sqlSearch = "SELECT * FROM purchase WHERE m_name LIKE '%$searchQuery%'";
                    $sqlSearchExe = $conn->query($sqlSearch);
                    
                    if (!$sqlSearchExe) {
                        die("Query search failed: " . mysqli_error($conn));
                    }elseif($sqlSearchExe->num_rows > 0) {
                        while ($row = $sqlSearchExe->fetch_assoc()) {
                            echo '<div class="medicine-card">';
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="' . $row['m_name'] . '" class="medicine-image">';
                            echo '<h3>' . $row['m_name'] . '</h3>';
                            echo '<p>' .'Rs.' . $row['price'] . '</p>';
                            echo '<form method="post">';
                                echo '<input type="hidden" name="medicine_id" value="' . $row['m_id'] . '">';
                                echo '<input type="number" name="quantity" placeholder="1" value="1" min="1" max="10" class="quantity-input"><br>';
                                echo '<button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>';
                            echo '</form>';
                            echo '</div>';
                        }
                    }else {
                        echo "No medicines found.";
                    }
                }else{
                    $sql = "SELECT * FROM purchase";
                    $result = mysqli_query($conn,$sql);
                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="medicine-card">';
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="' . $row['m_name'] . '" class="medicine-image">';
                            echo '<h3>' . $row['m_name'] . '</h3>';
                            echo '<p>' .'Rs.' . $row['price'] . '</p>';
                            echo '<form method="post">';
                                echo '<input type="hidden" name="medicine_id" value="' . $row['m_id'] . '">';
                                echo '<input type="number" name="quantity" placeholder="1" value="1" min="1" max="10" class="quantity-input"><br>';
                                echo '<button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>';
                            echo '</form>';
                            echo '</div>';
                        }
                    } else {
                        echo "No medicines found.";
                    } 
                }
                // Display the "View Cart" button
                echo '<div class="view-cart-btn-container">';
                echo '<form method="post" action="cart.php">';
                echo '<button type="submit" name="view_cart" class="view-cart-btn">View Cart</button>';
                echo '</form>';
                echo '</div>';
                // Handle adding to cart
                if (isset($_POST['add_to_cart'])) {
                    // Check if the cart session variable is set, if not, initialize it
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = array();
                    }

                    // Get the medicine ID from the form submission
                    $medicineId = $_POST['medicine_id'];
                    $quantity = $_POST['quantity'];

                    // Check if the medicine is already in the cart

                    if (!isset($_SESSION['cart'][$medicineId])) {
                        // Add the medicine ID and quantity to the cart
                        $_SESSION['cart'][$medicineId] = $quantity;
                    } else {
                        // If the medicine is already in the cart, update the quantity
                        $_SESSION['cart'][$medicineId] += $quantity;
                    }
                     
                }
            }else {
                header("Location: login.php");
                session_destroy();
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
