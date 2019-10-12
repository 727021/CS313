<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
    exit;
}

$user = $pass = "";   // Form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize input
    $user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $pass = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : false;

    if ($user !== false && $pass !== false) {
        require_once 'inc/db.inc.php';
        $result = pg_fetch_assoc(pg_query($db, "SELECT user_id AS id FROM surveys.users WHERE username = $user AND hash = $pass"));
        pg_close($db);

        var_dump($result);
        exit;
        // if ($result !== false) {
        //     // Log the user in
        //     $_SESSION['user'] = $result['id'];

        //     // Go to dashboard
        //     header('location: dashboard.php');
        //     exit;
        // }
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
                <h1 class="display-3 text-white">Log In</h1>
                <br />
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <?php if ((isset($user) && $user === false) || (isset($pass) && $pass === false)) { ?>
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-danger">Username or password was incorrect.</div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group row">
                        <div class="d-none d-sm-block col-sm-2 col-lg-4"></div>
                        <div class="col">
                            <input class="form-control" type="text" name="username" id="login-username" placeholder="Username" <?php if (isset($user)) { echo "value=\"$user\""; } ?>>
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