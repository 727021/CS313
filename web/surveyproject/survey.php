<?php
session_start();

if (!isset($_GET['s'])) {
    header('location: survey.php?s=0');
    exit;
}

require_once 'inc/question.class.php';
require_once 'inc/db.inc.php';
include 'inc/misc.inc.php';

$shortcode = htmlspecialchars(trim($_GET['s']));
$stmt3 = $db->prepare('SELECT survey_id AS id FROM surveys.shortcode WHERE code=:shc');
$stmt3->bindValue(':shc', $shortcode, PDO::PARAM_STR);
$stmt3->execute();

$sid = $stmt3->fetch(PDO::FETCH_ASSOC)['id']; // Survey id

if ($sid != 0) {
    // Prevent multiple responses from the same ip
    $stmt_check = $db->prepare('SELECT response_id FROM surveys.response r, surveys.shortcode s WHERE s.code=:code AND s.survey_id=r.survey_id AND r.ip_address=:ip');
    $stmt_check->bindValue(':code', $_GET['s'], PDO::PARAM_STR);
    $stmt_check->bindValue(':ip', get_ip_address(), PDO::PARAM_STR);
    $stmt_check->execute();
    $taken = false;

    if (count($stmt_check->fetchAll(PDO::FETCH_COLUMN, 0)) > 0) {
        $taken = true;
    }

    $pid = isset($_GET['p']) ? intval($_GET['p']) : 1;

    $stmt = $db->prepare('SELECT s.title, u.username AS owner FROM surveys.survey s, surveys.users u WHERE s.survey_id=:sid AND u.user_id=s.user_id');
    $stmt->bindValue(':sid', $sid, PDO::PARAM_INT);
    $stmt->execute();

    $survey = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $survey['title'];
    $owner = $survey['owner'];

    $stmt2 = $db->prepare('SELECT COUNT(page_id) FROM surveys.page WHERE survey_id=:sid');
    $stmt2->bindValue(':sid', $sid, PDO::PARAM_INT);
    $stmt2->execute();
    $pageCount = $stmt2->fetch(PDO::FETCH_ASSOC)['count'];

    $invalid_inputs = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A page has been submitted
        // Do form validation and store answers in $_SESSION['response']
        foreach ($_POST as $key => $val) {
            if (is_string($val)) { $val = trim(htmlspecialchars($val)); }
            if ((is_string($val) && strlen($val) == 0)) {
                array_push($invalid_inputs, $key);
            }
        }

        if (count($invalid_inputs) > 0) {
            $pid--; // There was a problem, go back to the previous page
        } else {
            if (!isset($_SESSION['response'])) {
                $_SESSION['response'] = array();
            }

            $_SESSION['response'] = $_SESSION['response'] + $_POST;
        }

        if ($pid > $pageCount) { // The survey is finished, record the data.
            $json = '[';
            $firstAnswer = true;
            foreach ($_SESSION['response'] as $qid => $answer) {
                if (!$firstAnswer) { $json .= ','; }
                $firstAnswer = false;
                $json .= "{\"qid\":$qid,\"answer\":";
                if (is_array($answer)) {
                    $firstA = true;
                    $json .= '[';
                    foreach ($answer as $a) {
                        if (!$firstA) { $json .= ","; }
                        $firstA = false;
                        $json .= "\"$a\"";
                    }
                    $json .= ']';
                } else {
                    $json .= "\"$answer\"";
                }
                $json .= "}";
            }
            $json .= ']';

            $ip = get_ip_address();

            $stmt_ins = $db->prepare('INSERT INTO surveys.response (survey_id,ip_address,response_data) VALUES (:sid,:ip,:json)');
            $stmt_ins->bindValue(':sid', $sid, PDO::PARAM_INT);
            $stmt_ins->bindValue(':ip', $ip, PDO::PARAM_STR);
            $stmt_ins->bindValue(':json', $json, PDO::PARAM_STR);
            $stmt_ins->execute();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title><?php echo empty($title) ? 'Survey' : $title; ?> - Survey Project</title>
</head>
<body class="bg-info">
    <div class="container bg-light mt-2 rounded">
    <?php if ($sid == 0) { ?>
        <p class="text-center">No survey was found.</p>
    <?php } else { ?>
    <h3 class="border-bottom text-center display-4"><?php echo empty($title) ? 'Survey' : $title; ?> <small><small class="text-muted">by <?php echo $owner; ?></small></small></h3>
    <form method="POST" action="survey.php?p=<?php echo $pid + 1; ?>&s=<?php echo $shortcode; ?>">
        <?php
        if ($taken) {
            echo '<p class="text-center">You\'ve already responded to this survey.</p>';
        } elseif ($pid > $pageCount) {
            echo '<p class="text-center">Thank you for your response.</p>';
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
        <?php } } ?>
    </form>
    </div>

    <?php include 'inc/js.inc.php'; ?>
</body>
</html>