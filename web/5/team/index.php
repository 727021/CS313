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
    <h3>All Scriptures</h3>
    <?php
    foreach ($db->query('SELECT * FROM scriptures', PDO::FETCH_ASSOC) as $row)
    {
        echo '<p><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '"</p>';
    }
    ?>
    <br><br>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>Search for scriptures in a book:</p>
        <input type="text" name="book" id="book" placeholder="Book">
        <input type="submit" value="Search">
    </form>
    <br>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $book = htmlspecialchars(trim($_POST['book']));

        foreach ($db->query("SELECT * FROM scriptures WHERE book='$book'", PDO::FETCH_ASSOC) as $row)
        {
            echo '<p><a href="scripture.php?id=' . $row['id'] . '"><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b></a></p>';
        }
    }
    ?>
</body>
</html>