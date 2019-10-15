<?php
session_start();

session_unset();
session_destroy();

// Redirect to homepage
header('location: index.php?logout');
?>