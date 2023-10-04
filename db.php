<!-- php code for database connection -->
<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "memento";
// Create connection
$conn = mysqli_connect($server, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>