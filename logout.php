<?php

    session_start();

    if(isset($_SESSION['user'])){
      session_unset();
      $_SESSION["success"] = "Logout Success";
      header('Location:login.php');
      return;
    }
    
?>