<?php

require_once('connect.php');

$queries = array(// Fill the database with preseed data
);

$results = array();
for ($i = 0; $result = pg_query($db, $queries[$i]); $i++) {
    $results[$i] = $result;
}

pg_close($db);

foreach ($results as $result) {
    var_dump(pg_fetch_row($result));
    echo '<br>';
}

?>