<?php
session_start();

if (!isset($_GET['id'])) {
    header('location: dashboard.php');
    exit;
}

require_once 'inc/db.inc.php';

$sid = intval($_GET['id']);

$stmt = $db->prepare('SELECT s.title,s.user_id AS owner_id FROM surveys.survey s WHERE s.survey_id=:sid');
$stmt->bindValue(':sid', $sid, PDO::PARAM_INT);
$stmt->execute();

$survey = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['user']['id'] != $survey['owner_id']) {
    header('location: dashboard.php');
    exit;
}

$title = $survey['title'];


$stmt1 = $db->prepare('SELECT response_data AS data, responded_on, ip_address AS ip FROM surveys.response WHERE survey_id=:sid');
$stmt1->bindValue(':sid', $sid, PDO::PARAM_INT);
$stmt1->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Results - Survey Project</title>
</head>
<body class="bg-info">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">Results <span class="font-weight-lighter">(<?php echo $stmt1->rowCount(); ?>)</span></span>
            <span class="navbar-text text-light"><h3><?php echo empty($title) ? 'Survey' : $title; ?></h3></span>
            <span class="navbar-text">
                <a href="csv.php?s=<?php echo $sid; ?>" class="btn btn-success"><i class="fas fa-download"></i> Download</a>
                <a href="dashboard.php" class="btn btn-info">Dashboard</a>
            </span>
        </div>
    </nav>
    <div class="container bg-light mt-2 mb-2 rounded">
    <div class="table-responsive">
    <table class="table">
    <?php
        while ($response = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr><th colspan="2">Response: <?php
            $date = explode('-', substr($response['responded_on'], 0, strpos($response['responded_on'], ' ')));
            $y = $date[0];
            $m = $date[1];
            $d = $date[2];

            echo array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')[$m - 1] . ' ' . ltrim($d, '0') . ', ' . $y;

            if ($response['ip']) { echo ' <small class="text-muted">(' . $response['ip'] . ')</small>'; }
             ?></th></tr>
            <?php
            foreach (json_decode($response['data']) as $answer) {
                ?>
                <tr>
                    <td>
                        <?php
                            $stmt3 = $db->prepare('SELECT content FROM surveys.question WHERE question_id=:qid');
                            $stmt3->bindValue(':qid', $answer->qid);
                            $stmt3->execute();
                            echo json_decode($stmt3->fetch(PDO::FETCH_ASSOC)['content'])->content->content;
                        ?>
                    </td>
                    <td>
                        <?php
                        if (is_array($answer->answer)) {
                            for ($i = 0; $i < count($answer->answer); $i++) {
                                if ($i > 0) { echo ', '; }
                                echo $answer->answer[$i];
                            }
                        } else {
                            echo $answer->answer;
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </table>
    </div>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>