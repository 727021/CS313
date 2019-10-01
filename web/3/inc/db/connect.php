<?php

$db = null;
{
    $host = "ec2-54-235-181-55.compute-1.amazonaws.com";
    $database = "d602ofmackjq9";
    $user = "cqdclqhxhforuy";
    $port = "5432";
    $pass = "b55bb9d3d3b834d50b631d7fdddd5b6d087f57cf1abb8fb89bb85c360fe8938e";

    $db = pg_connect("host=$host port=$port dbname=$database user=$user password=$pass") or die("Unable to connect to database.");
}

var_dump($db);

?>