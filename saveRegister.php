<?php
include("i.php");

$username = mysqli_real_escape_string($dbConnect, trim($_POST['Username']));
$password = mysqli_real_escape_string($dbConnect, trim($_POST['Password']));
$passwordConfrim = mysqli_real_escape_string($dbConnect, trim($_POST['PasswordConfirm']));

//check is user input username password passwordConfrim
if ($username == "" || $password == "" || $passwordConfrim == "") {
    echo "Please input Username/Password<br>";
    echo "<a href=\"register.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//check is password == passwordConfrim
if ($password != $passwordConfrim) {
    echo "Password not match!<br>";
    echo "<a href=\"register.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//check is password >= 8 char
if (strlen($password) < 8) {
    echo "Password have to be at least 8 characters long!<br>";
    echo "<a href=\"register.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//check is username been used
$sqlStr = "SELECT UserID FROM user WHERE Username ='" . $username . "'";
if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
    echo "Username had been used!<br>";
    echo "<a href=\"register.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//hashing password
$hash = password_hash($password, PASSWORD_DEFAULT);

//save new user
$sqlStr = "INSERT INTO user (Username, Password) VALUE ('" . $username . "', '" . $hash . "')";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
echo "New User had been created!<br>";
echo "<a href=\"login.php\">Back</a>";

mysqli_close($dbConnect);
