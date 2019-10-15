<?php

try {
    $dbvars = parse_url(getenv('DATABASE_URL'));

    $dbHost = $dbvars['host'];
    $dbPort = $dbvars['port'];
    $dbUser = $dbvars['user'];
    $dbPass = $dbvars['pass'];
    $dbName = ltrim($dbvars['path'], '/');

    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'ERROR: ' . $ex->getMessage();
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Andrew Schimelpfening" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Webpage</title>
</head>
<body>
    <h1>Scripture Resources</h1>
    <?php
    foreach ($db->query('SELECT * FROM scriptures', PDO::FETCH_ASSOC) as $row)
    {
        echo '<p><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '"</p>';
    }
    ?>
</body>
</html>