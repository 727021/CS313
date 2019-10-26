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
    <title>Dashboard - Survey Project</title>
</head>
<body class="bg-info no-select">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">New Survey</span>
            <span>Welcome, <a href="user.php"><?php echo $_SESSION['user']['name']; ?></a>!  <a class="btn btn-sm btn-info" role="button" href="logout.php">Log Out</a></span>
        </div>
    </nav>
    <div class="container mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-1">
                        <button role="button" class="btn btn-info text-center" title="Edit Title" id="edit-title" data-toggle="tooltip" data-placement="left"><i class="far fa-edit"></i></button>
                    </div>
                    <div class="col-6">
                        <h3 class="d-inline mb-0" id="survey-title">Survey Title</h3>
                    </div>
                    <div class="col-5 text-right">
                        <button role="button" class="btn btn-danger" id="discard-survey"><i class="far fa-trash-alt"></i> Discard</button>
                        <button role="button" class="btn btn-success" id="save-survey"><i class="far fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title" data-page="1">Page 1</h3>
                    </div>
                    <div class="col text-right">
                        <button id="delete-page" data-page="1" class="btn btn-danger" role="button" data-toggle="tooltip" title="Delete Page"><i class="far fa-trash-alt"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body" data-page="1">
                <div class="row">
                    <div class="col">Questions go here<hr /></div>
                </div>
                <div class="row">
                    <div class="col text-center"><button id="add-question" data-page="1" role="button" class="btn btn-info"><i class="far fa-plus-square"></i> Add Question</button></div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'inc/js.inc.php'; ?>
    <script src="createSurvey.js"></script>
</body>
</html>