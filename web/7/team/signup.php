<?php

require 'db.php';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm = htmlspecialchars(trim($_POST['confirm']));

    if ($password !== $confirm) {
        array_push($errors, "Passwords don't match!");
    }
    if (strlen($password) < 7 || !preg_match('/\d/', $password)) {
        array_push($errors, "Password must be at least 7 characters and contain a number.");
    }
    if (count($errors) == 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
        $stmt = $db->prepare("INSERT into users (username, user_password) VALUES ( :user, :hash )");
        $stmt->bindValue(':user', $username, PDO::PARAM_STR);
        $stmt->bindValue(':hash', $hash, PDO::PARAM_STR);
        $stmt->execute();
        } catch (PDOException $ex) { die($ex->getMessage()); }

        header('location: login.php');
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Sign Up</title>
</head>
<body>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input class="form-control" type="text" name="username" id="username" placeholder="Username">
            <input class="form-control<?php if (count($errors) > 0) echo ' is-invalid'; ?>" type="password" name="password" id="password" placeholder="Password">
            <input class="form-control<?php if (count($errors) > 0) echo ' is-invalid'; ?>" type="password" name="confirm" id="confirm" placeholder="Confirm Password">
            <div class="invalid-feedback">
                <p style="display: none;" id="pass-match">Passwords don't match!</p>
                <p style="display: none;" id="pass-length">Password must be at least 7 characters and contain a number!</p>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="signup.js"></script>
</body>
</html>