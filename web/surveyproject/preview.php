<?php
session_start();

if (!isset($_GET['id'])) {
    header('location: dashboard.php');
    exit;
}

require_once 'inc/question.class.php';
require_once 'inc/db.inc.php';

$sid = intval($_GET['id']); // Survey id

$pid = isset($_GET['p']) ? intval($_GET['p']) : 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Preview - Survey Project</title>
</head>
<body>


    <?php include 'inc/js.inc.php'; ?>
</body>
</html>