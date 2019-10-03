<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    array_push($_SESSION['cart'], $_GET['id']);
    var_dump($_SESSION);
} else {
    header("location: index.php");
}

?>