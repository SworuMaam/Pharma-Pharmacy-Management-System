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
            left: 290px;
        }

    </style>
</head>
<body>
    <header>Dashboard</header>

    <nav>
        <a href="dashboard.php">Home</a>
        <a href="m.php">Medicine Records</a>
        <a href="p.php">Patient Records</a>
        <a href="adminTransaction.php">Transaction History</a>

        <div class="inp">
            <form method="POST" action="logout.php">
                <input type="submit" name="logout" value="Logout">
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="box2">
            <a href="purchase.php"><img src="../Images/purchasemedicine.jpg"></a>
        </div>
        <div class="box2">
            <a href="../php/displaymedicine.php"><img src="../Images/displaymedicine.jpg"></a>
        </div>
        <!-- <div class="box2">
            <a href="stock.php"><img src="../Images/stock.jpg"></a>
        </div> -->
    </div>

</body>
</html>