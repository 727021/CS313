<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
    array_push($_SESSION['cart'], $_GET['id']);
    var_dump($_SESSION);
} else {
    header("location: index.php");
}

?>