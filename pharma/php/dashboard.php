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
</head>
<body>
    <header>Welcome to Pharma</header>
    <div class="nav">
        <p>Dashboard</p>
        <div class="inp">
            <form method="POST" action="logout.php">
                <input type="submit" name="logout" value="Logout">
            </form>
        </div>
    </div>
    <div class="container">
        <div class="box2">
            <a href="m.php"><img src="../Images/medicinerecord.jpg" alt="Medicine Record"></a>
        </div>
        <div class="box2">
            <a href="p.php"><img src="../Images/patientrecord.jpg" alt="Patient Record"></a>
        </div>
        <div class="box2">
            <a href="n.php"><img src="../Images/notification.jpg" alt="Notification"></a>
        </div>
        <!-- <div class="box2">
            <a href="../php/s.php"><img src="../Images/search.jpg" alt="Search"></a>
        </div> -->
    
    </div>

</body>
</html>