<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}

if (!isset($_GET['s'])) {
    header('location: dashboard.php');
    exit;
}

$sid = intval(htmlspecialchars(trim($_GET['s'])));

require_once 'inc/db.inc.php';

$stmt_survey = $db->prepare("SELECT s.survey_id AS id, s.title, cl.value AS status FROM surveys.survey s, surveys.common_lookup cl WHERE cl.common_lookup_id = s.status AND s.survey_id = :sid AND s.user_id = :uid");
$stmt_survey->bindValue(':sid', $sid, PDO::PARAM_INT);
$stmt_survey->bindValue(':uid', $_SESSION['user']['id'], PDO::PARAM_INT);
$stmt_survey->execute();

$survey = $stmt_survey->fetch(PDO::FETCH_ASSOC);

if ($stmt_survey->rowCount() == 0) { // Either the survey doesn't exist, or you don't own it
    header('location: dashboard.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Edit Survey - Survey Project</title>
</head>
<body class="bg-info no-select">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">New Survey</span>
            <span class="navbar-text text-light">Welcome, <?php echo $_SESSION['user']['name']; ?>!  <button class="btn btn-sm btn-info" type="button" id="logout">Log Out</button></span>
        </div>
    </nav>
    <div class="modal" tabindex="-1" role="dialog" id="logout-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log Out</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to log out?<br />Any unsaved changes will be lost!</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger" role="button">Log Out</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="save-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Survey</h5>
                </div>
                <div class="modal-body text-center" id="save-modal-body">
                </div>
                <div class="modal-footer" id="save-modal-footer" style="display: none;">
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-1">
                        <button role="button" class="btn btn-info" title="Edit Title" id="edit-title" data-toggle="tooltip" data-placement="left"><i class="far fa-edit"></i></button>
                        <button role="button" class="btn btn-success" title="Save Title" id="save-title" data-toggle="tooltip" data-placement="left" style="display: none;"><i class="far fa-save"></i></button>
                    </div>
                    <div class="col-6">
                        <h3 class="mb-0" id="survey-title" data-sid="<?php echo $sid; ?>"><?php echo $survey['title']; ?></h3>
                        <input class="form-control font-weight-bold" type="text" value="<?php echo $survey['title']; ?>" id="edit-title-input" style="display: none;">
                    </div>
                    <div class="col-5 text-right">
                        <button role="button" class="btn btn-danger" id="discard-survey" data-toggle="modal" data-target="#discard-survey-modal"><i class="far fa-trash-alt"></i> Discard</button>
                        <div class="modal fade" id="discard-survey-modal" tabindex="-1" role="dialog" aria-labelledby="discard-survey-modal-label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="discard-survey-modal-label">Discard Survey</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to discard this survey?<br />Any unsaved changes will be lost!</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                        <a href="dashboard.php" role="button" class="btn btn-danger">Discard</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button role="button" class="btn btn-success" id="save-edit-survey"><i class="far fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pages">
        <?php
        $stmt_page = $db->prepare('SELECT page_id AS id, page_index AS index FROM surveys.page WHERE survey_id = :sid ORDER BY page_index ASC');
        $stmt_page->bindValue(':sid', $sid, PDO::PARAM_INT);
        $stmt_page->execute();

        $pageCount = 0;
        $questionCount = array();

        while ($page = $stmt_page->fetch(PDO::FETCH_ASSOC)) {
            $pageCount++;
            array_push($questionCount, 0);
        ?>

        <div class="container mt-2 page" data-page="<?php echo $page['index']; ?>">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title" data-page="<?php echo $page['index']; ?>">Page <?php echo $page['index']; ?></h3>
                        </div>
                        <div class="col text-right">
                            <button data-page="<?php echo $page['index']; ?>" class="delete-page btn btn-danger" role="button" data-toggle="tooltip" data-placement="left" title="Delete Page" disabled><i class="far fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="questions" data-page="<?php echo $page['index']; ?>">

                    <?php

                    $stmt_question = $db->prepare('SELECT row_number() over(ORDER BY question_id ASC) AS index, question_id AS id, content FROM surveys.question WHERE page_id = :pid');
                    $stmt_question->bindValue(':pid', $page['id'], PDO::PARAM_INT);
                    $stmt_question->execute();

                    $iOption = 1;

                    while ($question = $stmt_question->fetch(PDO::FETCH_ASSOC)) {
                        $questionCount[count($questionsCount) - 1]++;

                        $qindex = $question['index'];
                        $questionObj = json_decode($question['content']);
                    }
                    ?>
                    <div class="card-body border-top border-bottom" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>">
                        <div class="row question-display">
                            <div class="col-10">
                                <div class="form-group">
                                <?php
                                switch($questionObj->type) {
                                    case 0: // text
                                    echo '<label data-qtype="0' . ($questionObj->content->multiline ? 'm' : '') . '">' . $questionObj->content->content . '</label>';
                                    if ($questionObj->content->multiline) {
                                        echo '<textarea class="form-control" rows="3"></textarea>';
                                    } else {
                                        echo '<input type="text" class="form-control">';
                                    }
                                    break;
                                    case 1: // check/radio
                                    echo '<label data-qtype="1' . ($questionObj->content->radio ? '' : 'm') . '">' . $questionObj->content->content . '</label>';
                                    foreach ($questionObj->content->choices as $qChoice) {
                                        if ($questionObj->content->radio) {
                                            echo '<div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="rad' . (-1 * $iOption) . '" name="rad' . (-1 * $iOption) . '"><label class="custom-control-label" for="rad' . (-1 * $iOption++) . '">' . $qChoice . '</label></div>';
                                        } else {
                                            echo '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="chk' . (-1 * $iOption) . '" name="chk' . (-1 * $iOption) . '"><label class="custom-control-label" for="chk' . (-1 * $iOption++) . '">' . $qChoice . '</label></div>';
                                        }
                                    }
                                    break;
                                    case 2: // select
                                    echo '<label data-qtype="2' . ($questionObj->content->multiple ? 'm' : '') . '">' . $questionObj->content->content . '</label>';
                                    echo '<select class="custom-select" ' . ($questionObj->content->multiple ? 'multiple' : '') . '>';
                                    foreach ($questionObj->content->choices as $qChoice) {
                                        echo "<option>$qChoice</option>";
                                    }
                                    echo '</select>';
                                    break;
                                }
                                ?>
                                </div>
                            </div>
                            <div class="col-2 text-right">
                                <button data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>" data-toggle="tooltip" data-placement="top" title="Edit Question" class="btn btn-info edit-question"><i class="far fa-edit"></i></button>
                                <button data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>" data-toggle="tooltip" data-placement="top" title="Delete Question" class="btn btn-danger delete-question"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </div>
                        <div class="question-editor" style="display: none;">
                        <div class="row form-group">
                                <div class="col-4">
                                    <select class="custom-select question-type">
                                        <option value="0" <?php if ($questionObj->type == 0) echo 'selected'; ?>>Textbox</option>
                                        <option value="0m" <?php if ($questionObj->type == 0 && $questionObj->multiline) echo 'selected'; ?>>Textarea</option>
                                        <option value="1m" <?php if ($questionObj->type == 1) echo 'selected'; ?>>Checkboxes</option>
                                        <option value="1" <?php if ($questionObj->type == 1 && $questionObj->radio) echo 'selected'; ?>>Radio Buttons</option>
                                        <option value="2" <?php if ($questionObj->type == 2) echo 'selected'; ?>>Dropdown</option>
                                        <option value="2m" <?php if ($questionObj->type == 2 && $questionObj->multiple) echo 'selected'; ?>>Select Menu</option>
                                    </select>
                                </div>
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <button role="button" class="btn btn-success save-question" data-toggle="tooltip" data-placement="top" title="Save Question" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>"><i class="far fa-save"></i></button>
                                    <button role="button" class="btn btn-danger discard-question" data-toggle="tooltip" data-placement="top" title="Discard Changes" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" class="form-control question-content" value="<?php echo $questionObj->content->content; ?>" placeholder="Question">
                                    </div>
                                    <div class="question-details" <?php if ($questionObj->type == 0) echo 'style="display: none;"'; ?>><!-- Not used for textbox/textarea questions -->
                                        <div class="options" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>">
                                            <?php
                                                if ($questionObj->type > 0) {
                                                    foreach ($questionObj->content->options as $option) {
                                                        ?>
                                                        <div class="row form-group option">
                                                            <div class="col-5 pr-2">
                                                                <input type="text" class="form-control" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>"" value="<?php echo $option; ?>">
                                                            </div>
                                                            <div class="col pl-0">
                                                                <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                            ?>
                                            <div class="row form-group option">
                                                <div class="col-5 pr-2">
                                                    <input class="form-control" type="text" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>" value="Choice 1">
                                                </div>
                                                <div class="col pl-0">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row form-group option">
                                                <div class="col-5 pr-2">
                                                    <input class="form-control" type="text" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>" value="Choice 2">
                                                </div>
                                                <div class="col pl-0">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row form-group option">
                                                <div class="col-5 pr-2">
                                                    <input class="form-control" type="text" data-page="<?php echo $page['index']; ?>" data-question="<?php echo $qindex; ?>" value="Choice 3">
                                                </div>
                                                <div class="col pl-0">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div><!-- .options -->
                                        <div class="row form-group">
                                            <div class="col"><button role="button" class="btn btn-info add-option"><i class="fas fa-plus"></i> Add Option</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div><!-- .questions -->
                <div class="card-footer" data-page="<?php echo $page['index']; ?>">
                    <div class="row">
                        <div class="col text-center"><button data-page="<?php echo $page['index']; ?>" role="button" class="add-question btn btn-info"><i class="fas fa-plus"></i> Add Question</button></div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        }
        ?>

    </div><!-- #pages -->

    <div class="container mt-2 mb-2">
        <div class="card">
            <div class="card-footer text-center">
                <button role="button" id="add-page" class="btn btn-info"><i class="fas fa-plus"></i> Add Page</button>
            </div>
        </div>
    </div>

    <?php include 'inc/js.inc.php'; ?>
    <script src="createSurvey.js"></script>
    <script>
        // Set initial counts
        pageCount = <?php echo $pageCount; ?>;
        questionCount = <?php echo '[' . implode(", ", $questionCount) . ']'; ?>;
    </script>
</body>
</html>