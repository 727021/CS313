<?php

require_once('connect.php');

$query = array(
    "CREATE TABLE IF NOT EXISTS Category (
        id_category SERIAL PRIMARY KEY,
        name VARCHAR(20) NOT NULL
    )",
    "CREATE TABLE IF NOT EXISTS Item (
        id_item SERIAL PRIMARY KEY,
        name VARCHAR(20) NOT NULL,
        price INTEGER NOT NULL,
        description TEXT,
        category INTEGER REFERENCES Category(id_category)
    )",
    "CREATE TABLE IF NOT EXISTS Review (
        id_review SERIAL PRIMARY KEY,
        name VARCHAR(20),
        stars SMALLINT DEFAULT 0,
        id_item INTEGER REFERENCES Item(id_item)
    )",
    "CREATE TABLE IF NOT EXISTS Array_Lookup (
        index INTEGER NOT NULL,
        context VARCHAR(16) NOT NULL,
        data VARCHAR(30) NOT NULL,
        PRIMARY KEY (index,context)
    )"
);

$results = array();
for ($i = 0; $result = pg_query($db, $query[$i]); $i++) {
    $results[$i] = $result;
}

pg_close($db);

var_dump($results);

?>