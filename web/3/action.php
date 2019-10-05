<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_GET['a'] == "add") {
        if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
        if (!isset($_SESSION['cart'][intval($_POST['id'])])) { $_SESSION['cart'][intval($_POST['id'])] = 1; }
        else { $_SESSION['cart'][intval($_POST['id'])] += 1; }
        echo intval($_POST['id']);
    } elseif ($_GET['a'] == "rem") {
        if (isset($_SESSION['cart']) && isset($_SESSION['cart'][intval($_POST['id'])])) {
            $i = intval($_SESSION['cart'][intval($_POST['id'])]);
            if ($i > 0) {
                $_SESSION['cart'][intval($_POST['id'])] -= 1;
                echo intval($_POST['id']);
            } else {
                echo 0;
            }
        }
    }
} else {
    header("location: index.php");
}

?>