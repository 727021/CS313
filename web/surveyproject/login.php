<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
    exit;
}

$error = false;
$user = $pass = "";   // Form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize input
    if (isset($_POST['username'])) { $user = htmlspecialchars(trim($_POST['username'])); }
    if (isset($_POST['password'])) { $pass = htmlspecialchars(trim($_POST['password'])); }

    if ($user !== false && $pass !== false) {
        require_once 'inc/db.inc.php';
        $result = pg_fetch_assoc(pg_query($db, "SELECT user_id AS id, hash FROM surveys.users WHERE username = '$user'"));
        pg_close($db);

        if ($result !== false && password_verify($pass, $result['hash'])) {
            // Log the user in
            $_SESSION['user'] = $result['id'];

            // Unset anything with the password in it, just to be safe
            unset($result);
            unset($_POST);
            unset($pass);

            // Go to dashboard
            header('location: dashboard.php');
            exit;
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
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
                    <?php if ($error) { ?>
                    <div class="row">
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                        <div class="col">
                            <div class="alert alert-danger">Username or password was incorrect.</div>
                        </div>
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                    </div>
                    <?php } ?>
                    <div class="form-group row">
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                        <div class="col">
                            <input class="form-control" type="text" name="username" id="login-username" placeholder="Username" value="<?php echo $user; ?>">
                        </div>
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                    </div>
                    <div class="form-group row">
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                        <div class="col">
                            <input class="form-control" type="password" name="password" id="login-password" placeholder="Password">
                        </div>
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                    </div>
                    <div class="form-group row">
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                        <div class="col text-right">
                            <button class="btn btn-primary" type="submit">Log In</button>
                        </div>
                        <div class="col text-left">
                            <a class="btn btn-outline-primary" href="register.php">Create an Account</a>
                        </div>
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</body>
</html>