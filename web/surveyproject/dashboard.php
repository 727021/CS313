<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}
require_once 'inc/db.inc.php';
try {
if (isset($_GET['publish'])) {
    $stmt_publish = $db->prepare('SELECT LOWER(cl.value) AS status, s.title FROM surveys.common_lookup cl, surveys.survey s WHERE s.status = cl.common_lookup_id AND s.survey_id = :id');
    $stmt_publish->bindValue(':id', $_GET['publish'], PDO::PARAM_INT);
    $stmt_publish->execute();

    if ($row = $stmt_publish->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] === "unpublished") {
            $stmt_publish_upd = $db->prepare("UPDATE surveys.survey SET status = (SELECT common_lookup_id FROM surveys.common_lookup WHERE context = 'SURVEY.STATUS' AND value = 'PUBLISHED') WHERE survey_id = :id");
            $stmt_publish_upd->bindValue(':id', $_GET['publish'], PDO::PARAM_INT);
            $stmt_publish_upd->execute();

            // Survey shortcode is created when the survey is published
            $stmt_create_shc = $db->prepare('INSERT INTO surveys.shortcode (survey_id,code) VALUES (:id, :code)');
            $stmt_create_shc->bindValue(':id', $_GET['publish'], PDO::PARAM_INT);
            $stmt_create_shc->bindValue(':code', md5(uniqid($_GET['publish'] . $row['title'])), PDO::PARAM_STR);
            $stmt_create_shc->execute();

            // Redirect so the GET data doesn't stay in the url
            header('location: dashboard.php');
        }
    }
}
} catch (PDOException $ex) { die($ex->getMessage()); }

if (isset($_GET['close'])) {
    $stmt_close = $db->prepare('SELECT LOWER(cl.value) AS status FROM surveys.common_lookup cl, surveys.survey s WHERE s.status = cl.common_lookup_id AND s.survey_id = :id');
    $stmt_close->bindValue(':id', $_GET['close'], PDO::PARAM_INT);
    $stmt_close->execute();

    if ($row = $stmt_close->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] === "published") {
            $stmt_close_upd = $db->prepare("UPDATE surveys.survey SET status = (SELECT common_lookup_id FROM surveys.common_lookup WHERE context = 'SURVEY.STATUS' AND value = 'CLOSED') WHERE survey_id = :id");
            $stmt_close_upd->bindValue(':id', $_GET['close'], PDO::PARAM_INT);
            $stmt_close_upd->execute();

            $stmt_close_shc = $db->prepare('DELETE FROM surveys.shortcode WHERE survey_id = :id');
            $stmt_close_shc->bindValue(':id', $_GET['close'], PDO::PARAM_INT);
            $stmt_close_shc->execute();

            // Redirect so the GET data doesn't stay in the url
            header('location: dashboard.php');
        }
    }
}

