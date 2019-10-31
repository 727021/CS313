<?php
session_start();

if (!isset($_GET['s'])) {
    header('location: dashboard.php');
    die();
}
if (!isset($_SESSION['user'])) {
    header('location: index.php');
    die();
}

require_once 'inc/db.inc.php';

$stmt_response = $db->prepare('SELECT ip_address AS ip, responded_on AS "date", response_data AS data FROM surveys.response WHERE survey_id = :sid');
$stmt_response->bindValue(':sid', htmlspecialchars(trim($_GET['s'])), PDO::PARAM_INT);
$stmt_response->execute();

if ($stmt_response->rowCount() > 0) {
    // header('Content-Type: text/csv');
    // header('Content-Disposition: attachment; filename="survey-results.csv"');
    // Generate CSV from survey results
    $stmt_question = $db->prepare('SELECT q.content FROM surveys.question q, surveys.page p WHERE q.page_id = p.page_id AND p.survey_id = :sid');
    $stmt_question->bindValue(':sid', htmlspecialchars(trim($_GET['s'])), PDO::PARAM_INT);
    $stmt_question->execute();

    echo 'ip,date';
    while ($question = $stmt_question->fetch(PDO::FETCH_ASSOC)) {
        echo ',' . str_replace(',', '', json_decode($question['content'])->content->content);
    }
    echo '\n';

    while ($response = $stmt_response->fetch(PDO::FETCH_ASSOC)) {
        $date = explode('-', substr($response['date'], 0, strpos($response['date'], ' ')));
        $y = $date[0];
        $m = $date[1];
        $d = $date[2];

        echo $response['ip'] . ',' . array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')[$m - 1] . ' ' . ltrim($d, '0') . ' ' . $y;
        $objs = json_decode($response['data']);
        foreach ($objs as $obj) {
            echo ',' . str_replace(',', '', $obj->answer);
        }
        echo '\n';
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Download CSV - Survey Project</title>
</head>
<body class="bg-info">
    <div class="container">
        <div class="vertical-center">
            <div class="text-center">
                <p class="text-light">No results were found.</p>
                <a href="dashboard.php" role="button" class="btn btn-primary">Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>