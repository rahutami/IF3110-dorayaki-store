<?php
require_once('db\dbconnection.php');

$db = (new DBConnection())->connect();
if ($db != null)
    echo 'Connected to the SQLite database successfully!';
else
    echo 'Whoops, could not connect to the SQLite database!';

// To exec $db->exec()
?>