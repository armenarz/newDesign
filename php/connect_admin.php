<?php
$my_server = "localhost";
$my_user = "root";
$my_password = "konte13S";
$my_db = "promtest";
$link = mysqli_connect($my_server, $my_user, $my_password, $my_db);

if (!$link)
{
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
// echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
// echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
 
// mysqli_close($link);
?>