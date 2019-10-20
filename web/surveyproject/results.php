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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Results - Survey Project</title>
</head>
<body class="bg-info">
    <div class="container bg-light mt-2 rounded">
    <h3 class="border-bottom text-center display-4"><?php echo empty($title) ? 'Survey' : $title; ?> <small><small class="text-muted">Results</small></small></h3>
    <?php
        $stmt1 = $db->prepare('SELECT response_data AS data, responded_on FROM surveys.response WHERE survey_id=:sid');
        $stmt1->bindValue(':sid', $sid, PDO::PARAM_INT);
        $stmt1->execute();

        // $stmt2 = $db->prepare('SELECT q.content FROM surveys.question q, surveys.page p WHERE q.page_id=p.page_id AND p.survey_id=:sid');
        // $stmt2->bindValue(':sid', $sid, PDO::PARAM_INT);
        // $stmt2->execute();

        // $questions = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table class="table">
    <?php
        while ($response = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr><th colspan="2">Response: <?php echo date_format('M j, Y', date_create_from_format('Y-m-d H:i:s.u', $response['responded_on'])); ?></th></tr>
            <?php
            foreach (json_decode($response['data']) as $answer) {
                ?>
                <tr>
                    <td>Q<?php echo $answer->qid; ?>:</td>
                    <td>
                        <?php
                        var_dump($answer);
                        // if (is_array($answer->answer)) {
                        //     for ($i = 0; $i < count($answer->answer); $i++) {
                        //         if ($i > 0) { echo ', '; }
                        //         echo $answer->answer[$i];
                        //     }
                        // } else {
                        //     echo $answer->answer;
                        // }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </table>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>