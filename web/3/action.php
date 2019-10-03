<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
    if (!isset($_SESSION['cart'][intval($_GET['id'])])) { $_SESSION['cart'][intval($_GET['id'])] = 1; }
    else { $_SESSION['cart'][intval($_GET['id'])] += 1; }
    echo 1;
} else {
    header("location: index.php");
}

?>