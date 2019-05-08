<?php
session_start();
include("_sessionCheck.php");
include("i.php");

$username = mysqli_real_escape_string($dbConnect, trim($_POST['Username']));
$password = mysqli_real_escape_string($dbConnect, trim($_POST['Password']));

if ($username == "" || $password == "") {
    echo "Please input Username/Password<br>";
    echo "<a href=\"login.php\">Back</a>";
    session_destroy();
    mysqli_close($dbConnect);
    exit();
}

$sqlStr = "SELECT * FROM user WHERE Username = '" . $username . "'";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
//check is user exist
if (!$sqlResult = mysqli_fetch_array($sqlQuery)) {
    echo "Username/Password invaild<br>";
    echo "<a href=\"login.php\">Back</a>";
    session_destroy();
} else {
    //check is password match
    if (password_verify($password, $sqlResult['Password'])) {
        createSession();
        $_SESSION['UserID'] = $sqlResult['UserID'];
        header("Location: notelist.php");
    } else {
        echo "Username/Password invaild<br>";
        echo "<a href=\"login.php\">Back</a>";
        session_destroy();
    }
}
mysqli_close($dbConnect);
