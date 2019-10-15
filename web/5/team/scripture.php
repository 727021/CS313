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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Team Activity</title>
</head>
<body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = htmlspecialchars(trim($_GET['id']));

            $stmt = $db->prepare('SELECT * FROM scriptures WHERE id=:id LIMIT 1');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            echo '<p><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'] . '"</p>';
        } else {
            header('location: index.php');
        }
    ?>
    <a href="index.php">Back to Search</a>
</body>
</html>