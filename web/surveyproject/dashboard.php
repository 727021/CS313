<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}
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
    <div class="container bg-light">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="2">Title</th>
                        <th>Responses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'inc/db.inc.php';

                    $stmt = $db->prepare('SELECT s.survey_id AS id, s.title, c.value AS status FROM surveys.survey s JOIN surveys.common_lookup c ON s.status = c.common_lookup_id WHERE s.user_id=:userid');
                    $stmt->bindValue(':userid', $_SESSION['user']['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    $surveys = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Insert a row for each survey on the account
                    foreach ($surveys as $survey) {
                    ?>
                    <tr>
                        <td class="text-right">
                            <?php
                            switch (strtolower($survey['status'])) {
                                case "unpublished":
                                ?><span class="badge badge-pill badge-primary">Unpublished</span>
                                <?php
                                break;
                                case "published":
                                ?><span class="badge badge-pill badge-success">Published</span>
                                <?php
                                break;
                                case "closed":
                                ?><span class="badge badge-pill badge-danger">Closed</span>
                                <?php
                                break;
                                default:
                                break;
                            }
                            ?>
                        </td>
                        <td><a href="preview.php?id=<?php echo $survey['id']; ?>"><?php echo $survey['title']; ?></a></td>
                        <td class="text-center">
                            <?php
                            $stmt = $db->prepare('SELECT COUNT(response_id) FROM surveys.responses WHERE survey_id=:sid');
                            $stmt->bindValue(':sid', $survey['id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $responses = $stmt->fetch();
                            echo $responses;
                            ?>
                        </td>
                        <td class="text-right">
                            <?php
                            switch (strtolower($survey['status'])) {
                                case "unpublished":
                                ?>
                                <a href="dashboard.php?publish=<?php echo $survey['id']; ?>" class="btn btn-success">Publish</a>
                                <a href="edit.php?id=<?php echo $survey['id']; ?>" class="btn btn-info">Edit</a>
                                <a href="dashboard.php?delete=<?php echo $survey['id']; ?>" class="btn btn-danger">Delete</a>
                                <?php
                                break;
                                case "published":
                                ?>
                                <a href="dashboard.php?close=<?php echo $survey['id']; ?>" class="btn btn-danger">Close</a>
                                <?php
                                break;
                                case "closed":
                                ?>
                                <a href="results.php?id=<?php echo $survey['id']; ?>" class="btn btn-info">Results</a>
                                <a href="dashboard.php?delete=<?php echo $survey['id']; ?>" class="btn btn-danger">Delete</a>
                                <?php
                                break;
                                default:
                                break;
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>




                    <!-- <tr>
                        <td class="text-right"><span class="badge badge-pill badge-primary">Unpublished</span></td>
                        <td><a href="preview.php?id=1">Survey Title</a></td>
                        <td class="text-center">0</td>
                        <td class="text-right">
                            <a href="dashboard.php?publish=1" class="btn btn-success">Publish</a>
                            <a href="edit.php?id=1" class="btn btn-info">Edit</a>
                            <a href="dashboard.php?delete=1" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right"><span class="badge badge-pill badge-success">Published</span></td>
                        <td><a href="preview.php?id=2">Survey Title</a></td>
                        <td class="text-center">15</td>
                        <td class="text-right">
                            <a href="dashboard.php?close=2" class="btn btn-danger">Close</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right"><span class="badge badge-pill badge-danger">Closed</span></td>
                        <td><a href="preview.php?id=3">Survey Title</a></td>
                        <td class="text-center">56</td>
                        <td class="text-right">
                            <a href="results.php?id=3" class="btn btn-info">Results</a>
                            <a href="dashboard.php?delete=3" class="btn btn-danger">Delete</a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>