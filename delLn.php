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

$EditID = (string)(int)mysqli_real_escape_string($dbConnect, trim($_GET['EditID']));
if (!is_int((int)$EditID)) {
    echo "Permission deined<br>";
    echo "<a href=\"clearEditPerm.php\">Back</a>";
    mysqli_close($dbConnect);
    exit();
}

//just hide dont del อิ_อิ

$sqlStr = "UPDATE lnedit SET LnNum = '-1' WHERE EditID = '" . $EditID . "' AND LineID_FK = '" . $_SESSION["LineID"] . "'";
$sqlQuery = mysqli_query($dbConnect, $sqlStr);
if (!$sqlQuery) {
    printf("Error1: %s\n", mysqli_error($dbConnect));
    exit();
}

mysqli_close($dbConnect);
header("Location: clearEditPerm.php");
