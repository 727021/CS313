<?php

require_once('connect.php');

$queries = array(// Fill the database with preseed data
    "INSERT INTO Array_Lookup VALUES (0,'Item','id_item')",
    "INSERT INTO Array_Lookup VALUES (1,'Item','name')",
    "INSERT INTO Array_Lookup VALUES (2,'Item','price')",
    "INSERT INTO Array_Lookup VALUES (3,'Item','description')",
    "INSERT INTO Array_Lookup VALUES (4,'Item','category')",
    "INSERT INTO Array_Lookup VALUES (0,'Category','id_category')",
    "INSERT INTO Array_Lookup VALUES (1,'Category','name')",
    "INSERT INTO Array_Lookup VALUES (0,'Review','id_review')",
    "INSERT INTO Array_Lookup VALUES (1,'Review','name')",
    "INSERT INTO Array_Lookup VALUES (2,'Review','stars')",
    "INSERT INTO Array_Lookup VALUES (3,'Review','id_item')"
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