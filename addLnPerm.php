<?php
session_start();
include("_sessionCheck.php");
if (!checkSession("index.php")) exit();
if ($_SESSION['UserID'] == "") {
    echo "<a href=\"login.php\">Please Login!</a>";
    session_destroy();
    exit();
}
if ($_SESSION['isLnEditable'] != true || $_SESSION['LineID'] == "") {
    echo "Permission deined<br>";
    echo "<a href=\"clearEditPerm.php\">Back</a>";
    exit();
}
include("i.php");

$UserID = (string)(int)mysqli_real_escape_string($dbConnect, trim($_POST["addUser"]));
if (!is_int((int)$UserID)) {
    echo "Permission deined<br>";
    echo "<a href=\"editLnPerm.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//Check user exist
$sqlStr = " SELECT UserID FROM user WHERE UserID = '" . $UserID . "'";
if (!mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
    echo "User not exist!";
    echo "<br><a href=\"editLnPerm.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//Check user is added
$sqlStr = " SELECT LnPermID FROM lnperm WHERE UserID_FK = '" . $UserID . "' AND LineID_FK = '" . $_SESSION['LineID'] . "'";
if (mysqli_fetch_array(mysqli_query($dbConnect, $sqlStr))) {
    echo "This user had been added!";
    echo "<br><a href=\"editLnPerm.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

$sqlStr = " INSERT INTO lnperm (LineID_FK, UserID_FK) VALUE ('" . $_SESSION['LineID'] . "', '" . $UserID . "') ";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error2: %s\n", mysqli_error($dbConnect));
    exit();
}
mysqli_close($dbConnect);
header("Location: editLnPerm.php");
