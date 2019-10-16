<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}

// require_once 'inc/db.inc.php';

// $stmt = $db->prepare('SELECT s.survey_id AS id, s.title, c.value AS status FROM surveys.survey s JOIN surveys.common_lookup c ON s.status = c.common_lookup_id WHERE s.user_id=:userid');
// $stmt->bindValue(':userid', $_SESSION['user'], PDO::PARAM_INT);
// $stmt->execute();

// $surveys = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Dashboard - Survey Project</title>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-md">
            <span class="navbar-brand">Dashboard</span>
            <div>
                <span class="navbar-text">Welcome, <a href="user.php"><?php echo $_SESSION['user']['name']; ?></a>!</span>
                <a class="btn btn-outline-info" role="button" href="logout.php">Log Out</a>
            </div>
        </nav>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>