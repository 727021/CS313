<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
    exit;
}

$error = false;
$user = $email = $fname = $lname = $pass = $cpass = "";   // Form data
$euser = $eemail = $efname = $elname = $epass = $ecpass = "";   // Form data
$posted = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posted = true;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.inc.php'; ?>
    <title>Create Account - Survey Project</title>
</head>
<body class="bg-info">
    <div class="container">
        <div class="vertical-center">
            <div>
                <h1 class="display-3 text-white no-select">Create Account</h1>
                <br />
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <!-- TODO form error handling -->
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($euser === "") ? ' is-valid' : ' is-invalid'); } ?>" type="text" name="username" id="reg-username" placeholder="Username" value="<?php echo $user; ?>">
                            <?php if ($posted && $euser !== "") { echo "<div class=\"invalid-feedback\">$euser</div>"; } ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($eemail === "") ? ' is-valid' : ' is-invalid'); } ?>" type="email" name="email" id="reg-email" placeholder="user@example.com" value="<?php echo $email; ?>">
                            <?php if ($posted && $eemail !== "") { echo "<div class=\"invalid-feedback\">$euser</div>"; } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($efname === "") ? ' is-valid' : ' is-invalid'); } ?>" type="text" name="fname" id="reg-fname" placeholder="First name" value="<?php echo $fname; ?>">
                            <?php if ($posted && $efname !== "") { echo "<div class=\"invalid-feedback\">$euser</div>"; } ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($elname === "") ? ' is-valid' : ' is-invalid'); } ?>" type="text" name="lname" id="reg-lname" placeholder="Last name" value="<?php echo $lname; ?>">
                            <?php if ($posted && $elname !== "") { echo "<div class=\"invalid-feedback\">$euser</div>"; } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($epass === "") ? ' is-valid' : ' is-invalid'); } ?>" type="password" name="password" id="reg-password" placeholder="Password">
                            <?php if ($posted && $epass !== "") { echo "<div class=\"invalid-feedback\">$euser</div>"; } ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($ecpass === "") ? ' is-valid' : ' is-invalid'); } ?>" type="password" name="cpassword" id="reg-cpassword" placeholder="Confirm password">
                            <?php if ($posted && $ecpass !== "") { echo "<div class=\"invalid-feedback\">$euser</div>"; } ?>
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