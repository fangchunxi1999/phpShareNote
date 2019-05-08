<?php

define('servername', '');
define('username', '');
define('password', '');
define('dbname', '');
$dbConnect = mysqli_connect(servername, username, password, dbname);
if (!$dbConnect) {
    die("Fail:" . mysqli_connect_error());
}

mysqli_query($dbConnect, "SET time_zone = '+7:00'");
