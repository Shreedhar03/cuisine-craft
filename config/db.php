<!-- Database connectivity -->

<?php

$env = parse_ini_file('../.env');
$PG_URL = $env['PG_URL'];
$PG_OPTIONS = $env['PG_OPTIONS'];

$connection_string = $PG_URL . $PG_OPTIONS;
$PG_CONN = pg_connect($connection_string);

// Checking the connection
if (!$PG_CONN) {
    $_SESSION['error'] = "Error: Unable to open database";
    // echo "Error : Unable to open database\n";
} else {
    // echo "Opened database successfully\n";
}

?>