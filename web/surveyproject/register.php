<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
    exit;
}

$user = $email = $fname = $lname = $pass = $cpass = "";   // Form data
$euser = $eemail = $efname = $elname = $epass = $ecpass = "";   // Form errors
$error = false; // Whether there were any errors in the form (easier to set this than to check every error string)
$posted = false; // Was the form submitted? Used for validation styles.

// Validation only happens on the server. I might add client validation later,
// but I don't have time to now.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $posted = true;
    $user = trim(htmlspecialchars($_POST['username']));
    $email = trim(htmlspecialchars($_POST['email']));
    $fname = trim(htmlspecialchars($_POST['fname']));
    $lname = trim(htmlspecialchars($_POST['lname']));
    $pass = trim(htmlspecialchars($_POST['password']));
    $cpass = trim(htmlspecialchars($_POST['cpassword']));

    require_once 'inc/db.inc.php';

    // Check username
    if ($user === "") { // Empty username
        $error = true;
        $euser = "Enter a username.";
    } elseif (!preg_match('/\w+/', $user) || preg_match('/\s+/', $user)) { // Invalid username
        $error = true;
        $euser = "Username is invalid. (Must contain only letters, numbers, and _)";
    } else { // Taken username
        $stmt_user = $db->prepare('SELECT user_id FROM surveys.users WHERE username=:user LIMIT 1');
        $stmt_user->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt_user->execute();

        if (count($stmt_user->fetchAll(PDO::FETCH_COLUMN, 0)) > 0) {
            $error = true;
            $euser = "That username is taken.";
        }
    }

    // Check email
    if ($email === "") { // Empty email
        $error = true;
        $eemail = "Enter an email address.";
    } elseif (preg_match('/\s+/', $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { // Invalid email
        $error = true;
        $eemail = "Email address is invalid.";
    } else { // Taken email
        $stmt_email = $db->prepare('SELECT user_id FROM surveys.users WHERE email=:email LIMIT 1');
        $stmt_email->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt_email->execute();

        if (count($stmt_email->fetchAll(PDO::FETCH_COLUMN, 0)) > 0) {
            $error = true;
            $eemail = "There is already an account with that email address.";
        }
    }

    // Check first name
    if ($fname === "") { // Empty first name
        $error = true;
        $efname = "Enter your first name.";
    }

    // Check last name
    if ($lname === "") { // Empty last name
        $error = true;
        $elname = "Enter your last name.";
    }

    // Check password
    if (strlen($pass) < 8) { // Invalid password
        $error = true;
        $epass = "Password must be at least 8 characters long.";
    }

    // Check confirm password
    if ($cpass !== $pass) { // Password's don't match
        $error = true;
        $ecpass = "Password doesn't match.";
    }

    if (!$error) { // No errors, actually create the account
        $stmt_reg = $db->prepare("INSERT INTO surveys.users ( username, email, first, last, hash, type ) VALUES ( :user, :email, :fname, :lname, :hash, (SELECT common_lookup_id FROM surveys.common_lookup WHERE context = 'USER.TYPE' AND value = 'DEFAULT'))");
        $stmt_reg->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt_reg->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt_reg->bindValue(':fname', $fname, PDO::PARAM_STR);
        $stmt_reg->bindValue(':lname', $lname, PDO::PARAM_STR);
        $stmt_reg->bindValue(':hash', password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
        if ($stmt_reg->execute()) {
            header('location: login.php?reg');
        } else {

        }
    }
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
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($euser === "") ? ' is-valid' : ' is-invalid'); } ?>" type="text" name="username" id="reg-username" placeholder="Username" value="<?php echo $user; ?>">
                            <?php if ($posted && $euser !== "") { echo "<div class=\"invalid-feedback\">$euser</div>"; } ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($eemail === "") ? ' is-valid' : ' is-invalid'); } ?>" type="email" name="email" id="reg-email" placeholder="user@example.com" value="<?php echo $email; ?>">
                            <?php if ($posted && $eemail !== "") { echo "<div class=\"invalid-feedback\">$eemail</div>"; } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($efname === "") ? ' is-valid' : ' is-invalid'); } ?>" type="text" name="fname" id="reg-fname" placeholder="First name" value="<?php echo $fname; ?>">
                            <?php if ($posted && $efname !== "") { echo "<div class=\"invalid-feedback\">$efname</div>"; } ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted) { echo (($elname === "") ? ' is-valid' : ' is-invalid'); } ?>" type="text" name="lname" id="reg-lname" placeholder="Last name" value="<?php echo $lname; ?>">
                            <?php if ($posted && $elname !== "") { echo "<div class=\"invalid-feedback\">$elname</div>"; } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted && $epass !== "") { echo ' is-invalid'; } ?>" type="password" name="password" id="reg-password" placeholder="Password">
                            <?php if ($posted && $epass !== "") { echo "<div class=\"invalid-feedback\">$epass</div>"; } ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input class="form-control<?php if ($posted && $ecpass !== "") { echo ' is-invalid'; } ?>" type="password" name="cpassword" id="reg-cpassword" placeholder="Confirm password">
                            <?php if ($posted && $ecpass !== "") { echo "<div class=\"invalid-feedback\">$ecpass</div>"; } ?>
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