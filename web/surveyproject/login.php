<?php
session_start();

$user = $pass = "";   // Form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize input
    $user = filter_var($_POST['username']);
    $pass = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : false;

    if ($user !== false && $pass !== false) {
        require_once 'inc/db_connect.php';
        $result = pg_fetch_assoc(pg_query($db, "SELECT user_id AS id FROM users WHERE username = $user AND hash = $pass"));
        pg_close($db);

        if ($result !== false) {
            // Log the user in
            $_SESSION['user'] = $result['id'];
        }
    }
}

?>