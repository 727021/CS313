<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die('{"status":"fail","error":"Must use POST"}');
}

if (!isset($_SESSION['user'])) {
    die('{"status":"fail","error":"User not logged in"}');
}

if (!isset($_GET['a']) || !($_GET['a'] == 'new' || $_GET['a'] == 'edit')) {
    die('{"status":"fail","error":"Invalid action"}');
}

require_once 'inc/db.inc.php';

$json = $_POST['data'];
$survey = json_decode($json);

if ($survey === NULL) {
    die('{"status":"fail","error":"Invalid JSON"}');
}

$title = $survey->title;
$rowCount = 0;

if ($_GET['a'] == 'new') {
    try {
        $stmt_survey = $db->prepare("INSERT INTO surveys.survey (title,user_id,status) VALUES (:title,:user,(SELECT common_lookup_id FROM surveys.common_lookup WHERE context = 'SURVEY.STATUS' AND value = 'UNPUBLISHED'))");
        $stmt_survey->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt_survey->bindValue(':user', $_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt_survey->execute();
        $rowCount += $stmt_survey->rowCount();

        $stmt_id = $db->prepare("SELECT currval('surveys.survey_survey_id_seq')");
        $stmt_id->execute();
        $id = $stmt_id->fetch(PDO::FETCH_NUM)[0];

        $pindex = 1;
        foreach ($survey->pages as $page) {
            $stmt_page = $db->prepare("INSERT INTO surveys.page (survey_id,page_index) VALUES (currval('surveys.survey_survey_id_seq'), :pindex)");
            $stmt_page->bindValue(':pindex', $pindex++, PDO::PARAM_INT);
            $stmt_page->execute();
            $rowCount += $stmt_page->rowCount();

            foreach ($page->questions as $question) {
                $stmt_question = $db->prepare("INSERT INTO surveys.question (page_id,content) VALUES (currval('surveys.page_page_id_seq'), :content)");
                $qjson = json_encode($question);
                if ($qjson === false) {
                    die('{"status":"fail","error":"json_encode failed"}');
                }
                $stmt_question->bindValue(':content', $qjson, PDO::PARAM_STR);
                $stmt_question->execute();
                $rowCount += $stmt_question->rowCount();
            }
        }

        die('{"status":"success","id":' . $id . ',"rows":' . $rowCount . '}');
    } catch (PDOException $ex) { die('{"status":"fail","error":"PDOException","details":"' . $ex->getMessage() . '"}'); }
} elseif ($_GET['a'] == 'edit') {

}
?>