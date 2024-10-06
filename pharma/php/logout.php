<?php

  session_start();

	if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    echo "<script>window.location.href='login.php';</script>";
    exit();
  }   
?>