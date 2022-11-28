<?php

session_destroy();

// Start or Resume the session
session_start();
session_unset();
header("Location:login.php");
?>
