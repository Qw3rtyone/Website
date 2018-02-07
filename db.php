<?php

// Provide more information if something is wrong with your code:
error_reporting(-1);
ini_set('display_errors', 'On');
// Settings used to connect to the database:

include 'creds.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_errno)
{
    echo "failed to connect to database";
}
?>