<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>New Survey - Survey Project</title>
</head>
<body class="bg-info no-select">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">New Survey</span>
            <span class="navbar-text text-light">Welcome, <!--<a href="user.php">--><?php echo $_SESSION['user']['name']; ?><!--</a>-->!  <a class="btn btn-sm btn-info" role="button" href="logout.php">Log Out</a></span>
        </div>
    </nav>
    <div class="container mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-1">
                        <button role="button" class="btn btn-info" title="Edit Title" id="edit-title" data-toggle="tooltip" data-placement="left"><i class="far fa-edit"></i></button>
                        <button role="button" class="btn btn-success" title="Save Title" id="save-title" data-toggle="tooltip" data-placement="left"><i class="far fa-save"></i></button>
                    </div>
                    <div class="col-6">
                        <h3 class="mb-0" id="survey-title">Survey Title</h3>
                        <input class="form-control font-weight-bold" type="text" value="Survey Title" id="edit-title-input">
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
                                        <p>Are you sure you want to discard this survey?<br />Any unsaved work will be lost!</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                        <a href="dashboard.php" role="button" class="btn btn-danger">Discard</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button role="button" class="btn btn-success" id="save-survey"><i class="far fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pages">
        <div class="container mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title" data-page="1">Page 1</h3>
                        </div>
                        <div class="col text-right">
                            <button data-page="1" class="delete-page btn btn-danger" role="button" data-toggle="tooltip" data-placement="left" title="Delete Page" disabled><i class="far fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>
                <div class="questions" data-page="1">
                    <div class="card-body border-top border-bottom" data-page="1" data-question="1">
                        <div class="row question-display">
                            <div class="col-10">
                                <div class="form-group">
                                    <label data-qtype="0">What is your answer?</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-2 text-right">
                                <button role="button" class="btn btn-info edit-question" data-toggle="tooltip" data-placement="top" title="Edit Question" data-page="1" data-question="1"><i class="far fa-edit"></i></button>
                                <button role="button" class="btn btn-danger delete-question" data-toggle="tooltip" data-placement="top" title="Delete Question" data-page="1" data-question="1"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </div>
                        <div class="question-editor">
                            <div class="row form-group">
                                <div class="col-4">
                                    <select class="custom-select question-type">
                                        <option value="0" selected>Textbox</option>
                                        <option value="0m">Textarea</option>
                                        <option value="1m">Checkboxes</option>
                                        <option value="1">Radio Buttons</option>
                                        <option value="2">Dropdown</option>
                                        <option value="2m">Select Menu</option>
                                        <option value="3">Slider</option>
                                    </select>
                                </div>
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <button role="button" class="btn btn-success save-question" data-toggle="tooltip" data-placement="top" title="Save Question" data-page="1" data-question="1"><i class="far fa-save"></i></button>
                                    <button role="button" class="btn btn-danger discard-question" data-toggle="tooltip" data-placement="top" title="Discard Changes" data-page="1" data-question="1"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" class="form-control question-content" value="What is your answer?" placeholder="Question">
                                    </div>
                                    <div class="question-details"><!-- Not used for textbox/textarea questions -->
                                        <div class="options" data-page="1" data-question="2">
                                            <div class="row form-group option">
                                                <div class="col-5">
                                                    <input class="form-control" type="text" data-page="1" data-question="2" value="Choice 1">
                                                </div>
                                                <div class="col">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row form-group option">
                                                <div class="col-5">
                                                    <input class="form-control" type="text" data-page="1" data-question="2" value="Choice 2">
                                                </div>
                                                <div class="col">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row form-group option">
                                                <div class="col-5">
                                                    <input class="form-control" type="text" data-page="1" data-question="2" value="Choice 3">
                                                </div>
                                                <div class="col">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                        </div><!-- .options -->
                                        <div class="row form-group">
                                            <div class="col"><button role="button" class="btn btn-info add-option"><i class="fas fa-plus"></i> Add Option</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-top border-bottom" data-page="1" data-question="2">
                        <div class="row question-display">
                            <div class="col-10">
                                <div class="form-group">
                                    <label data-qtype="1m">What is your choice?</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="chk-p1-q2-o1">
                                        <label class="custom-control-label" for="chk-p1-q2-o1">Choice 1</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="chk-p1-q2-o2">
                                        <label class="custom-control-label" for="chk-p1-q2-o2">Choice 2</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="chk-p1-q2-o3">
                                        <label class="custom-control-label" for="chk-p1-q2-o3">Choice 3</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 text-right">
                                <button role="button" class="btn btn-info edit-question" data-toggle="tooltip" data-placement="top" title="Edit Question" data-page="1" data-question="2"><i class="far fa-edit"></i></button>
                                <button role="button" class="btn btn-danger delete-question" data-toggle="tooltip" data-placement="top" title="Delete Question" data-page="1" data-question="2"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </div>
                        <div class="question-editor">
                            <div class="row form-group">
                                <div class="col-4">
                                    <select class="custom-select question-type">
                                        <option value="0">Textbox</option>
                                        <option value="0m">Textarea</option>
                                        <option value="1m" selected>Checkboxes</option>
                                        <option value="1">Radio Buttons</option>
                                        <option value="2">Dropdown</option>
                                        <option value="2m">Select Menu</option>
                                        <option value="3">Slider</option>
                                    </select>
                                </div>
                                <div class="col-6"></div>
                                <div class="col-2 text-right">
                                    <button role="button" class="btn btn-success save-question" data-toggle="tooltip" data-placement="top" title="Save Question" data-page="1" data-question="2"><i class="far fa-save"></i></button>
                                    <button role="button" class="btn btn-danger discard-question" data-toggle="tooltip" data-placement="top" title="Discard Changes" data-page="1" data-question="2"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" class="form-control question-content" value="What is your choice?" placeholder="Question">
                                    </div>
                                    <div class="question-details">
                                        <div class="options" data-page="1" data-question="2">
                                            <div class="row form-group option">
                                                <div class="col-5">
                                                    <input class="form-control" type="text" data-page="1" data-question="2" value="Choice 1">
                                                </div>
                                                <div class="col">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row form-group option">
                                                <div class="col-5">
                                                    <input class="form-control" type="text" data-page="1" data-question="2" value="Choice 2">
                                                </div>
                                                <div class="col">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="row form-group option">
                                                <div class="col-5">
                                                    <input class="form-control" type="text" data-page="1" data-question="2" value="Choice 3">
                                                </div>
                                                <div class="col">
                                                    <button role="button" class="btn btn-danger delete-option" data-toggle="tooltip" data-placement="right" title="Delete Option"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
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
                <div class="card-footer" data-page="1">
                    <div class="row">
                        <div class="col text-center"><button data-page="1" role="button" class="add-question btn btn-info"><i class="fas fa-plus"></i> Add Question</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .pages -->

    <div class="container mt-2 mb-2">
        <div class="card">
            <div class="card-footer text-center">
                <button role="button" id="add-page" class="btn btn-info"><i class="fas fa-plus"></i> Add Page</button>
            </div>
        </div>
    </div>

    <?php include 'inc/js.inc.php'; ?>
    <script src="createSurvey.js"></script>
</body>
</html>