<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}

require_once 'inc/db.inc.php';

$stmt = $db->prepare('SELECT s.survey_id AS id, s.title, c.value AS status FROM surveys.survey s JOIN surveys.common_lookup c ON s.status = c.common_lookup_id WHERE s.user_id=:userid');
$stmt->bindValue(':userid', $_SESSION['user'], PDO::PARAM_INT);
$stmt->execute();

$surveys = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>