if (isset($_GET['delete'])) {
    $stmt_delete = $db->prepare('SELECT LOWER(cl.value) AS status FROM surveys.common_lookup cl, surveys.survey s WHERE s.status = cl.common_lookup_id AND s.survey_id = :id');
    $stmt_delete->bindValue(':id', $_GET['delete'], PDO::PARAM_INT);
    $stmt_delete->execute();

    if ($row = $stmt_delete->fetch(PDO::FETCH_ASSOC)) {
        if ($row['status'] === "unpublished" || $row['status'] === "closed") {
            $stmt_delete_upd = $db->prepare("DELETE FROM surveys.survey WHERE survey_id = :id");
            $stmt_delete_upd->bindValue(':id', $_GET['delete'], PDO::PARAM_INT);
            $stmt_delete_upd->execute();

            // Redirect so the GET data doesn't stay in the url
            header('location: dashboard.php');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Dashboard - Survey Project</title>
</head>
<body class="bg-info no-select">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">Dashboard</span>
            <span class="navbar-text text-light">Welcome, <a href="user.php"><?php echo $_SESSION['user']['name']; ?></a>!  <a class="btn btn-sm btn-info" role="button" href="logout.php">Log Out</a></span>
        </div>
    </nav>
    <div class="container bg-light mt-2 rounded">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center align-middle" colspan="2">Title</th>
                        <th class="text-center align-middle">Responses</th>
                        <th class="text-center align-middle">Actions</th>
                        <th class="text-right pl-0 pr-1"><a href="create.php" role="button" class="btn btn-success"><i class="fas fa-plus"></i> New</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'inc/db.inc.php';

                    $stmt = $db->prepare('SELECT s.survey_id AS id, s.title, c.value AS status FROM surveys.survey s, surveys.common_lookup c WHERE s.status = c.common_lookup_id AND s.user_id=:userid ORDER BY c.common_lookup_id, id');
                    $stmt->bindValue(':userid', $_SESSION['user']['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    // Insert a row for each survey on the account
                    while ($survey = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td class="text-right align-middle">
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
                        <td class="align-middle">
                            <?php
                                if (strtolower($survey['status']) == 'closed') {
                                    echo '<p class="text-primary mb-0">' . ($survey['title'] ? $survey['title'] : 'Survey') . '</p>';
                                } else {
                                    echo '<a href="preview.php?id=' . $survey['id'] . '">' . ($survey['title'] ? $survey['title'] : 'Survey') . '</a>';
                                }
                            ?>
                        </td>
                        <td class="text-center align-middle">
                            <?php
                            $stmt1 = $db->prepare('SELECT COUNT(response_id) FROM surveys.response WHERE survey_id=:surveyid');
                            $stmt1->bindValue(':surveyid', $survey['id'], PDO::PARAM_INT);
                            $stmt1->execute();
                            $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                            echo $result['count'];
                            ?>
                        </td>
                        <td class="text-right align-middle">
                            <?php
                            switch (strtolower(trim($survey['status']))) {
                                case "unpublished":
                                ?>
                                <a href="dashboard.php?publish=<?php echo $survey['id']; ?>" class="btn btn-success">Publish</a>
                                <a href="edit.php?id=<?php echo $survey['id']; ?>" class="btn btn-info">Edit</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-modal-<?php echo $survey['id']; ?>">Delete</button>
                                <div class="modal fade" id="delete-modal-<?php echo $survey['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="delete-modal-<?php echo $survey['id']; ?>-label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="delete-modal-<?php echo $survey['id']; ?>-label">Delete <?php echo ($survey['title'] ? $survey['title'] : 'Survey'); ?></h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this survey?<br />This action <b>cannot</b> be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                <a href="dashboard.php?delete=<?php echo $survey['id']; ?>" role="button" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                                case "published":
                                ?>
                                <?php
                                    $stmt2 = $db->prepare('SELECT code FROM surveys.shortcode WHERE survey_id=:sid');
                                    $stmt2->bindValue(':sid', $survey['id'], PDO::PARAM_INT);
                                    $stmt2->execute();
                                    $survey['shortcode'] = $stmt2->fetch(PDO::FETCH_ASSOC)['code'];
                                ?>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#share-modal-<?php echo $survey['id']; ?>">Share</button>
                                <div class="modal fade" id="share-modal-<?php echo $survey['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="share-modal-<?php echo $survey['id']; ?>-label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="share-modal-<?php echo $survey['id']; ?>-label">Share <?php echo ($survey['title'] ? $survey['title'] : 'Survey'); ?></h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>Share this link so people can take your survey:</p>
                                                <input class="form-control" type="text" id="copy-link-<?php echo $survey['id']; ?>" readonly value="<?php echo ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/survey.php?s=' . $survey['shortcode']; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <span data-copy="#copy-link-<?php echo $survey['id']; ?>">Link copied.</span>
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success" data-action="copy" data-target="#copy-link-<?php echo $survey['id']; ?>">Copy Link</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="dashboard.php?close=<?php echo $survey['id']; ?>" class="btn btn-danger">Close</a>
                                <?php
                                break;
                                case "closed":
                                ?>
                                <a href="results.php?id=<?php echo $survey['id']; ?>" class="btn btn-info">Results</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-modal-<?php echo $survey['id']; ?>">Delete</button>
                                <div class="modal fade" id="delete-modal-<?php echo $survey['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="delete-modal-<?php echo $survey['id']; ?>-label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="delete-modal-<?php echo $survey['id']; ?>-label">Delete <?php echo ($survey['title'] ? $survey['title'] : 'Survey'); ?></h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this survey?<br />This action <b>cannot</b> be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                <a href="dashboard.php?delete=<?php echo $survey['id']; ?>" role="button" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                                default:
                                break;
                            }
                            ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>