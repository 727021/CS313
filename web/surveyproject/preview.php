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

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A page has been submitted
    $stmt3 = $db->prepare('SELECT question_id,content FROM surveys.question WHERE page_id=(SELECT page_id FROM surveys.page WHERE page_index=:pid AND survey_id=:sid)');
    $stmt3->bindValue(':pid', $pid - 1, PDO::PARAM_INT);
    $stmt3->bindValue(':sid', $sid, PDO::PARAM_INT);
    $stmt3->execute();

    $required_ids = array();
    $question_errors = array();

    while ($q_validate = $stmt3->fetch(PDO::FETCH_ASSOC)) { // Collect the IDs of the required questions
        if (json_decode($q_validate['content']->content->required)) { array_push($required_ids, $q_validate['question_id']); }
    }

    foreach ($_POST as $answer_id => $answer) {
        if (array_search($answer_id, $required_ids) !== false) {
            if (empty(trim($answer))) { // Collect the IDs of empty required questions
                array_push($question_errors, $answer_id);
            }
        }
    }

    if (count($question_errors) == 0) {
        if (!isset($_SESSION['response'])) {
            $_SESSION['response'] = array();
        }

        foreach ($_POST as $answer_id => $answer) {
            $_SESSION['response'][$answer_id] = htmlspecialchars(trim($answer));
        }
    } else {
        $pid -= 1;
    }
}

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
        if ($pid > $pageCount) {
            echo '<p class="text-center">Thank you for your response.</p>';
            echo '<div class="text-center"><a class="btn btn-primary" role="button" href="dashboard.php">Back to Dashboard</a></div>';
        }  else {
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
                echo $q->toHTML($qid, (array_search($qid, $question_errors) != false));
            }
        }
        ?>
        <input type="submit" value="<?php echo ($pid == $pageCount ? 'Submit' : 'Continue'); ?>">
    </form>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>