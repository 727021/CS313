<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
    if (!isset($_SESSION['cart'][intval($_POST['id'])])) { $_SESSION['cart'][intval($_POST['id'])] = 1; }
    else { $_SESSION['cart'][intval($_POST['id'])] += 1; }
    echo intval($_POST['id']);
} else {
    header("location: index.php");
}

?>