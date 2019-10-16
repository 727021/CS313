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
<body class="bg-info">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">Dashboard</span>
            <span class="navbar-text text-light">Welcome, <a href="user.php"><?php echo $_SESSION['user']['name']; ?></a>!  <a class="btn btn-sm btn-info" role="button" href="logout.php">Log Out</a></span>
        </div>
    </nav>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-light">
                <thead>
                    <tr>
                        <th colspan="2">Title</th>
                        <th>Responses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-right"><span class="badge badge-pill badge-primary">Unpublished</span></td>
                        <td><a href="preview.php?id=1">Survey Title</a></td>
                        <td>0</td>
                        <td class="text-right">
                            <a href="dashboard.php?publish=1" class="btn btn-success">Publish</a>
                            <a href="edit.php?id=1" class="btn btn-info">Edit</a>
                            <a href="dashboard.php?delete=1" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right"><span class="badge badge-pill badge-success">Published</span></td>
                        <td><a href="preview.php?id=2">Survey Title</a></td>
                        <td>15</td>
                        <td class="text-right">
                            <a href="dashboard.php?close=2" class="btn btn-danger">Close</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right"><span class="badge badge-pill badge-danger">Closed</span></td>
                        <td><a href="preview.php?id=3">Survey Title</a></td>
                        <td>56</td>
                        <td class="text-right">
                            <a href="results.php?id=3" class="btn btn-info">Results</a>
                            <a href="dashboard.php?delete=3" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>