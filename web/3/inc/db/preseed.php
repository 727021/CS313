<?php

require_once('connect.php');

$queries = array(// Fill the database with preseed data
    "INSERT INTO Item (name, price, description) VALUES ('Test Item', 500, 'This is a test item.')",
    "SELECT * FROM Item"
);

$results = array();
for ($i = 0; $result = pg_query($db, $queries[$i]); $i++) {
    $results[$i] = $result;
}

pg_close($db);

foreach ($results as $result) {
    var_dump($result);
}

?>