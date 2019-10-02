<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once('connect.php');
    $query = $_POST['query']; // I know this isn't secure at all; it's temporary.
    $result = pg_query($db, str_replace(';', '', $query));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Andrew Schimelpfening" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Run Query</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>Enter a single query, without a semicolon at the end:</p>
        <textarea name="query" id="" cols="30" rows="10" placeholder="PostgreSQL query..."></textarea>
        <input type="submit" name="submit" value="Query">
    </form>
    <p>Result:</p>
    <br>
    <p><?php if (isset($result)) var_dump(pg_fetch_all($result)); ?></p>
</body>
</html>