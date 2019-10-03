<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    array_push($_SESSION['cart'], $_GET['id']);
    echo 1;
} else {
    header("location: index.php");
}

?>