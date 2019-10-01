<?php

require_once('connect.php');

$query = array(
    "CREATE TABLE Category (
        id_category SERIAL PRIMARY KEY,
        name VARCHAR(20) NOT NULL
    )",
    "CREATE TABLE Item (
        id_item SERIAL PRIMARY KEY,
        name VARCHAR(20) NOT NULL,
        price INTEGER NOT NULL,
        description TEXT,
        category INTEGER REFERENCES Category(id_category)
    )",
    "CREATE TABLE Review (
        id_review SERIAL PRIMARY KEY,
        name VARCHAR(20),
        stars SMALLINT DEFAULT 0,
        id_item INTEGER REFERENCES Item(id_item)
    )"
);

$results = array();
for ($i = 0; $result = pg_query($db, $query[$i]); $i++) {
    $results[$i] = $result;
}

var_dump($results);

?>