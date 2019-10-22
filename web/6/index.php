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
    <title>Insert</title>
</head>
<body>
    <form action="index.php" method="POST">
        <input type="text" name="book" id="book" placeholder="Book">
        <input type="text" name="chapter" id="chapter" placeholder="Chapter">
        <input type="text" name="verse" id="verse" placeholder="Verse">
        <textarea name="content" id="content" placeholder="Content">

        </textarea>
<?php
        foreach($db->query('Select name FROM topic', PDO::FETCH_ASSOC) as $row){
            echo "<label> " . $row['name'] . " <input type='checkbox' name='topic[]' value='" . $row['name'] . "'> </label>";
        }
?>

        <input type="checkbox" name="newTopic" id="newTopic">
        <input type="text" name="topicText" id="topicText" placeholder="New Topic">

        <input type="submit" value="submit">

    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        var_dump($_POST);

        $book = $_POST["book"];
        $chapter = $_POST["chapter"];
        $verse = $_POST["verse"];
        $content = $_POST["content"];
        $topic = $_POST["topic"];
        $newTopic = $_POST["newTopic"];

        $db->query("INSERT INTO scriptures (book, chapter, verse, content) VALUES
        ( '$book'
        , $chapter
        , $verse
        , '$content'
        )");

        if($_POST['newTopic'] == "on"){
            $topicText = $_POST["topicText"];

            $db->query("INSERT INTO topic (name) VALUES ($topicText)");

            $db->query("INSERT INTO links (topic, scripture) VALUES
            ( currval('topic_id_seq')
            , currval('scriptures_id_seq'))"
            );
        }

        foreach($topic as $checked){
            $db->query("INSERT INTO links (topic, scripture) VALUES
                ((SELECT id FROM topic WHERE name = '$checked')
                , currval('scriptures_id_seq'))"
                );
        }
    }

    foreach($db->query('SELECT * FROM scriptures', PDO::FETCH_ASSOC) as $row)
    {
        echo '<p><b>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</b> - "' . $row['content'];

        foreach($db->query('SELECT t.name FROM topic t, links l
        WHERE t.id = l.topic AND l.scripture = ' . $row['id'], PDO::FETCH_ASSOC) as $topic ){
            echo ' ' . $topic['name'] ;
        }
        echo '</p>';
    }

?>
</body>
</html>