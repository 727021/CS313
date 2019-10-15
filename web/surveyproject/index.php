<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Welcome - Survey Project</title>
</head>
<body class="bg-info no-select">
    <div class="container">
        <div class="vertical-center">
            <div>
                <div class="row">
                    <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                    <div class="col">
                        <h1 class="display-3 text-white">Welcome!</h1>
                        <p class="text-white">It looks like you're not logged in. Click one of the buttons below to start creating your own surveys.</p>
                        <br/><br/>
                        <a href="login.php" class="btn btn-primary btn-lg" role="button">Create an Account</a>
                        <p class="text-primary m-0"><i>or</i></p>
                        <a href="login.php" class="btn btn-outline-primary">Log in</a>
                        <?php if (isset($_GET['logout'])) { ?>
                        <br />
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Successfully logged out.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
