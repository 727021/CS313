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

$stmt = $db->prepare('SELECT title,user_id FROM surveys.survey WHERE survey_id=:sid');
$stmt->bindValue(':sid', $sid, PDO::PARAM_INT);
$stmt->execute();

$survey = $stmt->fetch(PDO::FETCH_ASSOC);
$title = $survey['title'];

if ($survey['user_id'] != $_SESSION['user']['id']) {
    header('location: dashboard.php');
    exit;
}

$stmt2 = $db->prepare('SELECT COUNT(page_id) FROM surveys.page WHERE survey_id=:sid');
$stmt2->bindValue(':sid', $sid, PDO::PARAM_INT);
$stmt2->execute();
$pageCount = $stmt2->fetch(PDO::FETCH_ASSOC)['count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Preview - <?php echo empty($title) ? : $title . ' - '; ?>Survey Project</title>
</head>
<body class="bg-info">

    <div class="container bg-light mt-2 rounded">
    <h3 class="border-bottom text-center display-4"><?php echo empty($title) ? 'Survey' : $title; ?> <small><small class="text-muted">by <?php echo $_SESSION['user']['username']; ?></small></small></h3>
    <form method="POST" action="<?php echo "preview.php?p=" . $pid + 1; ?>">
        <?php
            $stmt1 = $db->prepare('SELECT q.question_id AS id, q.content FROM surveys.question q, surveys.page p, surveys.survey s WHERE q.page_id = p.page_id AND s.survey_id=:sid AND p.page_index=:pid');
            $stmt1->bindValue(':sid', $sid, PDO::PARAM_INT);
            $stmt1->bindValue(':pid', $pid, PDO::PARAM_INT);
            $stmt1->execute();

            while ($question = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $qid = $question['id'];
                $jq = json_decode($question['content']);
                $qc = $jq->content; // Question content

                // Create a Question object based on question type
                switch ($jq->type) {
                    case QuestionTypes::TEXT:
                    $q = new QText($qc->content, $qc->placeholder, $qc->multiline, $qc->required);
                    break;
                    case QuestionTypes::CHECK:
                    $q = new QCheck($qc->content, $qc->choices, $qc->radio, $qc->required);
                    break;
                    case QuestionTypes::DROP:
                    $q = new QDrop($qc->content, $qc->choices, $qc->multiple, $qc->required);
                    break;
                    case QuestionTypes::SLIDER:
                    $q = new QSlider($qc->content, $qc->start, $qc->end, $qc->interval, $qc->required);
                    break;
                }
                if ($q == null) { continue; }

                // Actually display the question as HTML
                echo $q->toHTML($qid);
            }
        ?>
        <!-- TODO Add button(s) for page navigation -->
    </form>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>