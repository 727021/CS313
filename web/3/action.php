<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['id'])) {
        array_push($_SESSION['cart'], $_POST['id']);
        echo 1;
    }
    echo 0;
} else {
    header("location: index.php");
}

?>