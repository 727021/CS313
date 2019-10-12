<?php

$db = null;

$db_host = "ec2-54-235-181-55.compute-1.amazonaws.com";
$db_database = "d602ofmackjq9";
$db_user = "cqdclqhxhforuy";
$db_port = "5432";
$db_pass = "b55bb9d3d3b834d50b631d7fdddd5b6d087f57cf1abb8fb89bb85c360fe8938e";

$db = pg_connect("host=$db_host port=$db_port dbname=$db_database user=$db_user password=$db_pass") or die("Unable to connect to database.");

?>