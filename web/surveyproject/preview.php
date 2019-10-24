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

$invalid_inputs = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A page has been submitted
    // Do form validation and store answers in $_SESSION['response']
    var_dump($_POST);
    foreach ($_POST as $key => $val) {
        $val = trim(htmlspecialchars($val));
        if ($val === "" || (is_array($val) && count($val === 0))) {
            array_push($invalid_inputs, $key);
        }
    }

    if (count($invalid_inputs) > 0) {
        $pid--;
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
    <form method="POST" action="preview.php?p=<?php echo $pid + 1; ?>&id=<?php echo $sid; ?>">
        <?php
        if ($pid > $pageCount) {
            echo '<p class="text-center">Thank you for your response.</p>';
            echo '<div class="text-center"><a class="btn btn-primary" role="button" href="dashboard.php">Back to Dashboard</a></div>';
        }  else {
            $stmt1 = $db->prepare('SELECT q.question_id AS id, q.content FROM surveys.question q, surveys.page p WHERE q.page_id = p.page_id AND p.survey_id=:sid AND p.page_index=:pid');
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
                echo $q->toHTML($qid, in_array($qid, $invalid_inputs));
            }
        ?>
        <div class="form-group text-center">
            <input class="btn btn-primary" type="submit" value="<?php echo ($pid == $pageCount ? 'Submit' : 'Continue'); ?>">
        </div>
        <?php } ?>
    </form>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>