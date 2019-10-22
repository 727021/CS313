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

        $stmt = $db->prepare('SELECT u.user_id AS id, u.first AS name, u.hash, u.username, c.value AS type FROM surveys.users u, surveys.common_lookup c WHERE u.username=:username AND c.common_lookup_id = u.type');
        $stmt->bindValue(':username', $user, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result !== false && password_verify($pass, $result['hash'])) {
            // Log the user in
            $_SESSION['user'] = array('id' => $result['id'], 'name' => $result['name'], 'type' => $result['type'], 'username' => $result['username']);

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
                <!-- TODO form error handling -->
                    <div class="form-group row">
                        <div class="col">
                            <label for="reg-username">Username:</label>
                            <input class="form-control" type="text" name="username" id="reg-username" placeholder="Username" value="<?php echo $user; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="reg-email">Email:</label>
                            <input class="form-control" type="email" name="email" id="reg-email" placeholder="user@example.com" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div><label>Name:</label></div>
                        <div class="col"><input type="text" name="fname" id="reg-fname" placeholder="First" value="<?php echo $fname; ?>"></div>
                        <div class="col"><input type="text" name="mname" id="reg-mname" placeholder="Middle" value="<?php echo $mname; ?>"></div>
                        <div class="col"><input type="text" name="lname" id="reg-lname" placeholder="Last" value="<?php echo $lname; ?>"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="reg-password">Password:</label>
                            <input class="form-control" type="password" name="password" id="reg-password" placeholder="Password">
                        </div>
                        <div class="col">
                            <label for="reg-cpassword">Confirm Password:</label>
                            <input class="form-control" type="password" name="cpassword" id="reg-cpassword" placeholder="Password">
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