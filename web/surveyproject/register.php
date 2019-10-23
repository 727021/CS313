<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
    exit;
}

$error = false;
$user = $email = $fname = $mname = $lname = $pass = $cpass = "";   // Form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Log In - Survey Project</title>
</head>
<body class="bg-info">
    <div class="container">
        <div class="vertical-center">
            <div>
                <h1 class="display-3 text-white no-select">Log In</h1>
                <br />
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <!-- TODO form error handling -->
                    <div class="form-group row">
                        <div class="col">
                            <input class="form-control" type="text" name="username" id="reg-username" placeholder="Username" value="<?php echo $user; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <input class="form-control" type="email" name="email" id="reg-email" placeholder="user@example.com" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col"><input class="form-control" type="text" name="fname" id="reg-fname" placeholder="First name" value="<?php echo $fname; ?>"></div>
                        <div class="col"><input class="form-control" type="text" name="lname" id="reg-lname" placeholder="Last name" value="<?php echo $lname; ?>"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <input class="form-control" type="password" name="password" id="reg-password" placeholder="Password">
                        </div>
                        <div class="col">
                            <input class="form-control" type="password" name="cpassword" id="reg-cpassword" placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col text-right align-middle">
                            <button class="btn btn-primary" type="submit">Register</button>
                        </div>
                        <div class="col text-left align-middle">
                            <a class="btn btn-outline-primary btn-small" href="login.php">Log In</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'inc/js.inc.php'; ?>
</body>
</html>